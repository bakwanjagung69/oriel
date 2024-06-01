<?php

namespace App\Models\ListPendaftaran;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use App\Models\ListPendaftaran\ListPendaftaranModel;
use CodeIgniter\Model;
use Config\Services;
 
class ListPendaftaranSUPModel extends Model {
  protected $table = 'formulir_sup';
  protected $builder;
  protected $ListPendaftaranModel;

  protected $column_order = [
    'id', 
    'nama', 
    'nim', 
    'judul', 
    'proposal_files',
    'lembar_tugas_or_konsultasi_files', 
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'nama', 
    'nim', 
    'judul', 
    'proposal_files',
    'lembar_tugas_or_konsultasi_files'
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
    $this->ListPendaftaranModel = new ListPendaftaranModel();
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

    $getQuery = $this->db->table('formulir_sup');
    $getQuery->select('id, nama, nim, judul, proposal_files, lembar_tugas_or_konsultasi_files');
    $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    return $resultData;
  }

  public function checkTotalPenugasanDospem($kaprodi_id, $formulir_sup_id, $tabelName) {
    $kaprodi_id = $this->classesModel->decrypter($kaprodi_id);
    $formulir_sup_id = $this->classesModel->decrypter($formulir_sup_id);

    $getQuery = $this->db->table($tabelName);
    $getQuery->select('COUNT(id) as total_dosen_pembimbing');
    $resultData = $getQuery->getWhere([
      'kaprodi_id' => $kaprodi_id,
      'formulir_sup_id' => $formulir_sup_id
    ])->getRowArray();
    return intval($resultData['total_dosen_pembimbing']);
  }

  public function AddNewDataPenugasanDosenPenguji($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    $validInput = $this->checkTotalPenugasanDospem($this->classesModel->encrypter($this->getKaprodiId()), $data['formulir_sup'], 'penugasan_dosen_penguji_sup');

    if ($validInput > 3 && $validInput !== 0) {
      return array("code" => 304, "response" => 'Penugasan dosen penguji sudah berjumlah 3');
      exit();
    }

    for ($i=0; $i < count($__data); $i++) { 
      $insertPenugasanDosenPenguji = $this->db->table('penugasan_dosen_penguji_sup')->insert([
        'formulir_sup_id' => $this->classesModel->decrypter($__data[$i]->sup_id),
        'kaprodi_id' => $this->classesModel->decrypter($__data[$i]->kaprodi_id),
        'dosen_id' => $this->classesModel->decrypter($__data[$i]->dosen_id),
        'type_penugasan' => $__data[$i]->type_penugasan,
        'createBy' => $userId,
        'createDate' => $dateNow
      ]);

      $lastUserId = $this->db->insertID();

      if ($insertPenugasanDosenPenguji == 1) {
          $sql = "UPDATE
            `formulir_sup`
          SET
            `status` = '2',
            `updateBy` = '{$userId}',
            `updateDate` = '{$dateNow}'
          WHERE `id` = '{$this->classesModel->decrypter($__data[$i]->sup_id)}'";
          $resultUPdateStatusSUPMhs = $this->db->query($sql);

          if ($resultUPdateStatusSUPMhs == 1) {
             $response = array("code" => 201, "response" => 'Data penugasan dosen terkirim ke admin.');
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

    $getQuery = $this->db->table('penugasan_dosen_penguji_sup');
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
    $resultData = $getQuery->getWhere(['formulir_sup_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function getDosPembUjiKelayakanByNimStatusSelesai($nim) {
    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('*');
    $resultDataFormUjiKelayakan = $getQuery->getWhere([
      'nim' => $nim,
      'status' => '7'
    ])->getRowArray();

    $ujiKelayakanId = $resultDataFormUjiKelayakan['id'];

    $sql = $this->db->table('penugasan_dosen_pembimbing_uji_kelayakan_judul');
    $sql->select('*');
    $resultDataDosPemUjiKelayakan = $sql->getWhere([
      'formulir_uji_kelayakan_id' => $ujiKelayakanId,
      'status' => '2',
    ])->getResult();

    $arrSet = array();
    for ($i = 0; $i < count($resultDataDosPemUjiKelayakan); ++$i) {
      array_push($arrSet, array(
        'dosen_id' => $this->classesModel->encrypter($resultDataDosPemUjiKelayakan[$i]->dosen_id),
        'dosen_name' => $this->ListPendaftaranModel->getUserDataById($resultDataDosPemUjiKelayakan[$i]->dosen_id)['full_name'],
        'type_penugasan' => $resultDataDosPemUjiKelayakan[$i]->type_penugasan,
        'dosen_picture' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($resultDataDosPemUjiKelayakan[$i]->dosen_id)['images'])
      ));
    }

    return (!empty($resultDataDosPemUjiKelayakan)) ? $arrSet : array();
  }

  public function getKaprodiId() {
    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['rules' => '4'])->getRowArray();
    return $resultData['id'];
  }

}