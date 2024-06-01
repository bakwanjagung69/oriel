<?php

namespace App\Models\InputJadwal;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class InputJadwalUjiKelayakanModel extends Model {
  protected $table = 'formulir_uji_kelayakan';
  protected $builder;
  protected $directoryUploadedSuratTugas = 'assets/upload/surat-tugas/';

  protected $column_order = [
    'id', 
    'nama', 
    'nim', 
    'judul', 
    'files', 
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'nama', 
    'nim', 
    'judul', 
    'files'
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

  public function getById($id) {
    $ids = $this->classesModel->decrypter($id);

    $getQuery = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('id, nama, nim, judul, files');
    $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    return $resultData;
  }

  public function AddNewDataKirimJadwalSidang($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    $ujiKelayakanId = $this->classesModel->decrypter($data['items']['ujiKelayakanId']);

    $getQueryFormUjiKelayakan = $this->db->table('formulir_uji_kelayakan');
    $resultDataUjiKelayakan = $getQueryFormUjiKelayakan->getWhere(['id' => $ujiKelayakanId])->getRowArray();

    $getQueryUserData = $this->db->table('user');
    $resultUserData = $getQueryUserData->getWhere(['nim' => $resultDataUjiKelayakan['nim']])->getRowArray();

    $mhsId = $resultUserData['id'];

    $insertKirimJadwalSidangMhs = $this->db->table('input_jadwal_uji_kelayakan')->insert([
      'formulir_uji_kelayakan_id' => $this->classesModel->decrypter($__data['ujiKelayakanId']),
      'mahasiswa_id' => $mhsId,
      'judul' => $__data['judul'],
      'tempat' => $__data['tempat'],
      'tanggal_dan_waktu' => date("Y-m-d H:i", strtotime($__data['tanggalAndWaktu'])),
      'createBy' => $userId,
      'createDate' => $dateNow
    ]);

      $lastUserId = $this->db->insertID();

      if ($insertKirimJadwalSidangMhs == 1) {
          $lengthData = count($__data['dosenId']);
          for ($i=0; $i < $lengthData; $i++) { 
            $insertKirimJadwalSidang = $this->db->table('input_jadwal_uji_kelayakan')->insert([
              'formulir_uji_kelayakan_id' => $this->classesModel->decrypter($__data['ujiKelayakanId']),
              'dosen_id' => $this->classesModel->decrypter($__data['dosenId'][$i]),
              'judul' => $__data['judul'],
              'tempat' => $__data['tempat'],
              'tanggal_dan_waktu' => date("Y-m-d H:i", strtotime($__data['tanggalAndWaktu'])),
              'createBy' => $userId,
              'createDate' => $dateNow
            ]);

            $lastUserId = $this->db->insertID();

            if ($insertKirimJadwalSidang == 1) {
              $response = array("code" => 201, "response" => 'Data saved successfully!');
            } else {
              $response = array("code" => 500, "response" => 'Internal Server Error');
            }
          }
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }

    return $response;
  }

  public function getPenugasanDosenPenguji($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_uji_kelayakan_id' => $formulirId])->getResult();
    return $resultData;
  }

}