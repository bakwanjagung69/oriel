<?php

namespace App\Models\HasilPenilaianJudul;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class HasilPenilaianJudulModel extends Model {
  protected $table = 'formulir_uji_kelayakan';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/surat-kelayakan-judul-bimbingan/';
  protected $directoryUploadedSuratTugasBimbingan = 'assets/upload/surat-tugas-bimbingan/';

  protected $column_order = [
    'id', 
    'nama', 
    'nim', 
    'judul',
    'files',
    'semester',
    'status',
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'nama', 
    'nim', 
    'judul',
    'files',
    'semester',
    'status',
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
      $getQuery = $this->dt->select('*');
      // $getQuery = $getQuery->groupBy('mahasiswa_id');
      $queryRes = $getQuery->where("`status` IN ('3', '4', '5', '6', '7', '0') AND `semester` = '".$this->request->getPost('semester')."'")->get();
    } else {
      $getQuery = $this->dt->select('*');
      // $getQuery = $getQuery->groupBy('mahasiswa_id');
      $queryRes = $getQuery->where("`status` IN ('3', '4', '5', '6', '7', '0')")->get();
    }

    return $queryRes->getResult();
  }

  public function countFiltered() {
    $this->getDatatablesQuery();
    return $this->dt->countAllResults();
  }

  public function countAll() {
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }

  public function getUserData($id) {
    $_id = $this->classesModel->decrypter($id);

    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['id' => $_id])->getRowArray();
    return $resultData;
  }

  public function getUserDataByNim($nim) {
    // $_nim = $this->classesModel->decrypter($nim);

    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $nim])->getRowArray();
    return $resultData;
  }

  public function getDataFormUjiKelayakanByNim($nim) {
    // $_nim = $this->classesModel->decrypter($nim);

    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $nim])->getRowArray();
    return $resultData;
  }

  public function getDataFormUjiKelayakanById($id) {
    // $_id = $this->classesModel->decrypter($id);

    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['id' => $id])->getRowArray();
    return $resultData;
  }

  public function getDataPenilaianUjiKelayakanJudulByMhsIdAndUjiKelayakanId($mahasiswa_id, $uji_kelayakan_id) {

    $getQuery = $this->db->table('penilaian_uji_kelayakan');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere([
      'mahasiswa_id' => $mahasiswa_id,
      'uji_kelayakan_id' => $uji_kelayakan_id
    ])->getResult();
    return $resultData;
  }

  public function checkDataHasilForMahasiswa($mahasiswa_id, $uji_kelayakan_id) {
    $mahasiswa_id = $this->classesModel->decrypter($mahasiswa_id);
    $uji_kelayakan_id = $this->classesModel->decrypter($uji_kelayakan_id);

    $getQuery = $this->db->table('penilaian_uji_kelayakan');
    $getQuery->select('*');
    $getQuery->getWhere([
      'uji_kelayakan_id' => $uji_kelayakan_id,
      'mahasiswa_id' => $mahasiswa_id
    ]);

    $valid = ($getQuery->countAll() > 0) ? true : false;
    return $valid;
  }

  public function getDataHasilPenilaianForMahasiswa($mahasiswa_id, $uji_kelayakan_id) {
    // $mahasiswa_id = $this->classesModel->decrypter($mahasiswa_id);
    // $uji_kelayakan_id = $this->classesModel->decrypter($uji_kelayakan_id);

    $getQuery = $this->db->table('penilaian_uji_kelayakan');
    $getQuery->select('*');
    $result = $getQuery->getWhere([
      'uji_kelayakan_id' => $uji_kelayakan_id,
      'mahasiswa_id' => $mahasiswa_id
    ])->getResult();

    return $result;
  }

  public function insertDataSuratKelayakanJudul($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    if ($data['files']['surat_tugas_kelayakan_judul']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $_thumbDir = '';
    $_thumbFile = '';

    if ($data['files']['surat_tugas_kelayakan_judul']['name'] !== '') {
      $valid = false;

      $valid = true;
      $files = explode('.', $data['files']['proposal_file']['name']);
      $countArr = (count($files) - 1);
      
      switch ($files[$countArr]) {
        case 'pdf':
         $valid = false;
        break;
      //   case 'xls':
      //     $valid = false;
      //   break;
      //   case 'xlsx':
      //     $valid = false;
      //   break;
      //   case 'doc':
      //     $valid = false;
      //   break;
      //   case 'txt':
      //     $valid = false;
      //   break;
      //   case 'ppt':
      //     $valid = false;
      //   break;
      //   case 'pptx':
      //     $valid = false;
      //   break;
      //   default:
      //     $valid = true;
      //   break;
      }

      if ($valid) {
        $uploaddir  = $this->directoryUploaded;
        $fileName   = rand(1000,100000).'-'.$data['files']['surat_tugas_kelayakan_judul']['name'];
        $fileTmp    = $data['files']['surat_tugas_kelayakan_judul']['tmp_name'];
        $fileSize   = $data['files']["surat_tugas_kelayakan_judul"]['size'];
        $fileExtArr = explode('.',$fileName);
        $fileExt    = strtolower(end($fileExtArr));
        $uploadfile = $uploaddir . $fileName;
 
        //validate file size
        if ($fileSize == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        if($fileSize > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
          $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        $_thumbDir = $uploaddir.'/thumbnails/'.'thumb-'.$fileName;
        $_thumbFile = 'thumbnails/thumb-'.$fileName;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }
    }

    $kaprodiId = $this->getKaprodiId();
    $insertSuratKelayakanJudul = $this->db->table('pengajuan_dosen_pembimbing')->insert([
      'uji_kelayakan_id' => $data['items']['uji_kelayakan_id'],
      'kaprodi_id' => $kaprodiId,
      'mahasiswa_id' => $data['items']['mahasiswa_id'],
      'judul' => $data['items']['judul'],
      'status' => '1',
      'surat_tugas_kelayakan_judul' => $fileName,
      'createBy' => $userId,
      'createDate' => $dateNow
    ]);

    $lastUserId = $this->db->insertID();

    if ($insertSuratKelayakanJudul == 1) {

      $sql = "UPDATE
        `penilaian_uji_kelayakan`
      SET
        `status` = '2',
        `updateBy` = '{$userId}',
        `updateDate` = '{$dateNow}'
      WHERE `mahasiswa_id` = '{$data['items']['mahasiswa_id']}'";
      $resultUPdatePenilaian = $this->db->query($sql);

      if ($resultUPdatePenilaian == 1) {
        if ($data['files']['surat_tugas_kelayakan_judul']['name'] !== '') {
          $moveUpload = move_uploaded_file($fileTmp, $uploadfile);       
        }

        $response = array("code" => 201, "response" => 'Data saved successfully!');
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }

    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }

    return $response;

  }

  private function getKaprodiId() {
    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['rules' => '4'])->getRowArray();
    return $resultData['id'];
  }

  public function getDataPenhajuanDosenPembimbing($ujiKelayakanId, $mahasiswa_id) {
    // $_id = $this->classesModel->decrypter($id);

    $getQuery = $this->db->table('pengajuan_dosen_pembimbing');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere([
      'uji_kelayakan_id' => $ujiKelayakanId,
      'mahasiswa_id' => $mahasiswa_id
    ])->getRowArray();

    $__res = (empty($resultData)) ? '-' : $resultData['status'];
    return $__res;
  }

  public function getPenugasanDosenPembimbing($formulir_id) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table('penugasan_dosen_pembimbing_uji_kelayakan_judul');
    $resultData = $getQuery->getWhere(['formulir_uji_kelayakan_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function addSuratTugasPembimbing($data) {
    date_default_timezone_set("Asia/Bangkok");

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    // $ujiKelayakanId = $this->classesModel->decrypter($data['items']['ujiKelayakanId']);
    $ujiKelayakanId = $data['items']['ujiKelayakanId'];

    $getQueryFormUjiKelayakan = $this->db->table('formulir_uji_kelayakan');
    $resultDataUjiKelayakan = $getQueryFormUjiKelayakan->getWhere(['id' => $ujiKelayakanId])->getRowArray();

    $getQueryUserData = $this->db->table('user');
    $resultUserData = $getQueryUserData->getWhere(['nim' => $resultDataUjiKelayakan['nim']])->getRowArray();

    $mhsId = $resultUserData['id'];
    $judul = $resultDataUjiKelayakan['judul'];
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
        $uploaddirSuratTugasMhs  = $this->directoryUploadedSuratTugasBimbingan;
        $fileNameSuratTugasMhs   = rand(1000,100000).'-'.$data['files']['surat_tugas_file_to_mahasiswa']['name'];
        $fileTmpSuratTugasMhs    = $data['files']['surat_tugas_file_to_mahasiswa']['tmp_name'];
        $fileSizeSuratTugasMhs   = $data['files']["surat_tugas_file_to_mahasiswa"]['size'];
        $fileExtArrSuratTugasMhs = explode('.',$fileNameSuratTugasMhs);
        $fileExtSuratTugasMhs    = strtolower(end($fileExtArrSuratTugasMhs));
        $uploadfileSuratTugasMhs = $uploaddirSuratTugasMhs . $fileNameSuratTugasMhs;
 
        //validate file size
        if ($fileSizeSuratTugasMhs == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        if($fileSizeSuratTugasMhs > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
          $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        $_thumbDirSuratTugasMhs = $uploaddirSuratTugasMhs.'/thumbnails/'.'thumb-'.$fileNameSuratTugasMhs;
        $_thumbFileSuratTugasMhs = 'thumbnails/thumb-'.$fileNameSuratTugasMhs;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }

      $insertSuratTugasMhs = $this->db->table('surat_tugas_bimbingan')->insert([
        'uji_kelayakan_id' => $ujiKelayakanId,
        'assigment_from_user_id' => $userId,
        'assigment_to_user_id' => $mhsId,
        'mahasiswa_id' => $mhsId,
        'judul' => $judul,
        'surat_tugas_to_mahasiswa_files' => $fileNameSuratTugasMhs,
        'createBy' => $userId,
        'createDate' => $dateNow
      ]);

      $lastId = $this->db->insertID();

      if ($insertSuratTugasMhs == 1) {


        $sql = "UPDATE
          `formulir_uji_kelayakan`
        SET
          `status` = '7',
          `updateBy` = '{$userId}',
          `updateDate` = '{$dateNow}'
        WHERE `id` = '{$ujiKelayakanId}'";
        $resultKirimSuratTugasDosenPembimbingUjiKelayakan = $this->db->query($sql);

        if ($resultKirimSuratTugasDosenPembimbingUjiKelayakan == 1) {

          $sql = "UPDATE
            `surat_tugas`
          SET
            `status` = '5',
            `updateBy` = '{$userId}',
            `updateDate` = '{$dateNow}'
          WHERE `uji_kelayakan_id` = '{$ujiKelayakanId}' AND `mahasiswa_id` = '{$mhsId}' AND `assigment_to_user_id` = '{$mhsId}'";
          $resultUPdateStatusSuratTugasMhs = $this->db->query($sql);

          if ($resultUPdateStatusSuratTugasMhs == 1) {

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
                  $uploaddirSuratTugasDosen  = $this->directoryUploadedSuratTugasBimbingan;
                  $fileNameSuratTugasDosen   = rand(1000,100000).'-'.$data['files']['surat_tugas_file_to_list_dosen']['name'][$i];
                  $fileTmpSuratTugasDosen    = $data['files']['surat_tugas_file_to_list_dosen']['tmp_name'][$i];
                  $fileSizeSuratTugasDosen   = $data['files']["surat_tugas_file_to_list_dosen"]['size'][$i];
                  $fileExtArrSuratTugasDosen = explode('.',$fileNameSuratTugasDosen);
                  $fileExtSuratTugasMhsDosen    = strtolower(end($fileExtArrSuratTugasDosen));
                  $uploadfileSuratTugasMhsDosen = $uploaddirSuratTugasDosen . $fileNameSuratTugasDosen;
           
                  //validate file size
                  if ($fileSizeSuratTugasDosen == 0) { /** If config php.ini standart 2MB */
                    $errors = 'Image maximum 2MB files are allowed';
                    return $this->response->setJson(array("code" => 400, "response" => $errors));
                  }

                  if($fileSizeSuratTugasDosen > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
                    $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
                    return $this->response->setJson(array("code" => 400, "response" => $errors));
                  }

                  $_thumbDirSuratTugasMhs = $uploaddirSuratTugasDosen.'/thumbnails/'.'thumb-'.$fileNameSuratTugasDosen;
                  $_thumbFileSuratTugasMhs = 'thumbnails/thumb-'.$fileNameSuratTugasDosen;
                } else {
                  return array("code" => 500, "response" => 'Incompatible file format!');
                  exit();
                }

                $insertSuratTugas = $this->db->table('surat_tugas_bimbingan')->insert([
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

                  $sql = "UPDATE
                    `penugasan_dosen_pembimbing_uji_kelayakan_judul`
                  SET
                    `status` = '2',
                    `updateBy` = '{$userId}',
                    `updateDate` = '{$dateNow}'
                  WHERE `formulir_uji_kelayakan_id` = '{$ujiKelayakanId}'";
                  $resulUpdateStatusPenugasaanDospem = $this->db->query($sql);

                  if ($resulUpdateStatusPenugasaanDospem == 1) {
                    if ($data['files']['surat_tugas_file_to_list_dosen']['name'][$i] !== '') {
                      $moveUpload = move_uploaded_file($fileTmpSuratTugasDosen, $uploadfileSuratTugasMhsDosen);       
                    }
                    $response = array("code" => 201, "response" => 'Surat Tugas Bimbingan berhasil terkirim ke Mahasiswa & Dosen-dosen Pembimbing');
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
        } else {
          $response = array("code" => 500, "response" => 'Internal Server Error');
        }


      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    }
    return $response;
  }


  public function approveHasilPenilaianJudul($data) {
    date_default_timezone_set("Asia/Bangkok");
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $mhsId = $data['items']['mahasiswa_id'];
    $uji_kelayakan_id = $data['items']['uji_kelayakan_id'];

    $sql = "UPDATE
      `formulir_uji_kelayakan`
    SET
      `status` = '5',
      `updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$uji_kelayakan_id}'";
    $resultApproveUjiKelayakanJudul = $this->db->query($sql);

    $lastId = $this->db->insertID();

    $response = '';
    if ($resultApproveUjiKelayakanJudul == 1) {
      
      $sql = "UPDATE
        `surat_tugas`
      SET
        `status` = '3',
        `updateBy` = '{$userId}',
        `updateDate` = '{$dateNow}'
      WHERE `uji_kelayakan_id` = '{$uji_kelayakan_id}' AND `mahasiswa_id` = '{$mhsId}' AND `assigment_to_user_id` = '{$mhsId}'";
      $resultUPdateStatusSuratTugasMhs = $this->db->query($sql);

      if ($resultUPdateStatusSuratTugasMhs == 1) {
        $response = array("code" => 201, "response" => 'Penilaian Uji Kelayakan Judul berhasil di Approved');
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }

    return $response;
  }

  public function notApproveHasilPenilaianJudul($data) {
    date_default_timezone_set("Asia/Bangkok");
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $mhsId = $data['items']['mahasiswa_id'];
    $uji_kelayakan_id = $data['items']['uji_kelayakan_id'];

    $sql = "UPDATE
      `formulir_uji_kelayakan`
    SET
      `status` = '0',
      `updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$uji_kelayakan_id}'";
    $resultApproveUjiKelayakanJudul = $this->db->query($sql);

    $lastId = $this->db->insertID();

    $response = '';
    if ($resultApproveUjiKelayakanJudul == 1) {
      
      $sql = "UPDATE
        `surat_tugas`
      SET
        `status` = '0',
        `updateBy` = '{$userId}',
        `updateDate` = '{$dateNow}'
      WHERE `uji_kelayakan_id` = '{$uji_kelayakan_id}' AND `mahasiswa_id` = '{$mhsId}'";
      $resultUPdateStatusSuratTugasMhs = $this->db->query($sql);

      if ($resultUPdateStatusSuratTugasMhs == 1) {
        $response = array("code" => 201, "response" => 'Penilaian Uji Kelayakan Judul berhasil di Tolak/Not approved');
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }

    return $response;
  }

}