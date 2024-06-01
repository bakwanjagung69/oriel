<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\HasilNilai\HasilNilaiModel;
use App\Models\HasilNilai\HasilNilaiSUPModel;
use App\Models\HasilNilai\HasilNilaiSkripsiModel;
use App\Models\ClassesModel;
use Config\Services;

class HasilNilai extends BaseController {
    protected $classesModel;
    protected $HasilNilaiModel;
    protected $HasilNilaiSUPModel;
    protected $HasilNilaiSkripsiModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->HasilNilaiModel = new HasilNilaiModel();
        $this->HasilNilaiSUPModel = new HasilNilaiSUPModel();
        $this->HasilNilaiSkripsiModel = new HasilNilaiSkripsiModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("hasil-nilai/component-view-hasil-nilai", $data);
    }

    public function getdataSUP() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->HasilNilaiSUPModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];

                /** Admin TU */
                if ($this->session->user_logged['rules'] == 2) {
                    $formulirId = $this->classesModel->encrypter($list->id);
                    $getDataInputJadwal = $this->HasilNilaiSUPModel->getDataInputJadwal($list->id);

                    if (!empty($getDataInputJadwal)) {
                        $getNimMhs = $this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']));
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $this->classesModel->encrypter($getDataInputJadwal['id']));
                    } else {
                        $getNimMhs = '';
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = '';
                    }
                } 

                /** Dosen */
                if ($this->session->user_logged['rules'] == 3) {
                    $_ids = $this->classesModel->encrypter($list->id);
                    $getDataInputJadwal = $this->HasilNilaiSUPModel->getDataInputJadwal($list->input_jadwal_id);
                    $formulirId = $this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']);

                    $getNimMhs = $this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']));
                    $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($getNimMhs['nim']);
                    $resultGradePerDosen = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $_ids);

                    if (!empty($getDataInputJadwal)) {
                        $getNimMhs = $this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']));
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($getNimMhs['nim']);
                        $resultGradePerDosen = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $_ids);
                    } else {
                        $getNimMhs = '';
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($getNimMhs['nim']);
                        $resultGradePerDosen = '';
                    }
                } 

                /** Mahasiswa */
                if ($this->session->user_logged['rules'] == 5) {
                    $formulirId = $this->classesModel->encrypter($list->id);
                    $getDataInputJadwal = $this->HasilNilaiSUPModel->getDataInputJadwal($list->id);

                    if (!empty($getDataInputJadwal)) {
                        $getNimMhs = $this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']));
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $this->classesModel->encrypter($getDataInputJadwal['id']));
                    } else {
                        $getNimMhs = '';
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = '';
                    }

                } 

                if (!empty($getDataInputJadwal)) {
                    $row['input_jadwal_id'] = $this->classesModel->encrypter($getDataInputJadwal['id']);
                    $row['formulir_sup_id'] = $formulirId;
                    // $row['dosen_id'] = $this->classesModel->encrypter($list->dosen_id);

                    $mhsId = $this->HasilNilaiSUPModel->getMahasiswaId($getDataInputJadwal['formulir_sup_id']);
                    $row['mahasiswa_id'] = $this->classesModel->encrypter($mhsId);
                    $row['nama'] = $this->HasilNilaiModel->getUserDataById($mhsId)['full_name'];
                    $row['nim'] =  $this->HasilNilaiModel->getUserDataById($mhsId)['nim'];

                    $row['judul'] = $getDataInputJadwal['judul'];
                    $row['tempat'] = $getDataInputJadwal['tempat'];
                    $row['tanggal'] = date("d-m-Y", strtotime($getDataInputJadwal['tanggal']));       
                    $row['disp_hari_idn'] = $this->HasilNilaiModel->getDisplayHariIdn($getDataInputJadwal['tanggal']);
                    $row['waktu_mulai'] = date("H:i", strtotime($getDataInputJadwal['waktu_mulai']));
                    $row['waktu_akhir'] = date("H:i", strtotime($getDataInputJadwal['waktu_akhir']));  
                    $row['userRules'] = $this->session->user_logged['rules'];     
                    $row['resultGrade'] = $resultGradeAndCatatanKesimpulan['resultGrade'];    
                    $row['resultGradePerDosen'] = $resultGradePerDosen;
                    $row['semester'] = $this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']))['semester'];
                } 

                $data[] = $row;
            }

            /** Admin TU */
            if ($this->session->user_logged['rules'] == 2) {
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    'recordsTotal' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSUPModel->countAll() : 0,
                    'recordsFiltered' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSUPModel->countFiltered() : 0,
                    'data' => (!empty($getDataInputJadwal)) ? $data : []
                ];
            }

            /** Dosen */
            if ($this->session->user_logged['rules'] == 3) {
                if (!empty($getDataInputJadwal)) {
                    $setData = [];
                    if (!empty($this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']))['semester'])) {
                        if ($this->HasilNilaiSUPModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_sup_id']))['semester'] == $this->request->getPost('semester')) {
                            for ($i = 0; $i < count($data); ++$i) {
                                if ($data[$i]['semester'] == $this->request->getPost('semester')) {
                                    array_push($setData, $data[$i]);
                                }
                            }
                        } else {
                            if ($this->request->getPost('semester') == '') {
                                $setData = $data;
                            } else {
                                $setData = [];
                            }
                        }
                    } else {
                        $setData = $data;
                    }

                    $output = [
                        'draw' => $this->request->getPost('draw'),
                        'recordsTotal' => (!empty($setData) ? $this->HasilNilaiSUPModel->countAll() : ''),
                        'recordsFiltered' => (!empty($setData) ? $this->HasilNilaiSUPModel->countFiltered() : ''),
                        'data' => $setData
                    ];
                } else {
                    $output = [
                        'draw' => $this->request->getPost('draw'),
                        'recordsTotal' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSUPModel->countAll() : 0,
                        'recordsFiltered' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSUPModel->countFiltered() : 0,
                        'data' => (!empty($getDataInputJadwal)) ? $data : []
                    ];
                }
            }

            /** Mahasiswa */
            if ($this->session->user_logged['rules'] == 5) {
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    'recordsTotal' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSUPModel->countAll() : 0,
                    'recordsFiltered' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSUPModel->countFiltered() : 0,
                    'data' => (!empty($getDataInputJadwal)) ? $data : []
                ];
            }

        }
        return $this->response->setJson($output);
    }

    public function getdataSkripsi() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->HasilNilaiSkripsiModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                /** Admin TU */
                if ($this->session->user_logged['rules'] == 2) {
                    $formulirId = $this->classesModel->encrypter($list->id);
                    $getDataInputJadwal = $this->HasilNilaiSkripsiModel->getDataInputJadwal($list->id);

                    if (!empty($getDataInputJadwal)) {
                        $getNimMhs = $this->HasilNilaiSkripsiModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']));
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $this->classesModel->encrypter($getDataInputJadwal['id']));
                    } else {
                        $getNimMhs = '';
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = '';
                    }
                } 

                /** Dosen */
                if ($this->session->user_logged['rules'] == 3) {
                    $_ids = $this->classesModel->encrypter($list->id);
                    $getDataInputJadwal = $this->HasilNilaiSkripsiModel->getDataInputJadwal($list->input_jadwal_id);
                    $formulirId = $this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']);

                    if (!empty($getDataInputJadwal)) {
                        $getNimMhs = $this->HasilNilaiSkripsiModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']));
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($getNimMhs['nim']);
                        $resultGradePerDosen = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $_ids);
                    } else {
                        $getNimMhs = '';
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($getNimMhs['nim']);
                        $resultGradePerDosen = '';
                    }

                } 

                /** Mahasiswa */
                if ($this->session->user_logged['rules'] == 5) {
                    $formulirId = $this->classesModel->encrypter($list->id);
                    $getDataInputJadwal = $this->HasilNilaiSkripsiModel->getDataInputJadwal($list->id);

                    if (!empty($getDataInputJadwal)) {
                        $getNimMhs = $this->HasilNilaiSkripsiModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']));
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradePerDosen($getNimMhs['nim'], $this->classesModel->encrypter($getDataInputJadwal['id']));
                    } else {
                        $getNimMhs = '';
                        $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($list->nim);
                        $resultGradePerDosen = '';
                    }

                } 

                $no++;
                $row = [];
                $row['input_jadwal_id'] = $this->classesModel->encrypter($getDataInputJadwal['id']);
                $row['formulir_skripsi_id'] = $formulirId;
                // $row['dosen_id'] = $this->classesModel->encrypter($list->dosen_id);

                $mhsId = $this->HasilNilaiSkripsiModel->getMahasiswaId($getDataInputJadwal['formulir_skripsi_id']);
                $row['mahasiswa_id'] = $this->classesModel->encrypter($mhsId);
                $row['nama'] = $this->HasilNilaiModel->getUserDataById($mhsId)['full_name'];
                $row['nim'] =  $this->HasilNilaiModel->getUserDataById($mhsId)['nim'];

                $row['judul'] = $getDataInputJadwal['judul'];
                $row['tempat'] = $getDataInputJadwal['tempat'];
                $row['tanggal'] = date("d-m-Y", strtotime($getDataInputJadwal['tanggal']));       
                $row['disp_hari_idn'] = $this->HasilNilaiModel->getDisplayHariIdn($getDataInputJadwal['tanggal']);
                $row['waktu_mulai'] = date("H:i", strtotime($getDataInputJadwal['waktu_mulai']));
                $row['waktu_akhir'] = date("H:i", strtotime($getDataInputJadwal['waktu_akhir']));  
                $row['userRules'] = $this->session->user_logged['rules'];     
                $row['resultGrade'] = $resultGradeAndCatatanKesimpulan['resultGrade'];    
                $row['resultGradePerDosen'] = $resultGradePerDosen;      
                $row['semester'] = $this->HasilNilaiSkripsiModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']))['semester'];
                $data[] = $row;
            }

            /** Admin TU */
            if ($this->session->user_logged['rules'] == 2) {
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    'recordsTotal' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSkripsiModel->countAll() : 0,
                    'recordsFiltered' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSkripsiModel->countFiltered() : 0,
                    'data' => (!empty($getDataInputJadwal)) ? $data : []
                ];
            }

            /** Dosen */
            if ($this->session->user_logged['rules'] == 3) {
                if (!empty($getDataInputJadwal)) {
                    $setData = [];
                    if (!empty($this->HasilNilaiSkripsiModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']))['semester'])) {
                        if ($this->HasilNilaiSkripsiModel->getById($this->classesModel->encrypter($getDataInputJadwal['formulir_skripsi_id']))['semester'] == $this->request->getPost('semester')) {
                            for ($i = 0; $i < count($data); ++$i) {
                                if ($data[$i]['semester'] == $this->request->getPost('semester')) {
                                    array_push($setData, $data[$i]);
                                }
                            }
                        } else {
                            if ($this->request->getPost('semester') == '') {
                                $setData = $data;
                            } else {
                                $setData = [];
                            }
                        }
                    } else {
                        $setData = $data;
                    }

                    $output = [
                        'draw' => $this->request->getPost('draw'),
                        'recordsTotal' => (!empty($setData) ? $this->HasilNilaiSkripsiModel->countAll() : ''),
                        'recordsFiltered' => (!empty($setData) ? $this->HasilNilaiSkripsiModel->countFiltered() : ''),
                        'data' => $setData
                    ];
                } else {
                    $output = [
                        'draw' => $this->request->getPost('draw'),
                        'recordsTotal' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSkripsiModel->countAll() : 0,
                        'recordsFiltered' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSkripsiModel->countFiltered() : 0,
                        'data' => (!empty($getDataInputJadwal)) ? $data : []
                    ];
                }
            }

            /** Mahasiswa */
            if ($this->session->user_logged['rules'] == 5) {
                $output = [
                    'draw' => $this->request->getPost('draw'),
                    'recordsTotal' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSkripsiModel->countAll() : 0,
                    'recordsFiltered' => (!empty($getDataInputJadwal)) ? $this->HasilNilaiSkripsiModel->countFiltered() : 0,
                    'data' => (!empty($getDataInputJadwal)) ? $data : []
                ];
            }

        }
        return $this->response->setJson($output);
    }

    public function details($id = '') {
       /** Check if not login */
        $this->classesModel->checkIsNotLogin();
        $pathFile = '';

        if (isset($_GET['q'])) {
            if ($_GET['type'] == 'sup') {
                $__data = $this->HasilNilaiSUPModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];

                $getDataJadwal = $this->HasilNilaiSUPModel->getJadwalSUP($__data['id']);
                $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSUPModel->calculateTotalNilaiToGradeResult($__data['nim']);

                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;
                $dosenPembimbingUjiKelayakan = $this->HasilNilaiSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($__data['nim']);

                $arrSet = array_replace($__data, array(
                    'formulir_sup_id' => $this->classesModel->encrypter($__data['id']),
                    'proposal_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['proposal_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'proposal_files_name' => $__data['proposal_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'mahasiswa_id' => $this->classesModel->encrypter($this->HasilNilaiModel->getUserDataByNim($__data['nim'])['id']),
                    'prefix_data' => 'sup',
                    'judul' => $getDataJadwal['judul'],
                    'tempat' => $getDataJadwal['tempat'],
                    'tanggal' => date("d-m-Y", strtotime($getDataJadwal['tanggal'])),
                    'waktu_mulai' => date("H:i", strtotime($getDataJadwal['waktu_mulai'])),
                    'waktu_akhir' => date("H:i", strtotime($getDataJadwal['waktu_akhir'])),
                    'status' => $__data['status'],
                    'semester' => $__data['semester'],    
                    'resultGradeAndCatatanKesimpulan' => $resultGradeAndCatatanKesimpulan,
                    'jadwalInputNilaiId' => $_GET['jadwalInputNilaiId'],
                    'dosenData' => (!empty($dosenPembimbingUjiKelayakan) ? $dosenPembimbingUjiKelayakan : [])
                ));

                $data['data'] = $arrSet;
                $pathFile = "hasil-nilai/component-view-hasil-nilai-sup-details";
            }

            if ($_GET['type'] == 'skripsi') {
                $__data = $this->HasilNilaiSkripsiModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];

                $getDataJadwal = $this->HasilNilaiSkripsiModel->getJadwalSkripsi($__data['id']);
                $resultGradeAndCatatanKesimpulan = $this->HasilNilaiSkripsiModel->calculateTotalNilaiToGradeResult($__data['nim']);

                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;
                $dosenPembimbingUjiKelayakan = $this->HasilNilaiSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($__data['nim']);

                $arrSet = array_replace($__data, array(
                    'formulir_skripsi_id' => $this->classesModel->encrypter($__data['id']),
                    'skripsi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['skripsi_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'skripsi_files_name' => $__data['skripsi_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'mahasiswa_id' => $this->classesModel->encrypter($this->HasilNilaiModel->getUserDataByNim($__data['nim'])['id']),
                    'prefix_data' => 'skripsi',
                    'judul' => $getDataJadwal['judul'],
                    'tempat' => $getDataJadwal['tempat'],
                    'tanggal' => date("d-m-Y", strtotime($getDataJadwal['tanggal'])),
                    'waktu_mulai' => date("H:i", strtotime($getDataJadwal['waktu_mulai'])),
                    'waktu_akhir' => date("H:i", strtotime($getDataJadwal['waktu_akhir'])),
                    'status' => $__data['status'],
                    'semester' => $__data['semester'],    
                    'resultGradeAndCatatanKesimpulan' => $resultGradeAndCatatanKesimpulan,
                    'jadwalInputNilaiId' => $_GET['jadwalInputNilaiId'],
                    'dosenData' => (!empty($dosenPembimbingUjiKelayakan) ? $dosenPembimbingUjiKelayakan : [])
                ));

                $data['data'] = $arrSet;
                $pathFile = "hasil-nilai/component-view-hasil-nilai-skripsi-details";
            }

        } else {
            $data["data"] = array('id' => '');
        }
        return $this->template->Frontend($pathFile, $data);
    }


    public function getDataPenugasanDosenPenguji() {
        $userId = $this->session->user_logged['id'];
        $rules  = $this->session->user_logged['rules'];
        $data = [];

        if ($_GET['type'] == 'sup') {
            $result = $this->HasilNilaiSUPModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_sup');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_sup_id'] = $this->classesModel->encrypter($item->formulir_sup_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->HasilNilaiModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        if ($_GET['type'] == 'skripsi') {
            $result = $this->HasilNilaiSkripsiModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_skripsi');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_skripsi_id'] = $this->classesModel->encrypter($item->formulir_skripsi_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->HasilNilaiModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        return $this->response->setJson($data);
    }

    public function views() {
        if ($_GET['prefixData'] == 'sup') {
            $result = $this->HasilNilaiSUPModel->getDataHasilNilaiPerDosen($_GET['dosenId'], $_GET['mahasiswaId']);
        }

        if ($_GET['prefixData'] == 'skripsi') {
            $result = $this->HasilNilaiSkripsiModel->getDataHasilNilaiPerDosen($_GET['dosenId'], $_GET['mahasiswaId']);
        }
        
        $valid = (empty($result)) ? 0 : 1; 

        if ($valid == 1) {
            $arrInstrumenData = json_decode($result['instrument_data']);

            $arrSet = array_replace($result, array(
                'id' => $this->classesModel->encrypter($result['id']),
                'user_images' => array(
                   'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($result['dosen_id'])['images']),
                   'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($result['dosen_id'])['thumbnail_images'])
                ),
                'dosen_name' => ucfirst($this->HasilNilaiModel->getUserDataById($result['dosen_id'])['full_name']),
                'dosen_rules' => $this->HasilNilaiModel->getUserDataById($result['dosen_id'])['rules'],
                'prefix_data' => 'sup',
                'dosen_id' => $this->classesModel->encrypter($result['dosen_id']),
                'mahasiswa_id' => $this->classesModel->encrypter($result['mahasiswa_id']),
                'input_jadwal_id' => $this->classesModel->encrypter($result['input_jadwal_id']),
                'total_nilai_akhir' => $arrInstrumenData[count($arrInstrumenData) - 1],
                'instrument_data' => $arrInstrumenData
            ));

            $data['data'] = $arrSet;
            
            if ($_GET['prefixData'] == 'sup') {
                return $this->template->Frontend("hasil-nilai/component-view-hasil-nilai-dosen", $data);
            }

            if ($_GET['prefixData'] == 'skripsi') {
                return $this->template->Frontend("hasil-nilai/component-view-hasil-nilai-dosen-skripsi", $data);
            }
        } else {
            $data['data'] = array(
                'id' => '',
                'user_images' => array(
                   'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($this->classesModel->decrypter($_GET['dosenId']))['images']),
                   'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilNilaiModel->getUserDataById($this->classesModel->decrypter($_GET['dosenId']))['thumbnail_images'])
                ),
                'dosen_name' => ucfirst($this->HasilNilaiModel->getUserDataById($this->classesModel->decrypter($_GET['dosenId']))['full_name']),
                'dosen_rules' => $this->HasilNilaiModel->getUserDataById($this->classesModel->decrypter($_GET['dosenId']))['rules'],
                'prefix_data' => 'sup',
                'dosen_id' => $_GET['dosenId'],
                'mahasiswa_id' => $_GET['mahasiswaId'],
                'input_jadwal_id' => '',
                'catatan' => '-',
                'kesimpulan' => '-',
                'total_nilai_akhir' => (object) array(
                    'total_all_instrument_iput' => '0',
                    'nilai_akhir_nu' => '-',
                    'total_nilai_value' => '0'
                ),
                'instrument_data' => [
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'element_name' => '',
                        'element_value' => '0'
                    ),
                    (object) array(
                        'total_all_instrument_iput' => '0',
                        'nilai_akhir_nu' => '-',
                        'total_nilai_value' => '0'
                    )
                ]
            );


            if ($_GET['prefixData'] == 'sup') {
                return $this->template->Frontend("hasil-nilai/component-view-hasil-nilai-dosen", $data);
            }

            if ($_GET['prefixData'] == 'skripsi') {
                return $this->template->Frontend("hasil-nilai/component-view-hasil-nilai-dosen-skripsi", $data);
            }
        }
    }

}
