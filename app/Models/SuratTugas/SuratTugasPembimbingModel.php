<?php

namespace App\Models\SuratTugas;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class SuratTugasPembimbingModel extends Model {
  protected $table = 'surat_tugas_bimbingan';
  protected $builder;

  protected $column_order = [
    'id', 
    'assigment_from_user_id', 
    'assigment_to_user_id', 
    'judul',
    'surat_tugas_to_mahasiswa_files',
    'surat_tugas_to_dosen_files',
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'assigment_from_user_id', 
    'assigment_to_user_id', 
    'judul',
    'surat_tugas_to_mahasiswa_files',
    'surat_tugas_to_dosen_files'
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

    $query = $this->dt->getWhere(['assigment_to_user_id' => $this->session->user_logged['id']]);
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

  public function getUserData($id) {
    $_id = $this->classesModel->decrypter($id);

    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['id' => $_id])->getRowArray();
    return $resultData;
  }

  public function getDataFormUjiKelayakanByNim($nim) {
    $_nim = $this->classesModel->decrypter($nim);

    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $_nim])->getRowArray();
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
    $mahasiswa_id = $this->classesModel->decrypter($mahasiswa_id);
    $uji_kelayakan_id = $this->classesModel->decrypter($uji_kelayakan_id);

    $getQuery = $this->db->table('penilaian_uji_kelayakan');
    $getQuery->select('*');
    $result = $getQuery->getWhere([
      'uji_kelayakan_id' => $uji_kelayakan_id,
      'mahasiswa_id' => $mahasiswa_id
    ])->getResult();

    return $result;
  }

}