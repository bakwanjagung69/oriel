<?php

namespace App\Models\JadwalSidang;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class JadwalSidangUjiKelayakanModel extends Model {
  protected $table = 'input_jadwal_uji_kelayakan';
  protected $builder;
  protected $directoryUploadedJadwalSidang = 'assets/upload/jadwal-sidang/';

  protected $column_order = [
    'id', 
    'judul', 
    'tempat', 
    'tanggal_dan_waktu', 
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'judul', 
    'tempat', 
    'tanggal_dan_waktu'
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

    if ($this->session->user_logged['rules'] == 2) {
      $query = $this->dt->getWhere('mahasiswa_id IS NOT NULL');
    } 

    if ($this->session->user_logged['rules'] == 3) {
      $query = $this->dt->getWhere(['dosen_id' => $this->session->user_logged['id']]);
    } 

    if ($this->session->user_logged['rules'] == 4) {
      $query = $this->dt->getWhere('mahasiswa_id IS NOT NULL');
    } 

    if ($this->session->user_logged['rules'] == 5) {
      $query = $this->dt->getWhere(['mahasiswa_id' => $this->session->user_logged['id']]);
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

  public function getPenugasanDosenPenguji($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_uji_kelayakan_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function getUserData($nim) {
    $_nim = $this->classesModel->decrypter($nim);

    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $_nim])->getRowArray();
    return $resultData;
  }

}