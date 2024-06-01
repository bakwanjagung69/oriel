<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ListPendaftaran\ListPendaftaranModel;
use App\Models\ListPendaftaran\ListPendaftaranUjiKelayakanModel;
use App\Models\ListPendaftaran\ListPendaftaranSUPModel;
use App\Models\ListPendaftaran\ListPendaftaranSkripsiModel;
use App\Models\ClassesModel;
use Config\Services;

class ListPendaftaran extends BaseController {
    protected $classesModel;
    protected $ListPendaftaranModel;
    protected $JadwalSidangUjiKelayakanModel;
    protected $ListPendaftaranSUPModel;
    protected $ListPendaftaranSkripsiModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->ListPendaftaranModel = new ListPendaftaranModel();
        $this->JadwalSidangUjiKelayakanModel = new ListPendaftaranUjiKelayakanModel();
        $this->ListPendaftaranSUPModel = new ListPendaftaranSUPModel();
        $this->ListPendaftaranSkripsiModel = new ListPendaftaranSkripsiModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("list-pendaftaran/component-view-list-pendaftaran", $data);
    }

    public function getdataUjiKelayakan() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->JadwalSidangUjiKelayakanModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $userRules = $this->session->user_logged['rules'];

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['files'] = $this->classesModel->encrypter('/assets/upload/uji-kelayakan/'.$list->files);
                $row['nama'] = $list->nama;
                $row['nim'] = $list->nim;
                $row['judul'] = $list->judul;
                $row['status'] = $list->status;
                $row['tanggal_pembuatan'] = date("d M Y", strtotime($list->createDate));         
                $row['userRules'] = $userRules;    
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->JadwalSidangUjiKelayakanModel->countAll(),
                'recordsFiltered' => $this->JadwalSidangUjiKelayakanModel->countFiltered(),
                'data' => $data
            ];
        }
        return $this->response->setJson($output);
    }

    public function getdataSUP() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->ListPendaftaranSUPModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $userRules = $this->session->user_logged['rules'];

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['proposal_files'] = $this->classesModel->encrypter('/assets/upload/sup/'.$list->proposal_files);
                $row['lembar_tugas_or_konsultasi_files'] = $this->classesModel->encrypter('/assets/upload/sup/'.$list->lembar_tugas_or_konsultasi_files);
                $row['nama'] = $list->nama;
                $row['nim'] = $list->nim;
                $row['judul'] = $list->judul;
                $row['status'] = $list->status;
                $row['tanggal_pembuatan'] = date("d M Y", strtotime($list->createDate));         
                $row['userRules'] = $userRules;               
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->ListPendaftaranSUPModel->countAll(),
                'recordsFiltered' => $this->ListPendaftaranSUPModel->countFiltered(),
                'data' => $data
            ];
        }
        return $this->response->setJson($output);
    }

    public function getdataSkripsi() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->ListPendaftaranSkripsiModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $userRules = $this->session->user_logged['rules'];

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['skripsi_files'] = $this->classesModel->encrypter('/assets/upload/skripsi/'.$list->skripsi_files);
                $row['lembar_tugas_or_konsultasi_files'] = $this->classesModel->encrypter('/assets/upload/skripsi/'.$list->lembar_tugas_or_konsultasi_files);
                $row['nama'] = $list->nama;
                $row['nim'] = $list->nim;
                $row['judul'] = $list->judul;             
                $row['status'] = $list->status;
                $row['tanggal_pembuatan'] = date("d M Y", strtotime($list->createDate));         
                $row['userRules'] = $userRules;     
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->ListPendaftaranSkripsiModel->countAll(),
                'recordsFiltered' => $this->ListPendaftaranSkripsiModel->countFiltered(),
                'data' => $data
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

                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;

                $arrSet = array_replace($__data, array(
                    'uji_kelayakan_id' => $this->classesModel->encrypter($__data['id']),
                    'kaprodi_id' => $this->classesModel->encrypter($userId),
                    'files' => $this->classesModel->encrypter('assets/upload/uji-kelayakan/'.$__data['files']),
                    'files_name' => $__data['files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'prefix_data' => 'uji_kelayakan',
                    'status' => $_GET['status']
                ));

                $data['data'] = $arrSet;
                $pathFile = "list-pendaftaran/component-view-list-pendaftaran-uji-kelayakan-details";
            }

            if ($_GET['type'] == 'sup') {
                $__data = $this->ListPendaftaranSUPModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];
                $dosenPembimbingUjiKelayakan = $this->ListPendaftaranSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($__data['nim']);

                $arrSet = array_replace($__data, array(
                    'sup_id' => $this->classesModel->encrypter($__data['id']),
                    'kaprodi_id' => $this->classesModel->encrypter($userId),
                    'proposal_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['proposal_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'proposal_files_name' => $__data['proposal_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'prefix_data' => 'sup',
                    'dosenData' => $dosenPembimbingUjiKelayakan
                ));

                $data['data'] = $arrSet;
                $pathFile = "list-pendaftaran/component-view-list-pendaftaran-sup-details";
            }

            if ($_GET['type'] == 'skripsi') {
                $__data = $this->ListPendaftaranSkripsiModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];
                $dosenPembimbingUjiKelayakan = $this->ListPendaftaranSUPModel->getDosPembUjiKelayakanByNimStatusSelesai($__data['nim']);

                $arrSet = array_replace($__data, array(
                    'skripsi_id' => $this->classesModel->encrypter($__data['id']),
                    'kaprodi_id' => $this->classesModel->encrypter($userId),
                    'skripsi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['skripsi_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'skripsi_files_name' => $__data['skripsi_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'prefix_data' => 'skripsi',
                    'dosenData' => $dosenPembimbingUjiKelayakan
                ));

                $data['data'] = $arrSet;
                $pathFile = "list-pendaftaran/component-view-list-pendaftaran-skripsi-details";
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
                $row['nama_dosen'] = $this->ListPendaftaranModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        if ($_GET['type'] == 'sup') {
            $result = $this->ListPendaftaranSUPModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_sup');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_sup_id'] = $this->classesModel->encrypter($item->formulir_sup_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->ListPendaftaranModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        if ($_GET['type'] == 'skripsi') {
            $result = $this->ListPendaftaranSkripsiModel->getPenugasanDosenPenguji($_GET['formulirId'], 'penugasan_dosen_penguji_skripsi');
            foreach ($result as $item) {
                $row = [];

                $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
                $row['formulir_skripsi_id'] = $this->classesModel->encrypter($item->formulir_skripsi_id);
                $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
                $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
                $row['nama_dosen'] = $this->ListPendaftaranModel->getUserDataById($item->dosen_id)['full_name'];  
                $row['dosen_images'] = array(
                    'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($item->dosen_id)['images']),
                    'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->ListPendaftaranModel->getUserDataById($item->dosen_id)['thumbnail_images'])
                );
                $row['type_penugasan'] = $item->type_penugasan;
                $row['rules'] = $rules;

                $data[] = $row;
            }
        }

        return $this->response->setJson($data);
    }

    public function dosenList() {
        $result = $this->ListPendaftaranModel->getAllDosenListData();

        $data = [];
        foreach ($result as $item) {
            $row = [];

            $row['id'] = $this->classesModel->encrypter($item->id);
            $row['full_name'] = $item->full_name;

            $data[] = $row;
        }

        return $this->response->setJson($data);
    }

    public function addPenugasanDosenPenguji() {
        $post = $this->request->getVar();
        $resultData = '';


        if ($post['prefixData'] == 'uji_kelayakan') {
            $arrPost = json_decode($post['data']);

            $__data = array(
                "items" => $arrPost,
                "files" => $_FILES,
                "uji_kelayakan_id" => $post['ujiKelayakanId']
            );

            $resultData = $this->JadwalSidangUjiKelayakanModel->AddNewDataPenugasanDosenPenguji($__data);
        }

        if ($post['prefixData'] == 'sup') {
            $arrPost = json_decode($post['data']);

            $__data = array(
                "items" => $arrPost,
                "files" => $_FILES,
                "formulir_sup" => $post['supId']
            );

            $resultData = $this->ListPendaftaranSUPModel->AddNewDataPenugasanDosenPenguji($__data);
        }

        if ($post['prefixData'] == 'skripsi') {
            $arrPost = json_decode($post['data']);

            $__data = array(
                "items" => $arrPost,
                "files" => $_FILES,
                "formulir_skripsi_id" => $post['skripsiId']
            );

            $resultData = $this->ListPendaftaranSkripsiModel->AddNewDataPenugasanDosenPenguji($__data);
        }

        return $this->response->setJson($resultData);
    }

    public function DeletePenugasanDosenPenguji() {
        $del = $this->request->getVar();

        $resultData = '';
        if ($_GET['type'] == 'uji_kelayakan') {
            $__data = array(
                'items' => array(
                    'id' => $_GET['q']
                )
            );
          
            $resultData = $this->JadwalSidangUjiKelayakanModel->DeletePenugasanDosenPenguji($__data);
        }

        if ($_GET['type'] == 'sup') {
            $__data = array(
                'items' => array(
                    'id' => $_GET['q']
                )
            );
          
            $resultData = $this->ListPendaftaranSUPModel->DeletePenugasanDosenPenguji($__data);
        }

        if ($_GET['type'] == 'skripsi') {
            $__data = array(
                'items' => array(
                    'id' => $_GET['q']
                )
            );
          
            $resultData = $this->ListPendaftaranSkripsiModel->DeletePenugasanDosenPenguji($__data);
        }


        return $this->response->setJson($resultData);
    }

    public function addSuratTugas() {
        $post = $this->request->getVar();
        $resultData = '';

        if ($_GET['type'] == 'uji_kelayakan') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );
            $resultData = $this->JadwalSidangUjiKelayakanModel->addSuratTugas($__data);
        }

        return $this->response->setJson($resultData);
    }

}
