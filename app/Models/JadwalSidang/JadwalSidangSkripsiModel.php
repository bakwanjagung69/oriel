<?php

namespace App\Models\JadwalSidang;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class JadwalSidangSkripsiModel extends Model {
  protected $table = 'input_jadwal_skripsi';
  protected $builder;

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
    'tanggal_dan_waktu',
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

    $getQuery = $this->db->table('formulir_skripsi');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    return $resultData;
  }

  public function getPenugasanDosenPenguji($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_skripsi_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function getUserData($nim) {
    $_nim = $this->classesModel->decrypter($nim);

    $getQuery = $this->db->table('user');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['nim' => $_nim])->getRowArray();
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
      'status' => '2'
    ])->getResult();

    $arrSet = array();
    for ($i = 0; $i < count($resultDataDosPemUjiKelayakan); ++$i) {
      array_push($arrSet, array(
        'dosen_id' => $this->classesModel->encrypter($resultDataDosPemUjiKelayakan[$i]->dosen_id),
        'dosen_name' => $this->getUserDataById($resultDataDosPemUjiKelayakan[$i]->dosen_id)['full_name'],
        'type_penugasan' => $resultDataDosPemUjiKelayakan[$i]->type_penugasan,
        'dosen_picture' => $this->classesModel->encrypter('/assets/upload/users/'.$this->getUserDataById($resultDataDosPemUjiKelayakan[$i]->dosen_id)['images'])
      ));
    }

    return (!empty($resultDataDosPemUjiKelayakan)) ? $arrSet : array();
  }

  private function getUserDataById($id) {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->getWhere(['id' => $id])->getRowArray();
    return $resultData;
  }

  public function getJadwalSkripsi($formulir_skripsi_id) {
    $getQuery   = $this->db->table('input_jadwal_skripsi');
    $resultData = $getQuery->getWhere(['formulir_skripsi_id' => $formulir_skripsi_id])->getRowArray();
    return $resultData;
  }

  public function getDosPembSkripsi($formulir_id) {
    $getQuery = $this->db->table('penugasan_dosen_penguji_skripsi');
    $getQuery->select('*');
    $resultDataDospemSkripsi = $getQuery->getWhere([
      'formulir_skripsi_id' => $formulir_id
    ])->getResult();

    $arrSet = array();
    for ($i = 0; $i < count($resultDataDospemSkripsi); ++$i) {
      array_push($arrSet, array(
        'dosen_id' => $this->classesModel->encrypter($resultDataDospemSkripsi[$i]->dosen_id),
        'dosen_name' => $this->getUserDataById($resultDataDospemSkripsi[$i]->dosen_id)['full_name'],
        'type_penugasan' => $resultDataDospemSkripsi[$i]->type_penugasan,
        'dosen_picture' => $this->classesModel->encrypter('/assets/upload/users/'.$this->getUserDataById($resultDataDospemSkripsi[$i]->dosen_id)['images'])
      ));
    }

    return (!empty($resultDataDospemSkripsi)) ? $arrSet : array();
  }

  public function updateJadwal($data) {
    $response = '';
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    /** Check Avalailable Jadwal */
    $getValid = $this->checkAvailableJadwal($__data['tempat'], $__data['tanggal'], $__data['waktuMulai'], $__data['waktuAkhir']);

    if ($getValid == 'false') {
      return array("code" => 302, "response" => '<div style="font-size: 15px;">Tempat & Tanggal Waktu tidak tersedia.</div>');
      exit();
    }

    $skripsiId = $__data['skripsiId'];
    $tanggal    = date("Y-m-d", strtotime($__data['tanggal']));
    $waktuMulai = date("H:i", strtotime($__data['waktuMulai']));
    $waktuAkhir = date("H:i", strtotime($__data['waktuAkhir']));

    $sql = "UPDATE
      `input_jadwal_skripsi`
    SET
      `tempat` = '{$__data['tempat']}',
      `tanggal` = '{$tanggal}',
      `waktu_mulai` = '{$waktuMulai}',
      `waktu_akhir` = '{$waktuAkhir}',
      `keterangan` = '{$__data['keterangan']}',
      `updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `formulir_skripsi_id` = '{$this->classesModel->decrypter($skripsiId)}'";
    $resultUPdateStatusSkripsiMhs = $this->db->query($sql);

    if ($resultUPdateStatusSkripsiMhs == 1) {
       $response = array("code" => 201, "response" => 'Tempat, Tanggal & Waktu Berhasil di Update.');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }

    return $response;
  }

  private function checkAvailableJadwal($tempat = '', $tanggal = '', $waktuMulai = '', $waktuAkhir = '') {
    $getQuery   = $this->db->table('input_jadwal_skripsi');
    $getQuery->select('*');
    $queryGet = $getQuery->where('`tempat` = \''.$tempat.'\' AND `tanggal` = \''.date("Y-m-d", strtotime($tanggal)).'\' AND (`waktu_mulai` BETWEEN \''.date("H:i", strtotime($waktuMulai)).'\' AND \''.date("H:i", strtotime($waktuAkhir)).'\') OR (`waktu_akhir` BETWEEN \''.date("H:i", strtotime($waktuAkhir)).'\' AND \''.date("H:i", strtotime($waktuMulai)).'\')')->get();
    $resultData = $queryGet->getResult();
    $checkValid = (empty($resultData)) ? 'true' : 'false';
    
    return $checkValid;
  }

  public function getStatusKesimpulan($input_jadwal_id, $mahasiswa_id) {
    $input_jadwal_id = $this->classesModel->decrypter($input_jadwal_id);
    $mahasiswa_id = $this->classesModel->decrypter($mahasiswa_id);

    $getQuery = $this->db->table('input_nilai');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere([
      'mahasiswa_id' => $mahasiswa_id,
      'input_jadwal_type' => 'skripsi'
    ])->getResult();

    $valid = 0;
    foreach ($resultData as $item) {
      if ($item->kesimpulan == 'Mengulang ujian pada tanggal yang di tentukan') {
        $valid = 1;
      }
    }
    return $valid;
  }

  public function exportFileXlsAllData() {
    $getQuery = $this->db->table('input_jadwal_skripsi');
    $getQuery->select('*');

     /** Admin TU */
    if ($this->session->user_logged['rules'] == 2) {
      $getQuery = $this->dt->getWhere('mahasiswa_id IS NOT NULL');
    } 
    /** [END] - Admin TU */
    
    /** Dosen */
    if ($this->session->user_logged['rules'] == 3) {
      $getQuery = $this->dt->getWhere(['dosen_id' => $this->session->user_logged['id']]);
    } 
    /** [END] - Dosen */

    /** Kaprodi */
    if ($this->session->user_logged['rules'] == 4) {
      $getQuery = $this->dt->getWhere('mahasiswa_id IS NOT NULL');
    } 
    /** [END] - Kaprodi */

    /** Mahasiswa */
    if ($this->session->user_logged['rules'] == 5) {
      $getQuery = $this->dt->getWhere(['mahasiswa_id' => $this->session->user_logged['id']]);
    }
    /** [END] - Mahasiswa] */

    return $getQuery->getResult();
  }

}