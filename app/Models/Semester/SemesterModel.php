<?php

namespace App\Models\Semester;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class SemesterModel extends Model {
  protected $table = 'master_semester';
  protected $builder;

  protected $column_order = [
    'id', 
    'angkatan', 
    'dari_tahun', 
    'sampai_tahun', 
    'semeseter', 
    'status', 
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'angkatan', 
    'dari_tahun', 
    'sampai_tahun', 
    'semeseter', 
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
    $query = $this->dt->get();
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

  public function AddNew($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $__data = $data['items'];

    $result = $this->db->table($this->table)->insert([
      'angkatan' => intval($__data['angkatan']),
      'dari_tahun' => intval($__data['dari_tahun']),
      'sampai_tahun' => intval($__data['sampai_tahun']),
      'semester' => intval($__data['semester']),
      'status' => $__data['status'],
      'createBy' => $userId,
      'createDate' => $dateNow
    ]);

    $lastUserId = $this->db->insertID();

    if ($result == 1) {
      $response = array("code" => 201, "response" => 'Data saved successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function getById($id) {
    $id = $this->classesModel->decrypter($id);

    $this->builder->where('id',$id);
    $query = $this->builder->get(); 
    return $query->getRowArray();
  }

  public function UpdateData($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $ids = $this->classesModel->decrypter($data['items']['id']);

    $sql = "UPDATE
      `{$this->table}`
    SET
      `angkatan` = '{$data['items']['angkatan']}',
      `dari_tahun` = '{$data['items']['dari_tahun']}',
      `sampai_tahun` = '{$data['items']['sampai_tahun']}',
      `semester` = '{$data['items']['semester']}',
      `status` = '{$data['items']['status']}', ";
    $sql .=  "`updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$ids}'";

    $result = $this->db->query($sql);

    if ($result == 1) {
      $response = array("code" => 201, "response" => 'Data saved successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function DeleteData($data) {
    $id = $this->classesModel->decrypter($data['items']['id']);

    $this->builder->where('id', $id);
    $this->builder->delete();
    return array("code" => 200, "response" => 'Data Deleted successfully!');
  }

}