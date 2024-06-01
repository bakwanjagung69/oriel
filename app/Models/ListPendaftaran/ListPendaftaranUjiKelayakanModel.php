<?php

namespace App\Models\ListPendaftaran;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class ListPendaftaranUjiKelayakanModel extends Model {
  protected $table = 'formulir_uji_kelayakan';
  protected $builder;
  protected $directoryUploadedSuratTugas = 'assets/upload/surat-tugas/';

  protected $column_order = [
    'id', 
    'nama', 
    'nim', 
    'judul', 
    'files', 
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'nama', 
    'nim', 
    'judul', 
    'files'
  ];
  protected $order = ['id' => 'DESC'];
  protected $request;
  protected $db;
  protected $dt;
  protected $session;
  protected $classesModel;

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
  }

  private function getDatatablesQuery() {
    $i = 0;
    foreach ($this->column_search as $item) {
        if ($this->request->getPost('search')['value']) {
            if ($i === 0) {
                $this->dt->groupStart();
                $this->dt->like($item, $this->request->getPost('search')['value']);
            } else {
                $this->dt->orLike($item, $this->request->getPost('search')['value']);
            }
            if (count($this->column_search) - 1 == $i)
            $this->dt->groupEnd();
        }
        $i++;
    }

    if ($this->request->getPost('order')) {
        $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
    } else if (isset($this->order)) {
        $order = $this->order;
        $this->dt->orderBy(key($order), $order[key($order)]);
    }
  }

  public function getDatatables(){
    $this->getDatatablesQuery();
    if ($this->request->getPost('length') != -1) $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    
    if ($this->request->getPost('semester') !== '') {
      $query = $this->dt->getWhere([
        'semester' => $this->request->getPost('semester')
      ]);
    } else {
      $query = $this->dt->get();
    }
    
    return $query->getResult();
  }

  public function countFiltered() {
    $this->getDatatablesQuery();
    return $this->dt->countAllResults();
  }

  public function countAll() {
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }

  public function getById($id) {
    $ids = $this->classesModel->decrypter($id);

    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('id, nama, nim, judul, files');
    $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    return $resultData;
  }

  public function checkTotalPenugasanDosenPenguji($kaprodi_id, $formulir_uji_kelayakan_id, $tabelName) {
    $kaprodi_id = $this->classesModel->decrypter($kaprodi_id);
    $formulir_uji_kelayakan_id = $this->classesModel->decrypter($formulir_uji_kelayakan_id);

    $getQuery = $this->db->table($tabelName);
    $getQuery->select('COUNT(id) as total_dosen_penguji');
    $resultData = $getQuery->getWhere([
      'kaprodi_id' => $kaprodi_id,
      'formulir_uji_kelayakan_id' => $formulir_uji_kelayakan_id
    ])->getRowArray();
    return intval($resultData['total_dosen_penguji']);
  }

  public function AddNewDataPenugasanDosenPenguji($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    $validInput = $this->checkTotalPenugasanDosenPenguji($this->classesModel->encrypter($this->getKaprodiId()), $data['uji_kelayakan_id'], 'penugasan_dosen_penguji_uji_kelayakan');

    if ($validInput > 3 && $validInput !== 0) {
      return array("code" => 304, "response" => 'Penugasan dosen penguji sudah berjumlah 3');
      exit();
    }

    for ($i=0; $i < count($__data); $i++) { 
      $insertPenugasanDosenPenguji = $this->db->table('penugasan_dosen_penguji_uji_kelayakan')->insert([
        'formulir_uji_kelayakan_id' => $this->classesModel->decrypter($__data[$i]->uji_kelayakan_id),
        'kaprodi_id' => $this->classesModel->decrypter($__data[$i]->kaprodi_id),
        'dosen_id' => $this->classesModel->decrypter($__data[$i]->dosen_id),
        'type_penugasan' => $__data[$i]->type_penugasan,
        'createBy' => $userId,
        'createDate' => $dateNow
      ]);

      $lastUserId = $this->db->insertID();

      if ($insertPenugasanDosenPenguji == 1) {
         $sql = "UPDATE
            `formulir_uji_kelayakan`
          SET
            `status` = '2',
            `updateBy` = '{$userId}',
            `updateDate` = '{$dateNow}'
          WHERE `id` = '{$this->classesModel->decrypter($__data[$i]->uji_kelayakan_id)}'";
          $resultUPdateStatusUjiKelayakanMhs = $this->db->query($sql);

          if ($resultUPdateStatusUjiKelayakanMhs == 1) {
             $response = array("code" => 201, "response" => 'Data Berhasil terkirim ke admin TU untuk dibuatkan surat tugas!');
          } else {
            $response = array("code" => 500, "response" => 'Internal Server Error');
          }
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    }

    return $response;
  }

  public function DeletePenugasanDosenPenguji($data) {
    $id = $this->classesModel->decrypter($data['items']['id']);

    $getQuery = $this->db->table('penugasan_dosen_penguji_uji_kelayakan');
    $resultData = $getQuery->delete(['id' => $id]);

    $response = '';
    if ($resultData == 1) {
      $response = array("code" => 200, "response" => 'Data Deleted successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    
    return $response;
  }

  public function getPenugasanDosenPenguji($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_uji_kelayakan_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function addSuratTugas($data) {
    date_default_timezone_set("Asia/Bangkok");
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $ujiKelayakanId = $this->classesModel->decrypter($data['items']['ujiKelayakanId']);

    $getQueryFormUjiKelayakan = $this->db->table('formulir_uji_kelayakan');
    $resultDataUjiKelayakan = $getQueryFormUjiKelayakan->getWhere(['id' => $ujiKelayakanId])->getRowArray();

    $getQueryUserData = $this->db->table('user');
    $resultUserData = $getQueryUserData->getWhere(['nim' => $resultDataUjiKelayakan['nim']])->getRowArray();

    $mhsId = $resultUserData['id'];
    $judul = $data['items']['judul'];
    $semester = intval($data['items']['semester']);
    $response = '';

    if ($data['files']['surat_tugas_file_to_mahasiswa']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    $_thumbDirSuratTugasMhs = '';
    $_thumbFileSuratTugasMhs = '';

    if ($data['files']['surat_tugas_file_to_mahasiswa']['name'] !== '') {
      $validSuratTugasMhs = true;
      $filesSuratTugasMhs = explode('.', $data['files']['surat_tugas_file_to_mahasiswa']['name']);
      $countArrSuratTugasMhs = (count($filesSuratTugasMhs) - 1);
      
      switch ($filesSuratTugasMhs[$countArrSuratTugasMhs]) {
        case 'pdf':
         $validSuratTugasMhs = true;
        break;
      //   case 'xls':
      //     $validSuratTugasMhs = false;
      //   break;
      //   case 'xlsx':
      //     $validSuratTugasMhs = false;
      //   break;
      //   case 'doc':
      //     $validSuratTugasMhs = false;
      //   break;
      //   case 'txt':
      //     $validSuratTugasMhs = false;
      //   break;
      //   case 'ppt':
      //     $validSuratTugasMhs = false;
      //   break;
      //   case 'pptx':
      //     $validSuratTugasMhs = false;
      //   break;
      //   default:
      //     $validSuratTugasMhs = true;
      //   break;
      }

      if ($validSuratTugasMhs) {
        $uploaddirSuratTugasMhs  = $this->directoryUploadedSuratTugas;
        $fileNameSuratTugasMhs   = rand(1000,100000).'-'.$data['files']['surat_tugas_file_to_mahasiswa']['name'];
        $fileTmpSuratTugasMhs    = $data['files']['surat_tugas_file_to_mahasiswa']['tmp_name'];
        $fileSizeSuratTugasMhs   = $data['files']["surat_tugas_file_to_mahasiswa"]['size'];
        $fileExtArrSuratTugasMhs = explode('.',$fileNameSuratTugasMhs);
        $fileExtSuratTugasMhs    = strtolower(end($fileExtArrSuratTugasMhs));
        $uploadfileSuratTugasMhs = $uploaddirSuratTugasMhs . $fileNameSuratTugasMhs;
 
        //validate file size
        if ($fileSizeSuratTugasMhs == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          return array("code" => 400, "response" => $errors);
        }

        if($fileSizeSuratTugasMhs > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
          $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
          return array("code" => 400, "response" => $errors);
        }

        $_thumbDirSuratTugasMhs = $uploaddirSuratTugasMhs.'/thumbnails/'.'thumb-'.$fileNameSuratTugasMhs;
        $_thumbFileSuratTugasMhs = 'thumbnails/thumb-'.$fileNameSuratTugasMhs;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }

      $insertSuratTugasMhs = $this->db->table('surat_tugas')->insert([
        'uji_kelayakan_id' => $ujiKelayakanId,
        'assigment_from_user_id' => $userId,
        'assigment_to_user_id' => $mhsId,
        'mahasiswa_id' => $mhsId,
        'judul' => $judul,
        'surat_tugas_to_mahasiswa_files' => $fileNameSuratTugasMhs,
        'status' => '1',
        'createBy' => $userId,
        'createDate' => $dateNow
      ]);

      $lastId = $this->db->insertID();

      if ($insertSuratTugasMhs == 1) {
        if ($data['files']['surat_tugas_file_to_mahasiswa']['name'] !== '') {
          $moveUpload = move_uploaded_file($fileTmpSuratTugasMhs, $uploadfileSuratTugasMhs);       
        }

        $dataListSuratTugasDosen = $data['items']['dosenId'];

        for ($i=0; $i < count($dataListSuratTugasDosen); $i++) { 
          $dosenID = $dataListSuratTugasDosen[$i];

          if ($data['files']['surat_tugas_file_to_list_dosen']['error'][$i] == '1') {
            return $this->classesModel->msgCheckingUploadSize();
            exit();
          }

          $_thumbDirSuratTugasDosen = '';
          $_thumbFileSuratTugasDosen = '';

          if ($data['files']['surat_tugas_file_to_list_dosen']['name'][$i] !== '') {
            $validSuratTugasDosen = true;
            $filesSuratTugasDosen = explode('.', $data['files']['surat_tugas_file_to_list_dosen']['name'][$i]);
            $countArrSuratTugasDosen = (count($filesSuratTugasDosen) - 1);
            
            switch ($filesSuratTugasDosen[$countArrSuratTugasDosen]) {
              case 'pdf':
               $validSuratTugasDosen = true;
              break;
            //   case 'xls':
            //     $validSuratTugasDosen = false;
            //   break;
            //   case 'xlsx':
            //     $validSuratTugasDosen = false;
            //   break;
            //   case 'doc':
            //     $validSuratTugasDosen = false;
            //   break;
            //   case 'txt':
            //     $validSuratTugasDosen = false;
            //   break;
            //   case 'ppt':
            //     $validSuratTugasDosen = false;
            //   break;
            //   case 'pptx':
            //     $validSuratTugasDosen = false;
            //   break;
            //   default:
            //     $validSuratTugasDosen = true;
            //   break;
            }

            if ($validSuratTugasDosen) {
              $uploaddirSuratTugasDosen  = $this->directoryUploadedSuratTugas;
              $fileNameSuratTugasDosen   = rand(1000,100000).'-'.$data['files']['surat_tugas_file_to_list_dosen']['name'][$i];
              $fileTmpSuratTugasDosen    = $data['files']['surat_tugas_file_to_list_dosen']['tmp_name'][$i];
              $fileSizeSuratTugasDosen   = $data['files']["surat_tugas_file_to_list_dosen"]['size'][$i];
              $fileExtArrSuratTugasDosen = explode('.',$fileNameSuratTugasDosen);
              $fileExtSuratTugasMhsDosen    = strtolower(end($fileExtArrSuratTugasDosen));
              $uploadfileSuratTugasMhsDosen = $uploaddirSuratTugasDosen . $fileNameSuratTugasDosen;
       
              //validate file size
              if ($fileSizeSuratTugasDosen == 0) { /** If config php.ini standart 2MB */
                $errors = 'Image maximum 2MB files are allowed';
                return array("code" => 400, "response" => $errors);
              }

              if($fileSizeSuratTugasDosen > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
                $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
                return array("code" => 400, "response" => $errors);
              }

              $_thumbDirSuratTugasMhs = $uploaddirSuratTugasDosen.'/thumbnails/'.'thumb-'.$fileNameSuratTugasDosen;
              $_thumbFileSuratTugasMhs = 'thumbnails/thumb-'.$fileNameSuratTugasDosen;
            } else {
              return array("code" => 500, "response" => 'Incompatible file format!');
              exit();
            }

            $insertSuratTugas = $this->db->table('surat_tugas')->insert([
              'uji_kelayakan_id' => $ujiKelayakanId,
              'assigment_from_user_id' => $userId,
              'assigment_to_user_id' => $this->classesModel->decrypter($dosenID),
              'mahasiswa_id' => $mhsId,
              'judul' => $judul,
              'surat_tugas_to_dosen_files' => $fileNameSuratTugasDosen,
              'status' => '1',
              'createBy' => $userId,
              'createDate' => $dateNow
            ]);

            $lastId = $this->db->insertID();

            if ($insertSuratTugas == 1) {
              if ($data['files']['surat_tugas_file_to_list_dosen']['name'][$i] !== '') {
                $moveUpload = move_uploaded_file($fileTmpSuratTugasDosen, $uploadfileSuratTugasMhsDosen);       
              }

              $sql = "UPDATE
                `formulir_uji_kelayakan`
              SET
                `status` = '3',
                `semester` = '{$semester}',
                `updateBy` = '{$userId}',
                `updateDate` = '{$dateNow}'
              WHERE `id` = '{$ujiKelayakanId}'";
              $resultUPdateStatusUjiKelayakanMhs = $this->db->query($sql);

              if ($resultUPdateStatusUjiKelayakanMhs == 1) {
                 $response = array("code" => 201, "response" => 'Silahkan menunggu dan beralih ke halaman hasil penilaian uji kelayakan!');
              } else {
                $response = array("code" => 500, "response" => 'Internal Server Error');
              }
            } else {
              $response = array("code" => 500, "response" => 'Internal Server Error');
            }
          }
        }
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    }
    return $response;
  }

  public function getKaprodiId() {
    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['rules' => '4'])->getRowArray();
    return $resultData['id'];
  }

}