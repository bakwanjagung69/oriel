<?php

namespace App\Models\ListPendaftaran;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class ListPendaftaranModel extends Model {
  // protected $table = 'penugasan_dosen_penguji_uji_kelayakan';
  protected $builder;
  protected $request;
  protected $db;
  protected $dt;
  protected $session;
  protected $classesModel;

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    // $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    // $this->builder = $this->db->table($this->table);
  }

  public function getUserDataByNim($nim) {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->getWhere(['nim' => $nim])->getRowArray();
    return $resultData;
  }

  public function getUserDataById($id) {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->getWhere(['id' => $id])->getRowArray();
    return $resultData;
  }

  public function getAllDosenListData() {
    $getQuery   = $this->db->table('user');
    $getQuery->select('id, full_name');
    $resultData = $getQuery->getWhere(['rules' => 3])->getResult();
    return $resultData;
  }



}