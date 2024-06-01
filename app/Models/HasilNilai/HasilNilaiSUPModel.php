<?php

namespace App\Models\HasilNilai;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class HasilNilaiSUPModel extends Model {
  protected $table = 'formulir_sup';
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
            if (count($this->column_search) - 1 == $i);
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
    if ($this->session->user_logged['rules'] == 1) {
      if ($this->request->getPost('semester') !== '') {
        $query = $this->dt->getWhere([
          'semester' => $this->request->getPost('semester')
        ]);
      } else {
        $query = $this->dt->get();
      }
    } 

    /** Admin TU */
    if ($this->session->user_logged['rules'] == 2) {
      if ($this->request->getPost('semester') !== '') {
        $query = $this->dt->getWhere([
          'semester' => $this->request->getPost('semester')
        ]);
      } else {
        $query = $this->dt->get();
      }
    } 
    
    /** Dosen */
    if ($this->session->user_logged['rules'] == 3) {
      $getQuery = $this->db->table('input_nilai');
      $query    = $getQuery->select('*');

      if ($this->request->getPost('semester') !== '') {
        $queryParams = [
          'dosen_id' => $this->session->user_logged['id'], 
          'input_jadwal_type' => 'sup',
          // 'semester' => $this->request->getPost('semester')
        ];
      } else {
        $queryParams = ['dosen_id' => $this->session->user_logged['id'], 'input_jadwal_type' => 'sup'];
      }

      $query = $query->getWhere($queryParams);
    } 

    /** Kaprodi */
    if ($this->session->user_logged['rules'] == 4) {
      if ($this->request->getPost('semester') !== '') {
        $query = $this->dt->getWhere([
          'semester' => $this->request->getPost('semester')
        ]);
      } else {
        $query = $this->dt->get();
      }
    } 

    /** Mahasiswa */
    if ($this->session->user_logged['rules'] == 5) {
      $getQuery = $this->db->table('user');
      $getQuery->select('*');
      $resultData = $getQuery->getWhere(['id' => $this->session->user_logged['id']])->getRowArray();

      if ($this->request->getPost('semester') !== '') {
        $queryParams = ['nim' => $resultData['nim'], 'semester' => $this->request->getPost('semester')];
      } else {
        $queryParams = ['nim' => $resultData['nim']];
      }

      $query = $this->dt->getWhere($queryParams);
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

    $getQuery = $this->db->table('formulir_sup');
    $getQuery->select('*');
    $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    return $resultData;
  }

  public function getMahasiswaId($form_sup_id) {
    $getQueryNim = $this->db->table('formulir_sup');
    $resultDataFormSup = $getQueryNim->getWhere(['id' => $form_sup_id])->getRowArray();

    $getQueryUserData = $this->db->table('user');
    $resultUserData = $getQueryUserData->getWhere(['nim' => $resultDataFormSup['nim']])->getRowArray();

    return $resultUserData['id'];
  }

  public function getDataInputJadwal($ids) {
    $resultData = '';

    /** Admin TU */
    if ($this->session->user_logged['rules'] == 2) {
      $getQuery   = $this->db->table('input_jadwal_sup');
      $resultData = $getQuery->getWhere(['formulir_sup_id' => $ids])->getRowArray();
    } 

    /** DOSEN */
    if ($this->session->user_logged['rules'] == 3) {
      $getQuery   = $this->db->table('input_jadwal_sup');
      $resultData = $getQuery->getWhere(['id' => $ids])->getRowArray();
    } 

    /** Mahasiswa */
    if ($this->session->user_logged['rules'] == 5) {
      $getQuery   = $this->db->table('input_jadwal_sup');
      $resultData = $getQuery->getWhere(['formulir_sup_id' => $ids])->getRowArray();
    } 

    return $resultData;
  }

  public function getPenugasanDosenPenguji($formulir_id, $tableName) {
    $formulirId = $this->classesModel->decrypter($formulir_id);

    $getQuery   = $this->db->table($tableName);
    $resultData = $getQuery->getWhere(['formulir_sup_id' => $formulirId])->getResult();
    return $resultData;
  }

  public function calculateTotalNilaiToGradeResult($nim) {
    $getQueryUser   = $this->db->table('user');
    $resultUserData = $getQueryUser->getWhere(['nim' => $nim])->getRowArray();
    $mhsId = $resultUserData['id'];

    $getQueryInputNilai   = $this->db->table('input_nilai');
    $resultDataInputNilai = $getQueryInputNilai->getWhere(['mahasiswa_id' => $mhsId, 'input_jadwal_type' => 'sup'])->getResult();

    $arrTotalNilai = array();
    $arrCatatanAndKesimpulan = array();
    $arrInstrumentDataList = '';
    $catatanPerDosen = '';
    $kesimpulanPerDosen = '';
    $dosenNamePerDosen = '';

    foreach ($resultDataInputNilai as $items) {
      $arrInstrumentData = json_decode($items->instrument_data, true);

      $userId = $this->session->user_logged['id'];
      if ($items->dosen_id == $userId) {

        $getQueryUser   = $this->db->table('user');
        $resultUserData = $getQueryUser->getWhere(['id' => $items->dosen_id])->getRowArray();
        $dosenName = $resultUserData['full_name'];

        $dosenNamePerDosen = $dosenName;
        $catatanPerDosen = $items->catatan;
        $kesimpulanPerDosen = $items->kesimpulan;

        $arrInstrumentDataList = $arrInstrumentData;
      }

      $getQueryUser   = $this->db->table('user');
      $resultUserData = $getQueryUser->getWhere(['id' => $items->dosen_id])->getRowArray();
      $dosenName = $resultUserData['full_name'];

      $getFormSupId = $this->db->table('input_jadwal_sup');
      $resFromSupId = $getFormSupId->getWhere(['id' => $items->input_jadwal_id])->getRowArray();

      $getQueryTotalDosen = $this->db->table('input_jadwal_sup')->select('COUNT(`formulir_sup_id`) AS total_dosen_input');
      $resultTotalInputDosen = $getQueryTotalDosen->getWhere(['formulir_sup_id' => $resFromSupId['formulir_sup_id']])->getRowArray();
      $totalDosenInput = ($resultTotalInputDosen['total_dosen_input'] - 1);

      array_push($arrTotalNilai, ceil($arrInstrumentData[count($arrInstrumentData) - 1]['total_nilai_value'] / $totalDosenInput));

      array_push($arrCatatanAndKesimpulan, array(
        'catatan' => array(
          'dosenName' => $dosenName,
          'text' => $items->catatan
        ),
        'kesimpulan' => array(
          'dosenName' => $dosenName,
          'text' => $items->kesimpulan
        )
      ));
    }

    $totalSumValueAllDosen = array_sum($arrTotalNilai);

    $resultGrade = '';
    $styleColor = '#000';
    if ($totalSumValueAllDosen >= 100) {
      $resultGrade = 'A';
      $styleColor = '#1cc88a';
    } else if ($totalSumValueAllDosen >= 86 && $totalSumValueAllDosen <= 100) {
      $resultGrade = 'A';
      $styleColor = '#1cc88a';
    } else if ($totalSumValueAllDosen >= 81 && $totalSumValueAllDosen <= 85) {
      $resultGrade = 'A-';
      $styleColor = '#1cc88a';
    } else if ($totalSumValueAllDosen >= 76 && $totalSumValueAllDosen <= 80) {
      $resultGrade = 'B+';
      $styleColor = '#007bff';
    } else if ($totalSumValueAllDosen >= 71 && $totalSumValueAllDosen <= 75) {
      $resultGrade = 'B';
      $styleColor = '#007bff';
    } else if ($totalSumValueAllDosen >= 66 && $totalSumValueAllDosen <= 70) {
      $resultGrade = 'B-';
      $styleColor = '#007bff';
    } else if ($totalSumValueAllDosen >= 61 && $totalSumValueAllDosen <= 65) {
      $resultGrade = 'C+';
      $styleColor = '#fbff00';
    } else if ($totalSumValueAllDosen >= 56 && $totalSumValueAllDosen <= 61) {
      $resultGrade = 'C';
      $styleColor = '#fbff00';
    } else if ($totalSumValueAllDosen >= 51 && $totalSumValueAllDosen <= 56) {
      $resultGrade = 'C-';
      $styleColor = '#fbff00';
    } else if ($totalSumValueAllDosen >= 46 && $totalSumValueAllDosen <= 51) {
      $resultGrade = 'D+';
      $styleColor = '#f6c23e';
    } else if ($totalSumValueAllDosen >= 41 && $totalSumValueAllDosen <= 46) {
      $resultGrade = 'D';
      $styleColor = '#f6c23e';
    } else if ($totalSumValueAllDosen >= 0 && $totalSumValueAllDosen <= 41) {
      $resultGrade = 'E';
      $styleColor = '#f00';
    }

    return array(
      'resultGrade' => $resultGrade,
      'resultScore' => $totalSumValueAllDosen,
      'styleColor' => $styleColor,
      'catatanAndKesimpulan' => $arrCatatanAndKesimpulan,
      'instrumentData' => $arrInstrumentDataList,
      'dosenNamePerDosen' => $dosenNamePerDosen,
      'catatanPerDosen' => $catatanPerDosen,
      'kesimpulanPerDosen' => $kesimpulanPerDosen
    );
  }

  public function getDataHasilNilaiPerDosen($dosenId, $mahasiswaId) {
    $__dosenId     = $this->classesModel->decrypter($dosenId);
    $__mahasiswaId = $this->classesModel->decrypter($mahasiswaId);

    $getQuery   = $this->db->table('input_nilai');
    $resultData = $getQuery->getWhere([
      'dosen_id' => $__dosenId, 
      'mahasiswa_id' => $__mahasiswaId,
      'input_jadwal_type' => 'sup'
    ])->getRowArray();
    return $resultData;
  }

  public function getJadwalSUP($formulir_sup_id) {
    $getQuery   = $this->db->table('input_jadwal_sup');
    $resultData = $getQuery->getWhere(['formulir_sup_id' => $formulir_sup_id])->getRowArray();
    return $resultData;
  }

  public function calculateTotalNilaiToGradePerDosen($nim, $inputNilaiId) {
    $getQueryUser   = $this->db->table('user');
    $resultUserData = $getQueryUser->getWhere(['nim' => $nim])->getRowArray();
    $mhsId = $resultUserData['id'];

    $getQueryInputNilai   = $this->db->table('input_nilai');
    $resultDataInputNilai = $getQueryInputNilai->getWhere([
      'mahasiswa_id' => $mhsId, 
      'input_jadwal_type' => 'sup',
      'id' => $this->classesModel->decrypter($inputNilaiId)
    ])->getRowArray();

    $gradeNilai = '-';
    $rest = '';
    if (!empty($resultDataInputNilai)) {
      if (!empty(json_decode($resultDataInputNilai['instrument_data']))) {
        $instrumentData = json_decode($resultDataInputNilai['instrument_data']);
        $gradeNilai = $instrumentData[(count($instrumentData) - 1)]->nilai_akhir_nu;
      } else {
        $gradeNilai = '-';
      }
      $rest = (!empty($resultDataInputNilai)) ? $gradeNilai : '';
    } else {
      $gradeNilai = '-';
    }

    return $rest;
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

}