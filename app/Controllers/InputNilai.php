<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\InputNilai\InputNilaiModel;
use App\Models\InputNilai\InputNilaiSupModel;
use App\Models\InputNilai\InputNilaiSkripsiModel;
use App\Models\ClassesModel;
use Config\Services;

class InputNilai extends BaseController {
    protected $classesModel;
    protected $InputNilaiModel;
    protected $InputNilaiSUPModel;
    protected $InputNilaiSkripsiModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->InputNilaiModel = new InputNilaiModel();
        $this->InputNilaiSUPModel = new InputNilaiSupModel();
        $this->InputNilaiSkripsiModel = new InputNilaiSkripsiModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("input-nilai/component-view-input-nilai", $data);
    }

    public function getdataSUP() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->InputNilaiSUPModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $formulirSupData = $this->InputNilaiSUPModel->getById($this->classesModel->encrypter($list->formulir_sup_id));

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['formulir_sup_id'] = $this->classesModel->encrypter($list->formulir_sup_id);
                $row['dosen_id'] = $this->classesModel->encrypter($list->dosen_id);

                $mhsId = $this->InputNilaiSUPModel->getMahasiswaId($list->formulir_sup_id);
                $row['mahasiswa_id'] = $this->classesModel->encrypter($mhsId);
                $row['nama'] = $this->InputNilaiModel->getUserDataById($mhsId)['full_name'];
                $row['nim'] =  $this->InputNilaiModel->getUserDataById($mhsId)['nim'];

                $row['judul'] = $list->judul;
                $row['tempat'] = $list->tempat;
                $row['tanggal'] = date("d-m-Y", strtotime($list->tanggal));       
                $row['disp_hari_idn'] = $this->InputNilaiModel->getDisplayHariIdn($list->tanggal);
                $row['waktu_mulai'] = date("H:i", strtotime($list->waktu_mulai));
                $row['waktu_akhir'] = date("H:i", strtotime($list->waktu_akhir));  
                $row['status'] = $list->status;
                $row['semester'] = (!empty($formulirSupData) ? $formulirSupData['semester'] : '');
                $row['userRules'] = $this->session->user_logged['rules'];         
                $data[] = $row;
            }

            $setData = [];
            if (!empty($formulirSupData)) {
                if ($formulirSupData['semester'] == $this->request->getPost('semester')) {
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
                'recordsTotal' => (!empty($setData) ? $this->InputNilaiSUPModel->countAll() : ''),
                'recordsFiltered' => (!empty($setData) ? $this->InputNilaiSUPModel->countFiltered() : ''),
                'data' => $setData
            ];
        }
        return $this->response->setJson($output);
    }

    public function getdataSkripsi() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->InputNilaiSkripsiModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $formulirSkripsiData = $this->InputNilaiSkripsiModel->getById($this->classesModel->encrypter($list->formulir_skripsi_id));

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['formulir_skripsi_id'] = $this->classesModel->encrypter($list->formulir_skripsi_id);
                $row['dosen_id'] = $this->classesModel->encrypter($list->dosen_id);

                $mhsId = $this->InputNilaiSkripsiModel->getMahasiswaId($list->formulir_skripsi_id);
                $row['mahasiswa_id'] = $this->classesModel->encrypter($mhsId);
                $row['nama'] = $this->InputNilaiModel->getUserDataById($mhsId)['full_name'];
                $row['nim'] =  $this->InputNilaiModel->getUserDataById($mhsId)['nim'];

                $row['judul'] = $list->judul;
                $row['tempat'] = $list->tempat;
                $row['tanggal'] = date("d-m-Y", strtotime($list->tanggal));       
                $row['disp_hari_idn'] = $this->InputNilaiModel->getDisplayHariIdn($list->tanggal);
                $row['waktu_mulai'] = date("H:i", strtotime($list->waktu_mulai));
                $row['waktu_akhir'] = date("H:i", strtotime($list->waktu_akhir));  
                $row['status'] = $list->status;   
                $row['semester'] = (!empty($formulirSkripsiData) ? $formulirSkripsiData['semester'] : '');
                $row['userRules'] = $this->session->user_logged['rules'];           
                $data[] = $row;
            }

            $setData = [];
            if (!empty($formulirSkripsiData)) {
                if ($formulirSkripsiData['semester'] == $this->request->getPost('semester')) {
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
                'recordsTotal' => (!empty($setData) ? $this->InputNilaiSkripsiModel->countAll() : ''),
                'recordsFiltered' => (!empty($setData) ? $this->InputNilaiSkripsiModel->countFiltered() : ''),
                'data' => $setData
            ];
        }
        return $this->response->setJson($output);
    }

    public function form($id = '') {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
        $pathFile = '';

        if (isset($_GET['q'])) {
            if ($_GET['type'] == 'sup') {
                $__data = $this->InputNilaiSUPModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];

                $getDataJadwal = $this->InputNilaiSUPModel->getJadwalSUP($__data['id']);
                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;

                $arrSet = array_replace($__data, array(
                    'formulir_sup_id' => $this->classesModel->encrypter($__data['id']),
                    'dosen_id' => $this->classesModel->encrypter($userId),
                    'proposal_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['proposal_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/sup/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'proposal_files_name' => $__data['proposal_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->InputNilaiModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->InputNilaiModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'mahasiswa_id' => $this->classesModel->encrypter($this->InputNilaiModel->getUserDataByNim($__data['nim'])['id']),
                    'prefix_data' => 'sup',
                    'judul' => $getDataJadwal['judul'],
                    'tempat' => $getDataJadwal['tempat'],
                    'tanggal' => date("d-m-Y", strtotime($getDataJadwal['tanggal'])),
                    'waktu_mulai' => date("H:i", strtotime($getDataJadwal['waktu_mulai'])),
                    'waktu_akhir' => date("H:i", strtotime($getDataJadwal['waktu_akhir'])),
                    'status' => $__data['status'],
                    'semester' => $__data['semester'],
                    'input_nilai_id' => $_GET['inputNilaiId']
                ));

                $data['data'] = $arrSet;
                $pathFile = "input-nilai/component-view-input-nilai-sup-form";
            }

            if ($_GET['type'] == 'skripsi') {
                $__data = $this->InputNilaiSkripsiModel->getById($_GET['q']);
                $userId = $this->session->user_logged['id'];

                $getDataJadwal = $this->InputNilaiSkripsiModel->getJadwalSkripsi($__data['id']);
                $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
                $data['master_semester'] = $getDataMasterSemester;

                $arrSet = array_replace($__data, array(
                    'formulir_skripsi_id' => $this->classesModel->encrypter($__data['id']),
                    'dosen_id' => $this->classesModel->encrypter($userId),
                    'skripsi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['skripsi_files']),
                    'lembar_tugas_or_konsultasi_files' => $this->classesModel->encrypter('assets/upload/skripsi/'.$__data['lembar_tugas_or_konsultasi_files']),
                    'skripsi_files_name' => $__data['skripsi_files'],
                    'lembar_tugas_or_konsultasi_files_name' => $__data['lembar_tugas_or_konsultasi_files'],
                    'user_images' => array(
                       'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->InputNilaiModel->getUserDataByNim($__data['nim'])['images']),
                       'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->InputNilaiModel->getUserDataByNim($__data['nim'])['thumbnail_images'])
                    ),
                    'mahasiswa_id' => $this->classesModel->encrypter($this->InputNilaiModel->getUserDataByNim($__data['nim'])['id']),
                    'prefix_data' => 'skripsi',
                    'judul' => $getDataJadwal['judul'],
                    'tempat' => $getDataJadwal['tempat'],
                    'tanggal' => date("d-m-Y", strtotime($getDataJadwal['tanggal'])),
                    'waktu_mulai' => date("H:i", strtotime($getDataJadwal['waktu_mulai'])),
                    'waktu_akhir' => date("H:i", strtotime($getDataJadwal['waktu_akhir'])),
                    'status' => $__data['status'],
                    'semester' => $__data['semester'],
                    'input_nilai_id' => $_GET['inputNilaiId']
                ));

                $data['data'] = $arrSet;
                $pathFile = "input-nilai/component-view-input-nilai-skripsi-form";
            }

        } else {
            $data["data"] = array('id' => '');
        }
        return $this->template->Frontend($pathFile, $data);
    }


    public function addNilai() {
        $post = $this->request->getVar();
        $resultData = '';

        if ($post['prefixData'] == 'sup') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->InputNilaiSUPModel->AddNewDataIsiNilai($__data);
        }

        if ($post['prefixData'] == 'skripsi') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->InputNilaiSkripsiModel->AddNewDataIsiNilai($__data);
        }

        return $this->response->setJson($resultData);
    }

    public function upudateNilai() {
        $post = $this->request->getVar();
        $resultData = '';

        if ($post['prefixData'] == 'sup') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->InputNilaiSUPModel->updateNilaiSUP($__data);
        }

        if ($post['prefixData'] == 'skripsi') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->InputNilaiSkripsiModel->updateNilaiSkripsi($__data);
        }

        return $this->response->setJson($resultData);
    }

     public function getDataNilai() {
        $post = $this->request->getVar();
        $resultData = '';

        if ($post['prefixData'] == 'sup') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->InputNilaiSUPModel->getDataNilaiSUP($__data);
        }

        if ($post['prefixData'] == 'skripsi') {
            $__data = array(
                "items" => $post,
                "files" => $_FILES
            );

            $resultData = $this->InputNilaiSkripsiModel->getDataNilaiSkripsi($__data);
        }

        return $this->response->setJson($resultData);
    }

}
