<?php

namespace App\Models\InputJadwal;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use App\Models\InputJadwal\InputJadwalModel;
use CodeIgniter\Model;
use Config\Services;
 
class InputJadwalSkripsiModel extends Model {
  protected $table = 'formulir_skripsi';
  protected $builder;
  protected $InputJadwalModel;

  protected $column_order = [
    'id', 
    'nama', 
    'nim', 
    'judul', 
    'skripsi_files',
    'lembar_tugas_or_konsultasi_files', 
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'nama', 
    'nim', 
    'judul', 
    'skripsi_files',
    'lembar_tugas_or_konsultasi_files'
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
    $this->InputJadwalModel = new InputJadwalModel();
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
    
    if ($this->request->getPost('semester') !== '') {
      $query = $this->dt->getWhere([
        'semester' => $this->request->getPost('semester')
      ]);
    } else {
      $query = $this->dt->get();
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
    $getQuery->select('id, nama, nim, judul, skripsi_files, lembar_tugas_or_konsultasi_files');
    $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    return $resultData;
  }

  public function AddNewDataKirimJadwalSidang($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    /** Check Avalailable Jadwal */
    $getValid = $this->checkAvailableJadwal($__data['tempat'], $__data['tanggal'], $__data['waktuMulai'], $__data['waktuAkhir']);

    if ($getValid == 'false') {
      return array("code" => 302, "response" => '<div style="font-size: 15px;">Tempat & Tanggal Waktu tidak tersedia.</div>');
      exit();
    }

    $skripsiId = $this->classesModel->decrypter($data['items']['skripsiId']);

    $getQueryFormSkripsi = $this->db->table('formulir_skripsi');
    $resultDataSkripsi = $getQueryFormSkripsi->getWhere(['id' => $skripsiId])->getRowArray();

    $getQueryUserData = $this->db->table('user');
    $resultUserData = $getQueryUserData->getWhere(['nim' => $resultDataSkripsi['nim']])->getRowArray();

    $mhsId = $resultUserData['id'];

    $insertKirimJadwalSidangMhs = $this->db->table('input_jadwal_skripsi')->insert([
      'formulir_skripsi_id' => $this->classesModel->decrypter($__data['skripsiId']),
      'mahasiswa_id' => $mhsId,
      'judul' => $__data['judul'],
      'tempat' => $__data['tempat'],
      'tanggal' => date("Y-m-d H:i", strtotime($__data['tanggal'])),
      'waktu_mulai' => $__data['waktuMulai'],
      'waktu_akhir' => $__data['waktuAkhir'],
      'keterangan' => $__data['keterangan'],
      'status' => '0',
      'createBy' => $userId,
      'createDate' => $dateNow
    ]);

      $lastUserId = $this->db->insertID();

      if ($insertKirimJadwalSidangMhs == 1) {

        $sql = "UPDATE
          `formulir_skripsi`
        SET
          `status` = '3',
          `semester` = '{$__data['semester']}',
          `updateBy` = '{$userId}',
          `updateDate` = '{$dateNow}'
        WHERE `id` = '{$this->classesModel->decrypter($__data['skripsiId'])}'";
        $resultUPdateStatusSemesterFormSkripsi = $this->db->query($sql);

        if ($resultUPdateStatusSemesterFormSkripsi == 1) {

          $lengthData = count($__data['dosenId']);
          for ($i=0; $i < $lengthData; $i++) { 
            $insertKirimJadwalSidang = $this->db->table('input_jadwal_skripsi')->insert([
              'formulir_skripsi_id' => $this->classesModel->decrypter($__data['skripsiId']),
              'dosen_id' => $this->classesModel->decrypter($__data['dosenId'][$i]),
              'judul' => $__data['judul'],
              'tempat' => $__data['tempat'],
              'tanggal' => date("Y-m-d H:i", strtotime($__data['tanggal'])),
              'waktu_mulai' => $__data['waktuMulai'],
              'waktu_akhir' => $__data['waktuAkhir'],
              'keterangan' => $__data['keterangan'],
              'status' => '0',
              'createBy' => $userId,
              'createDate' => $dateNow
            ]);

            $lastUserId = $this->db->insertID();

            if ($insertKirimJadwalSidang == 1) {
              $response = array("code" => 201, "response" => 'Input jadwal terkirim ke halaman jadwal sidang.');
            } else {
              $response = array("code" => 500, "response" => 'Internal Server Error');
            }
          }
        } else {
          $response = array("code" => 500, "response" => 'Internal Server Error');
        }

      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }

    return $response;
  }
  public function getPenugasanDosenPenguji($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_skripsi_id' => $formulirId])->getResult();
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
        'dosen_name' => $this->InputJadwalModel->getUserDataById($resultDataDosPemUjiKelayakan[$i]->dosen_id)['full_name'],
        'type_penugasan' => $resultDataDosPemUjiKelayakan[$i]->type_penugasan,
        'dosen_picture' => $this->classesModel->encrypter('/assets/upload/users/'.$this->InputJadwalModel->getUserDataById($resultDataDosPemUjiKelayakan[$i]->dosen_id)['images'])
      ));
    }

    return (!empty($resultDataDosPemUjiKelayakan)) ? $arrSet : array();
  }

  private function checkAvailableJadwal($tempat = '', $tanggal = '', $waktuMulai = '', $waktuAkhir = '') {
    $getQuery   = $this->db->table('input_jadwal_skripsi');
    $getQuery->select('*');
    $queryGet = $getQuery->where('`tempat` = \''.$tempat.'\' AND `tanggal` = \''.date("Y-m-d", strtotime($tanggal)).'\' AND (`waktu_mulai` BETWEEN \''.date("H:i", strtotime($waktuMulai)).'\' AND \''.date("H:i", strtotime($waktuAkhir)).'\') OR (`waktu_akhir` BETWEEN \''.date("H:i", strtotime($waktuAkhir)).'\' AND \''.date("H:i", strtotime($waktuMulai)).'\')')->get();
    $resultData = $queryGet->getResult();
    $checkValid = (empty($resultData)) ? 'true' : 'false';
    
    return $checkValid;
  }

}