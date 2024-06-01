<?php

namespace App\Models\SuratTugas;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class SuratTugasModel extends Model {
  protected $table = 'surat_tugas';
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

    /** Administrator */
    if ($this->session->user_logged['rules'] == '1') {
      $query = $this->dt->get();
    } 

    /** Admin TU */
    if ($this->session->user_logged['rules'] == '2') {
      $query = $this->dt->getWhere(['assigment_to_user_id' => $this->session->user_logged['id']]);
    } 
    
    /** Dosen */
    if ($this->session->user_logged['rules'] == '3') {
      $query = $this->dt->getWhere(['assigment_to_user_id' => $this->session->user_logged['id']]);
    } 

    /** Kaprodi */
    if ($this->session->user_logged['rules'] == '4') {
      $query = $this->dt->get();
    } 

    /** Mahasiswa */
    if ($this->session->user_logged['rules'] == '5') {
      $query = $this->dt->getWhere(['assigment_to_user_id' => $this->session->user_logged['id']]);
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

  public function checkTotalDosenSudahNilai($uji_kelayakan_id, $mahasiswa_id) {
    $uji_kelayakan_id = $this->classesModel->decrypter($uji_kelayakan_id);
    $mahasiswa_id = $this->classesModel->decrypter($mahasiswa_id);

    $getQuery = $this->db->table('surat_tugas');
    $getQuery->select('COUNT(STATUS) as total_sudah_nilai');
    $resultData = $getQuery->getWhere([
      'uji_kelayakan_id' => $uji_kelayakan_id,
      'mahasiswa_id' => $mahasiswa_id,
      'status' => '2',
    ])->getRowArray();
    return $resultData;
  }

  public function insertPenilaianUjiKelayakan($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    $insertPenilaianUjiKelayakan = $this->db->table('penilaian_uji_kelayakan')->insert([
      'uji_kelayakan_id' => $this->classesModel->decrypter($__data['uji_kelayakan_id']),
      'dosen_id' => $this->classesModel->decrypter($__data['dosen_id']),
      'mahasiswa_id' => $this->classesModel->decrypter($__data['mahasiswa_id']),
      'catatan_penilaian_kelayakan' => $__data['catatan-penilaian-kelayakan'],
      'kesimpulan' => $__data['kesimpulan'],
      'kesimpulan_dengan_catatan' => $__data['kesimpulanDenganCatatan'],
      'createBy' => $userId,
      'createDate' => $dateNow
    ]);

    $lastUserId = $this->db->insertID();

    if ($insertPenilaianUjiKelayakan == 1) {
      
      $sql = "UPDATE
        `surat_tugas`
      SET
        `status` = '2',
        `updateBy` = '{$userId}',
        `updateDate` = '{$dateNow}'
      WHERE `uji_kelayakan_id` = '{$this->classesModel->decrypter($__data['uji_kelayakan_id'])}' AND `mahasiswa_id` = '{$this->classesModel->decrypter($__data['mahasiswa_id'])}' AND `assigment_to_user_id` = '{$this->classesModel->decrypter($__data['dosen_id'])}'";
      $resultUPdateStatusSuratTugasDosen = $this->db->query($sql);

      if ($resultUPdateStatusSuratTugasDosen == 1) {

        /** Update Status Document UJI Kelayakan Mahasiswa */
        $checkTotalDosenSudahNilai = $this->checkTotalDosenSudahNilai($__data['uji_kelayakan_id'], $__data['mahasiswa_id']);
        if (intval($checkTotalDosenSudahNilai['total_sudah_nilai']) == 3) {          
          $sql = "UPDATE
            `formulir_uji_kelayakan`
          SET
            `status` = '4',
            `updateBy` = '{$userId}',
            `updateDate` = '{$dateNow}'
          WHERE `id` = '{$this->classesModel->decrypter($__data['uji_kelayakan_id'])}'";
          $resultUPdateStatusUjiKelayakanMhs = $this->db->query($sql);

          if ($resultUPdateStatusUjiKelayakanMhs == 1) {

             $sql = "UPDATE
                `surat_tugas`
              SET
                `status` = '2',
                `updateBy` = '{$userId}',
                `updateDate` = '{$dateNow}'
              WHERE `uji_kelayakan_id` = '{$this->classesModel->decrypter($__data['uji_kelayakan_id'])}' AND `mahasiswa_id` = '{$this->classesModel->decrypter($__data['mahasiswa_id'])}' AND `assigment_to_user_id` = '{$this->classesModel->decrypter($__data['mahasiswa_id'])}'";
              $resultUPdateStatusSuratTugasMhs = $this->db->query($sql);

              if ($resultUPdateStatusSuratTugasMhs == 1) {
                $response = array("code" => 201, "response" => 'Hasil penilaian uji kelayakan berhasil terkirim!');
              } else {
                $response = array("code" => 500, "response" => 'Internal Server Error');
              }

          } else {
            $response = array("code" => 500, "response" => 'Internal Server Error');
          }
        }

        $response = array("code" => 201, "response" => 'Hasil penilaian uji kelayakan berhasil terkirim!');
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
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

  public function getDataHasilPenilaianForDosen($dosen_id, $uji_kelayakan_id) {
    $dosen_id = $this->classesModel->decrypter($dosen_id);
    $uji_kelayakan_id = $this->classesModel->decrypter($uji_kelayakan_id);

    $getQuery = $this->db->table('penilaian_uji_kelayakan');
    $getQuery->select('*');
    $result = $getQuery->getWhere([
      'uji_kelayakan_id' => $uji_kelayakan_id,
      'dosen_id' => $dosen_id
    ])->getRowArray();

    return $result;
  }

}