<?php

namespace App\Models\InputJadwal;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class InputJadwalModel extends Model {
  protected $table = 'jadwal_sidang';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/input=jadwal/';

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
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