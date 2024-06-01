<?php

namespace App\Models\Dashboard;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class DashboardModel extends Model {
  protected $table = 'jadwal_sidang';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/jadwal-sidang/';

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
  }

  public function getTotalDosen() {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->getWhere(['rules' => 3])->getResult();
    return count($resultData);
  }

  public function getTotalMahasiswa() {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->getWhere(['rules' => 5])->getResult();
    return count($resultData);
  }

  public function getTotalUser() {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->countAllResults();
    return $resultData;
  }


}