<?php

namespace App\Models\InputNilai;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class InputNilaiSkripsiModel extends Model {
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
    'tanggal_dan_waktu'
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
    
    $query = $this->dt->getWhere(['dosen_id' => $this->session->user_logged['id']]);
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

  public function AddNewDataIsiNilai($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';
    $formulirSkripsiId = $this->classesModel->decrypter($__data['formulir_skripsi_id']);

    $insertInputNilai = $this->db->table('input_nilai')->insert([
      'input_jadwal_id' => $this->classesModel->decrypter($__data['input_nilai_id']),
      'input_jadwal_type' => $__data['input_jadwal_type'],
      'dosen_id' => $this->classesModel->decrypter($__data['dosen_id']),
      'mahasiswa_id' => $this->classesModel->decrypter($__data['mahasiswa_id']),
      'catatan' => $__data['catatan'],
      'kesimpulan' => $__data['kesimpulan'],
      'instrument_data' => $__data['instrument_data'],
      'createBy' => $userId,
      'createDate' => $dateNow
    ]);

    $lastUserId = $this->db->insertID();

    if ($insertInputNilai == 1) {
      $sql = "UPDATE
        `input_jadwal_skripsi`
      SET
        `status` = '1',
        `updateBy` = '{$userId}',
        `updateDate` = '{$dateNow}'
      WHERE `id` = '{$this->classesModel->decrypter($__data['input_nilai_id'])}' AND `dosen_id` = '{$this->classesModel->decrypter($__data['dosen_id'])}'";
      $resultUPdateInputJadwalStatusSkripsi = $this->db->query($sql);

      /** GET Input Jadwal ID */
      $_query = $this->db->table('input_jadwal_skripsi');
      $_query->select('*');
      $resInputJadwalId = $_query->getWhere([
        'id' => $this->classesModel->decrypter($__data['input_nilai_id']),
        'dosen_id' => $this->classesModel->decrypter($__data['dosen_id']),
        'status' => '1'
      ])->getRowArray();
      /** [END] - GET Input Jadwal ID */

      if ($resultUPdateInputJadwalStatusSkripsi == 1) {
        $getQuery = $this->db->table('input_jadwal_skripsi');
        $getQuery->select('COUNT(formulir_skripsi_id) AS total_sudah_input');
        $resultData = $getQuery->getWhere([
          'formulir_skripsi_id' => $formulirSkripsiId,
          'status' => '1'
        ])->getRowArray();
        $totalSudahInputNilai = intval($resultData['total_sudah_input']);

        /** Check Total dosen yang ikut serta Input */
        $getFormSkripsiId = $this->db->table('input_jadwal_skripsi');
        $resFromSkripsipId = $getFormSkripsiId->getWhere(['id' => $resInputJadwalId['id']])->getRowArray();

        $getQueryTotalDosen = $this->db->table('input_jadwal_skripsi')->select('COUNT(`formulir_skripsi_id`) AS total_dosen_input');
        $resultTotalInputDosen = $getQueryTotalDosen->getWhere(['formulir_skripsi_id' => $resFromSkripsipId['formulir_skripsi_id']])->getRowArray();
        $totalDosenInput = ($resultTotalInputDosen['total_dosen_input'] - 1);
        /** [END] - Check Total dosen yang ikut serta Input */

        if ($totalSudahInputNilai == $totalDosenInput) {
          $sql = "UPDATE
            `formulir_skripsi`
          SET
            `status` = '4',
            `updateBy` = '{$userId}',
            `updateDate` = '{$dateNow}'
          WHERE `id` = '{$formulirSkripsiId}'";
          $resultUPdateStatusFormSkripsi = $this->db->query($sql);

          if ($resultUPdateStatusFormSkripsi == 1) {
            $response = array("code" => 201, "response" => 'Input Nilai Berhasil Terkirim.');
          } else {
            $response = array("code" => 500, "response" => 'Internal Server Error');
          }
        } else {
          $response = array("code" => 201, "response" => 'Input Nilai Berhasil Terkirim.');
        }
      } else {
        $response = array("code" => 500, "response" => 'Internal Server Error');
      }
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function getMahasiswaId($form_skripsi_id) {
    $getQueryNim = $this->db->table('formulir_skripsi');
    $resultDataFormSup = $getQueryNim->getWhere(['id' => $form_skripsi_id])->getRowArray();

    $getQueryUserData = $this->db->table('user');
    $resultUserData = $getQueryUserData->getWhere(['nim' => $resultDataFormSup['nim']])->getRowArray();

    return $resultUserData['id'];
  }

  public function getJadwalSkripsi($formulir_skripsi_id) {
    $getQuery   = $this->db->table('input_jadwal_skripsi');
    $resultData = $getQuery->getWhere(['formulir_skripsi_id' => $formulir_skripsi_id])->getRowArray();
    return $resultData;
  }

  public function getDataNilaiSkripsi($data) {
    $__data = $data['items'];

    $input_nilai_id = $this->classesModel->decrypter($__data['input_nilai_id']);
    $mahasiswa_id = $this->classesModel->decrypter($__data['mahasiswa_id']);

    $getQuery = $this->db->table('input_nilai');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere([
      'input_jadwal_id' => $input_nilai_id,
      'mahasiswa_id' => $mahasiswa_id,
      'input_jadwal_type' => 'skripsi'
    ])->getRowArray();

    if (!empty($resultData)) {
      $response = array("code" => 201, "response" => array(
        'input_nilai_id' => $this->classesModel->encrypter($resultData['id']),
        'instrument_data' => json_decode($resultData['instrument_data']),
        'kesimpulan' => $resultData['kesimpulan'],
        'catatan' => $resultData['catatan'],
      ));
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }

    return $response;
  }

  public function updateNilaiSkripsi($data) {
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $response = '';

    $inputNilaiId = $this->classesModel->decrypter($__data['input_nilai_id']);
    $mahasiswaId  = $this->classesModel->decrypter($__data['mahasiswa_id']);

    $sql = "UPDATE
      `input_nilai`
    SET
      `catatan` = '{$__data['catatan']}',
      `kesimpulan` = '{$__data['kesimpulan']}',
      `instrument_data` = '{$__data['instrument_data']}',
      `updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$inputNilaiId}' AND `mahasiswa_id` = '{$mahasiswaId}'";
    $resultUPdateInputJadwalStatusSkripsi = $this->db->query($sql);

    if ($resultUPdateInputJadwalStatusSkripsi == 1) {
      $response = array("code" => 201, "response" => 'Input Nilai Berhasil di update.');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }

    return $response;
  }


}