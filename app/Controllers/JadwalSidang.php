<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\JadwalSidang\JadwalSidangModel;
use App\Models\JadwalSidang\JadwalSidangUjiKelayakanModel;
use App\Models\JadwalSidang\JadwalSidangSUPModel;
use App\Models\JadwalSidang\JadwalSidangSkripsiModel;
use App\Models\ClassesModel;
use Config\Services;

class JadwalSidang extends BaseController {
    protected $classesModel;
    protected $JadwalSidangModel;
    protected $JadwalSidangUjiKelayakanModel;
    protected $JadwalSidangSUPModel;
    protected $JadwalSidangSkripsiModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->JadwalSidangModel = new JadwalSidangModel();
        $this->JadwalSidangUjiKelayakanModel = new JadwalSidangUjiKelayakanModel();
        $this->JadwalSidangSUPModel = new JadwalSidangSUPModel();
        $this->JadwalSidangSkripsiModel = new JadwalSidangSkripsiModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("jadwal-sidang/component-view-jadwal-sidang", $data);
    }

    public function getdataSUP() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->JadwalSidangSUPModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_input_jadwal_id = $this->classesModel->encrypter($list->id);
                $getStatusFormSup = $this->JadwalSidangSUPModel->getById($this->classesModel->encrypter($list->formulir_sup_id));
                $getStatusKesimpulan = $this->JadwalSidangSUPModel->getStatusKesimpulan($_input_jadwal_id, $list->mahasiswa_id);

                $no++;
                $row = [];
                $row['id'] = $_input_jadwal_id;  
                $row['formulir_sup_id'] = $this->classesModel->encrypter($list->formulir_sup_id);

                if ($this->session->user_logged['rules'] == 2) {
                    $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                    $row['nim'] = $nim;

                    $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                    $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSUPData'] = $dospemSUPData;
                } 
                
                if ($this->session->user_logged['rules'] == 3) {
                    $res = $this->JadwalSidangSUPModel->getById($this->classesModel->encrypter($list->formulir_sup_id));

                    $userData = $this->JadwalSidangSUPModel->getUserData($this->classesModel->encrypter($res['nim']));
                    $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($res['nim']);
                    $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['full_name'];
                    $row['nim'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['nim'];
                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSUPData'] = $dospemSUPData;
                } 

                if ($this->session->user_logged['rules'] == 4) {
                    $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                    $row['nim'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                    $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                    $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSUPData'] = $dospemSUPData;
                } 

                if ($this->session->user_logged['rules'] == 5) {
                    $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                    $row['nim'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                    $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                    $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSUPData'] = $dospemSUPData;
                }

                $row['judul'] = $list->judul;
                $row['tempat'] = $list->tempat;
                $row['tanggal'] = date("d-m-Y", strtotime($list->tanggal));       
                $row['disp_hari_idn'] = $this->JadwalSidangModel->getDisplayHariIdn($list->tanggal);
                $row['waktu_mulai'] = date("H:i", strtotime($list->waktu_mulai));
                $row['waktu_akhir'] = date("H:i", strtotime($list->waktu_akhir));  
                $row['userRules'] = $this->session->user_logged['rules'];
                $row['keterangan'] = $list->keterangan;
                $row['status'] = (!empty($getStatusFormSup) ? $getStatusFormSup['status'] : '');
                $row['semester'] = (!empty($getStatusFormSup) ? $getStatusFormSup['semester'] : '');
                $row['status_kesimpulan'] = $getStatusKesimpulan;
                $data[] = $row;
            }

            $setData = [];
            if (!empty($getStatusFormSup)) {
                if ($getStatusFormSup['semester'] == $this->request->getPost('semester')) {
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
                'recordsTotal' => (!empty($setData) ? $this->JadwalSidangSUPModel->countAll() : ''),
                'recordsFiltered' => (!empty($setData) ? $this->JadwalSidangSUPModel->countFiltered() : ''),
                'data' => $setData
            ];
        }
        return $this->response->setJson($output);
    }

    public function getdataSkripsi() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->JadwalSidangSkripsiModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $getStatusFormSkripsi = $this->JadwalSidangSkripsiModel->getById($this->classesModel->encrypter($list->formulir_skripsi_id));
                $getStatusKesimpulan = $this->JadwalSidangSkripsiModel->getStatusKesimpulan($_ids, $this->classesModel->encrypter($list->mahasiswa_id));

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['formulir_skripsi_id'] = $this->classesModel->encrypter($list->formulir_skripsi_id);

                if ($this->session->user_logged['rules'] == 2) {
                    $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                    $row['nim'] = $nim;

                    $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                    $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSkripsiData'] = $dospemSkripsiData;
                } 
                
                if ($this->session->user_logged['rules'] == 3) {
                    $res = $this->JadwalSidangSkripsiModel->getById($this->classesModel->encrypter($list->formulir_skripsi_id));

                    $userData = $this->JadwalSidangSkripsiModel->getUserData($this->classesModel->encrypter($res['nim']));
                    $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($res['nim']);
                    $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['full_name'];
                    $row['nim'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['nim'];
                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSkripsiData'] = $dospemSkripsiData;
                } 

                if ($this->session->user_logged['rules'] == 4) {
                    $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                    $row['nim'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                    $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                    $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSkripsiData'] = $dospemSkripsiData;
                } 

                if ($this->session->user_logged['rules'] == 5) {
                    $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                    $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                    $row['nim'] = $nim;

                    $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                    $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                    $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                    $row['dospemSkripsiData'] = $dospemSkripsiData;
                }

                $row['judul'] = $list->judul;
                $row['tempat'] = $list->tempat;
                $row['tanggal'] = date("d-m-Y", strtotime($list->tanggal));       
                $row['disp_hari_idn'] = $this->JadwalSidangModel->getDisplayHariIdn($list->tanggal);
                $row['waktu_mulai'] = date("H:i", strtotime($list->waktu_mulai));
                $row['waktu_akhir'] = date("H:i", strtotime($list->waktu_akhir));  
                $row['userRules'] = $this->session->user_logged['rules'];
                $row['keterangan'] = $list->keterangan;
                $row['status'] = (!empty($getStatusFormSkripsi['status']) ? $getStatusFormSkripsi['status'] : '');
                $row['semester'] = (!empty($getStatusFormSkripsi['semester']) ? $getStatusFormSkripsi['semester'] : '');
                $row['status_kesimpulan'] = $getStatusKesimpulan;                
                $data[] = $row;
            }

            $setData = [];
            if (!empty($getStatusFormSkripsi['semester'])) {
                if ($getStatusFormSkripsi['semester'] == $this->request->getPost('semester')) {
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
                'recordsTotal' => (!empty($setData) ? $this->JadwalSidangSkripsiModel->countAll() : ''),
                'recordsFiltered' => (!empty($setData) ? $this->JadwalSidangSkripsiModel->countFiltered() : ''),
                'data' => $setData
            ];
        }
        return $this->response->setJson($output);
    }

    public function details($id = '') {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
        $pathFile = '';

        if (isset($_GET['q'])) {
            if ($_GET['type'] == 'uji_kelayakan') {
                $__data = $this->JadwalSidangUjiKelayakanModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];

                $arrSet = array_replace($__data, array(
                    'uji_kelayakan_id' => $this->classesModel->encrypter($__data['id']),
                    'kaprodi_id' => $this->classesModel->encrypter($userId),
                    'files' => $this->classesModel->encrypter('assets/upload/uji-kelayakan/'.$__data['files']),
                    'files_name' => $__data['files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'prefix_data' => 'uji_kelayakan',
                    'tempat' => $_GET['tempat'],
                    'tanggal_dan_waktu' => $_GET['tanggalWaktu']
                ));

                $data['data'] = $arrSet;
                $pathFile = "jadwal-sidang/component-view-jadwal-sidang-uji-kelayakan-details";
            }

            if ($_GET['type'] == 'sup') {
                $__data = $this->JadwalSidangSUPModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];
                $getDataJadwal = $this->JadwalSidangSUPModel->getJadwalSUP($__data['id']);

                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;
                $dosenPembimbingUjiKelayakan = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($__data['nim']);

                $arrSet = array_replace($__data, array(
                    'formulir_sup_id' => $this->classesModel->encrypter($__data['id']),
                    'userId' => $this->classesModel->encrypter($userId),
                    'proposal_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['proposal_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'proposal_files_name' => $__data['proposal_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'prefix_data' => 'sup',
                    'judul' => $getDataJadwal['judul'],
                    'tempat' => $getDataJadwal['tempat'],
                    'tanggal' => date("d-m-Y", strtotime($getDataJadwal['tanggal'])),
                    'keterangan' => $getDataJadwal['keterangan'],
                    'waktu_mulai' => date("H:i", strtotime($getDataJadwal['waktu_mulai'])),
                    'waktu_akhir' => date("H:i", strtotime($getDataJadwal['waktu_akhir'])),
                    'status' => $__data['status'],
                    'semester' => $__data['semester'],
                    'dosenData' => (!empty($dosenPembimbingUjiKelayakan) ? $dosenPembimbingUjiKelayakan : [])
                ));

                $data['data'] = $arrSet;
                $pathFile = "jadwal-sidang/component-view-jadwal-sidang-sup-details";
            }

            if ($_GET['type'] == 'skripsi') {
                $__data = $this->JadwalSidangSkripsiModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];
                $getDataJadwal = $this->JadwalSidangSkripsiModel->getJadwalSkripsi($__data['id']);

                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;
                $dosenPembimbingUjiKelayakan = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($__data['nim']);

                $arrSet = array_replace($__data, array(
                    'skripsi_id' => $this->classesModel->encrypter($__data['id']),
                    'skripsi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['skripsi_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'skripsi_files_name' => $__data['skripsi_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'prefix_data' => 'skripsi',
                    'judul' => $getDataJadwal['judul'],
                    'tempat' => $getDataJadwal['tempat'],
                    'keterangan' => $getDataJadwal['keterangan'],
                    'tanggal' => date("d-m-Y", strtotime($getDataJadwal['tanggal'])),
                    'waktu_mulai' => date("H:i", strtotime($getDataJadwal['waktu_mulai'])),
                    'waktu_akhir' => date("H:i", strtotime($getDataJadwal['waktu_akhir'])),
                    'status' => $__data['status'],
                    'semester' => $__data['semester'],
                    'dosenData' => (!empty($dosenPembimbingUjiKelayakan) ? $dosenPembimbingUjiKelayakan : [])
                ));

                $data['data'] = $arrSet;
                $pathFile = "jadwal-sidang/component-view-jadwal-sidang-skripsi-details";
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

        if ($_GET['type'] == 'uji_kelayakan') {
            $result = $this->JadwalSidangUjiKelayakanModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_uji_kelayakan');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_uji_kelayakan_id'] = $this->classesModel->encrypter($item->formulir_uji_kelayakan_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->JadwalSidangModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        if ($_GET['type'] == 'sup') {
            $result = $this->JadwalSidangSUPModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_sup');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_sup_id'] = $this->classesModel->encrypter($item->formulir_sup_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->JadwalSidangModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        if ($_GET['type'] == 'skripsi') {
            $result = $this->JadwalSidangSkripsiModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_skripsi');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_skripsi_id'] = $this->classesModel->encrypter($item->formulir_skripsi_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->JadwalSidangModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->JadwalSidangModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        return $this->response->setJson($data);
    }

    public function dosenList() {
        $result = $this->JadwalSidangModel->getAllDosenListData();

        $data = [];
        foreach ($result as $item) {
            $row = [];

            $row['id'] = $this->classesModel->encrypter($item->id);
            $row['full_name'] = $item->full_name;

            $data[] = $row;
        }

        return $this->response->setJson($data);
    }

    public function addSuratTugas() {
        $post = $this->request->getVar();
        $resultData = '';

        if ($post['prefixData'] == 'uji_kelayakan') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->JadwalSidangUjiKelayakanModel->AddNewDataKirimJadwalSidang($__data);
        }

        if ($post['prefixData'] == 'sup') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->JadwalSidangSUPModel->AddNewDataKirimJadwalSidang($__data);
        }

        if ($post['prefixData'] == 'skripsi') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->JadwalSidangSkripsiModel->AddNewDataKirimJadwalSidang($__data);
        }

        return $this->response->setJson($resultData);
    }

    public function updateJadwal() {
        $post = $this->request->getVar();
        $resultData = '';

        if ($post['prefixData'] == 'uji_kelayakan') {

        }

        if ($post['prefixData'] == 'sup') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->JadwalSidangSUPModel->updateJadwal($__data);
        }

        if ($post['prefixData'] == 'skripsi') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->JadwalSidangSkripsiModel->updateJadwal($__data);
        }

        return $this->response->setJson($resultData);
    }

    public function exportExlsSUP() {
        $lists = $this->JadwalSidangSUPModel->exportFileXlsAllData();
        $data = [];
        $no = $this->request->getPost('start');

        foreach ($lists as $list) {
            $_input_jadwal_id = $this->classesModel->encrypter($list->id);
            $getStatusFormSup = $this->JadwalSidangSUPModel->getById($this->classesModel->encrypter($list->formulir_sup_id));
            $getStatusKesimpulan = $this->JadwalSidangSUPModel->getStatusKesimpulan($_input_jadwal_id, $list->mahasiswa_id);

            $no++;
            $row = [];
            $row['id'] = $_input_jadwal_id;  
            $row['formulir_sup_id'] = $this->classesModel->encrypter($list->formulir_sup_id);

            if ($this->session->user_logged['rules'] == 2) {
                $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                $row['nim'] = $nim;

                $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSUPData'] = $dospemSUPData;
            } 
            
            if ($this->session->user_logged['rules'] == 3) {
                $res = $this->JadwalSidangSUPModel->getById($this->classesModel->encrypter($list->formulir_sup_id));

                $userData = $this->JadwalSidangSUPModel->getUserData($this->classesModel->encrypter($res['nim']));
                $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($res['nim']);
                $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                $row['nama'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['full_name'];
                $row['nim'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['nim'];
                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSUPData'] = $dospemSUPData;
            } 

            if ($this->session->user_logged['rules'] == 4) {
                $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                $row['nim'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSUPData'] = $dospemSUPData;
            } 

            if ($this->session->user_logged['rules'] == 5) {
                $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                $row['nim'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                $dospemUjiKelatakanData = $this->JadwalSidangSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                $dospemSUPData = $this->JadwalSidangSUPModel->getDosPembSUP($list->formulir_sup_id);

                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSUPData'] = $dospemSUPData;
            }

            $row['judul'] = $list->judul;
            $row['tempat'] = $list->tempat;
            $row['tanggal'] = date("d-m-Y", strtotime($list->tanggal));       
            $row['disp_hari_idn'] = $this->JadwalSidangModel->getDisplayHariIdn($list->tanggal);
            $row['waktu_mulai'] = date("H:i", strtotime($list->waktu_mulai));
            $row['waktu_akhir'] = date("H:i", strtotime($list->waktu_akhir));  
            $row['userRules'] = $this->session->user_logged['rules'];
            $row['keterangan'] = $list->keterangan;
            $row['status'] = (!empty($getStatusFormSup) ? $getStatusFormSup['status'] : '');
            $row['semester'] = (!empty($getStatusFormSup) ? $getStatusFormSup['semester'] : '');
            $row['status_kesimpulan'] = $getStatusKesimpulan;
            $data[] = $row;
        }

        $setData = [];
        if (!empty($getStatusFormSup)) {
            if ($getStatusFormSup['semester'] == $this->request->getPost('semester')) {
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

        $theData['data'] = $setData;
        return view("jadwal-sidang/component-view-jadwal-sidang-export-xls-sup", $theData);
    }

    public function exportExlsSkripsi() {
        $lists = $this->JadwalSidangSkripsiModel->exportFileXlsAllData();
        $data = [];
        $no = $this->request->getPost('start');

        foreach ($lists as $list) {
            $_ids = $this->classesModel->encrypter($list->id);
            $getStatusFormSkripsi = $this->JadwalSidangSkripsiModel->getById($this->classesModel->encrypter($list->formulir_skripsi_id));
            $getStatusKesimpulan = $this->JadwalSidangSkripsiModel->getStatusKesimpulan($_ids, $this->classesModel->encrypter($list->mahasiswa_id));

            $no++;
            $row = [];
            $row['id'] = $_ids;  
            $row['formulir_skripsi_id'] = $this->classesModel->encrypter($list->formulir_skripsi_id);

            if ($this->session->user_logged['rules'] == 2) {
                $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                $row['nim'] = $nim;

                $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSkripsiData'] = $dospemSkripsiData;
            } 
            
            if ($this->session->user_logged['rules'] == 3) {
                $res = $this->JadwalSidangSkripsiModel->getById($this->classesModel->encrypter($list->formulir_skripsi_id));

                $userData = $this->JadwalSidangSkripsiModel->getUserData($this->classesModel->encrypter($res['nim']));
                $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($res['nim']);
                $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                $row['nama'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['full_name'];
                $row['nim'] = $this->JadwalSidangModel->getUserDataById($userData['id'])['nim'];
                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSkripsiData'] = $dospemSkripsiData;
            } 

            if ($this->session->user_logged['rules'] == 4) {
                $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                $row['nim'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];

                $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSkripsiData'] = $dospemSkripsiData;
            } 

            if ($this->session->user_logged['rules'] == 5) {
                $nim = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['nim'];
                $row['nama'] = $this->JadwalSidangModel->getUserDataById($list->mahasiswa_id)['full_name'];
                $row['nim'] = $nim;

                $dospemUjiKelatakanData = $this->JadwalSidangSkripsiModel->getDosPembUjiKelayakanByNimStatusSelesai($nim);
                $dospemSkripsiData = $this->JadwalSidangSkripsiModel->getDosPembSkripsi($list->formulir_skripsi_id);

                $row['dospemUjiKelatakanData'] = $dospemUjiKelatakanData;
                $row['dospemSkripsiData'] = $dospemSkripsiData;
            }

            $row['judul'] = $list->judul;
            $row['tempat'] = $list->tempat;
            $row['tanggal'] = date("d-m-Y", strtotime($list->tanggal));       
            $row['disp_hari_idn'] = $this->JadwalSidangModel->getDisplayHariIdn($list->tanggal);
            $row['waktu_mulai'] = date("H:i", strtotime($list->waktu_mulai));
            $row['waktu_akhir'] = date("H:i", strtotime($list->waktu_akhir));  
            $row['userRules'] = $this->session->user_logged['rules'];
            $row['keterangan'] = $list->keterangan;
            $row['status'] = (!empty($getStatusFormSkripsi['status']) ? $getStatusFormSkripsi['status'] : '');
            $row['semester'] = (!empty($getStatusFormSkripsi['semester']) ? $getStatusFormSkripsi['semester'] : '');
            $row['status_kesimpulan'] = $getStatusKesimpulan;                
            $data[] = $row;
        }

        $setData = [];
        if (!empty($getStatusFormSkripsi['semester'])) {
            if ($getStatusFormSkripsi['semester'] == $this->request->getPost('semester')) {
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

        $theData['data'] = $setData;
        return view("jadwal-sidang/component-view-jadwal-sidang-export-xls-skripsi", $theData);
    }

}
