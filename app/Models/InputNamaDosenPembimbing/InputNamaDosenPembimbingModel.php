<?php

namespace App\Models\InputNamaDosenPembimbing;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class InputNamaDosenPembimbingModel extends Model {
  protected $table = 'formulir_uji_kelayakan';
  protected $builder;
  protected $directoryUploaded = '';

  protected $column_order = [
    'id', 
    'nama', 
    'nim', 
    'judul', 
    'files', 
    'semester', 
    'status',
    'createDate'
  ];
  protected $column_search = [
    'nama', 
    'nim', 
    'judul', 
    'files', 
    'semester', 
    'status',
    'createDate'
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
      $queryRes = $getQuery->where("`status` IN ('5', '6', '7') AND `semester` = '".$this->request->getPost('semester')."'")->get();
    } else {
      $getQuery = $this->dt->select('*');
      $queryRes = $getQuery->where("`status` IN ('5', '6', '7')")->get();
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
    // $nim = $this->classesModel->decrypter($nim);

    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $nim])->getRowArray();
    return $resultData;
  }

  public function getAllDosenListData() {
    $getQuery   = $this->db->table('user');
    $getQuery->select('id, full_name');
    $resultData = $getQuery->getWhere(['rules' => 3])->getResult();
    return $resultData;
  }

  public function getDataFormUjiKelayakanByNim($nim) {
    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $nim])->getRowArray();
    return $resultData;
  }

   public function getPenugasanDosenPembimbing($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_uji_kelayakan_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function checkTotalPenugasanDosenPemimbing($kaprodi_id, $formulir_uji_kelayakan_id) {
    $kaprodi_id = $this->classesModel->decrypter($kaprodi_id);
    $formulir_uji_kelayakan_id = $this->classesModel->decrypter($formulir_uji_kelayakan_id);

    $getQuery = $this->db->table('penugasan_dosen_pembimbing_uji_kelayakan_judul');
    $getQuery->select('COUNT(id) as total_dosen_pembimbing');
    $resultData = $getQuery->getWhere([
      'kaprodi_id' => $kaprodi_id,
      'formulir_uji_kelayakan_id' => $formulir_uji_kelayakan_id
    ])->getRowArray();
    return intval($resultData['total_dosen_pembimbing']);
  }

  public function AddNewDataPenugasanDosenPembimbing($data) {
    $__data = $data['items'];
    $mhsId = $this->classesModel->decrypter($data['mahasiswa_id']);
    $ujiKelayakanJudulId = $this->classesModel->decrypter($data['uji_kelayakan_judul_id']);

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    $validInput = $this->checkTotalPenugasanDosenPemimbing($this->classesModel->encrypter($this->getKaprodiId()), $data['uji_kelayakan_judul_id']);

    if ($validInput > 2 && $validInput !== 0) {
      return array("code" => 304, "response" => 'Penugasan dosen pembimbing sudah berjumlah 2');
      exit();
    }

    for ($i=0; $i < count($__data); $i++) { 
      $insertPenugasanDosenPembimbing = $this->db->table('penugasan_dosen_pembimbing_uji_kelayakan_judul')->insert([
        'formulir_uji_kelayakan_id' => $this->classesModel->decrypter($__data[$i]->uji_kelayakan_id),
        'kaprodi_id' => $this->classesModel->decrypter($__data[$i]->kaprodi_id),
        'dosen_id' => $this->classesModel->decrypter($__data[$i]->dosen_id),
        'type_penugasan' => $__data[$i]->type_penugasan,
        'status' => '1',
        'createBy' => $userId,
        'createDate' => $dateNow
      ]);

      $lastUserId = $this->db->insertID();

      if ($insertPenugasanDosenPembimbing == 1) {
        $sql = "UPDATE
          `formulir_uji_kelayakan`
        SET
          `status` = '6',
          `updateBy` = '{$userId}',
          `updateDate` = '{$dateNow}'
        WHERE `id` = '{$this->classesModel->decrypter($__data[$i]->uji_kelayakan_id)}'";
        $resultApproveUjiKelayakanJudul = $this->db->query($sql);

        if ($resultApproveUjiKelayakanJudul == 1) {

          $sql = "UPDATE
            `surat_tugas`
          SET
            `status` = '4',
            `updateBy` = '{$userId}',
            `updateDate` = '{$dateNow}'
          WHERE `uji_kelayakan_id` = '{$this->classesModel->decrypter($__data[$i]->uji_kelayakan_id)}' AND `mahasiswa_id` = '{$mhsId}' AND `assigment_to_user_id` = '{$mhsId}'";
          $resultUPdateStatusSuratTugasMhs = $this->db->query($sql);

          if ($resultUPdateStatusSuratTugasMhs == 1) {
            $response = array("code" => 201, "response" => 'Dosen-dosen pembimbing berhasil ditugaskan!');
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

  public function DeletePenugasanDosenPembimbing($data) {
    $id = $this->classesModel->decrypter($data['items']['id']);

    $getQuery = $this->db->table('penugasan_dosen_pembimbing_uji_kelayakan_judul');
    $resultData = $getQuery->delete(['id' => $id]);

    $response = '';
    if ($resultData == 1) {
      $response = array("code" => 200, "response" => 'Data Deleted successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
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