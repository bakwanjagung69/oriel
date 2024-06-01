<?php

namespace App\Models\InputNilai;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class InputNilaiModel extends Model {
  protected $table = 'input_nilai';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/input-nilai/';

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

  public function getDisplayHariIdn($tanggal) {
    $day = date('D', strtotime($tanggal));
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jum\'at',
        'Sat' => 'Sabtu'
    );

    return $dayList[$day];
  }

}