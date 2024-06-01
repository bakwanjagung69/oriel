<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\InputNamaDosenPembimbing\InputNamaDosenPembimbingModel;
use App\Models\ClassesModel;
use Config\Services;

class InputNamaDosenPembimbing extends BaseController {
    protected $classesModel;
    protected $inputNamaDosenPembimbing;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->inputNamaDosenPembimbing = new InputNamaDosenPembimbingModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }


    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("input-nama-dosen-pembimbing/component-view-input-nama-dosen-pembimbing", $data);
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->inputNamaDosenPembimbing->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $userRules = $this->session->user_logged['rules'];

                $no++;
                $row = [];
                $row['id'] = $_ids;
                $row['nama'] = $list->nama;
                $row['nim'] = $list->nim;
                $row['judul'] = $list->judul;
                $row['semester'] = $list->semester;
                $row['files'] = $this->classesModel->encrypter('/assets/upload/users/'.$list->files);
                $row['status'] = $list->status;
                $row['updateDate'] = date("d M Y", strtotime($list->updateDate));
                $row['userRules'] = $userRules;
          
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->inputNamaDosenPembimbing->countAll(),
                'recordsFiltered' => $this->inputNamaDosenPembimbing->countFiltered(),
                'data' => $data
            ];
        }
        return $this->response->setJson($output);
    }

    public function form() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        $data['mhsId'] = $this->classesModel->encrypter($this->inputNamaDosenPembimbing->getUserDataByNim($_GET['mahasiswaNim'])['id']);
        $data['mhsNim'] = $_GET['mahasiswaNim'];
        $data['mhsName'] = $_GET['mahasiswaName'];
        $data['mhsImages'] = $this->classesModel->encrypter('/assets/upload/users/'. $this->inputNamaDosenPembimbing->getUserDataByNim($_GET['mahasiswaNim'])['images']);
        $data['mhsImagesName'] = $this->inputNamaDosenPembimbing->getUserDataByNim($_GET['mahasiswaNim'])['images'];

        $data['ujiKelayakanJudulId'] = $this->classesModel->encrypter($this->classesModel->decrypter($_GET['ujiKelayakanId']));
        $data['ujiKelayakanFiles'] = $this->classesModel->encrypter('/assets/upload/uji-kelayakan/'. $this->inputNamaDosenPembimbing->getDataFormUjiKelayakanByNim($_GET['mahasiswaNim'])['files']);
        $data['ujiKelayakanFilesName'] = $this->inputNamaDosenPembimbing->getDataFormUjiKelayakanByNim($_GET['mahasiswaNim'])['files'];

        $data['kaprodiId'] = $this->classesModel->encrypter($this->inputNamaDosenPembimbing->getKaprodiId());
        $data['judul'] = $_GET['judulProposal'];
        $data['status'] = $_GET['status'];        

        return $this->template->Frontend("input-nama-dosen-pembimbing/component-view-input-nama-dosen-pembimbing-form", $data);
    }

    public function dosenList() {
        $result = $this->inputNamaDosenPembimbing->getAllDosenListData();

        $data = [];
        foreach ($result as $item) {
            $row = [];

            $row['id'] = $this->classesModel->encrypter($item->id);
            $row['full_name'] = $item->full_name;

            $data[] = $row;
        }

        return $this->response->setJson($data);
    }

    public function getDataPenugasanDosenPembimbing() {
        $userId = $this->session->user_logged['id'];
        $rules  = $this->session->user_logged['rules'];
        $data = [];

        $result = $this->inputNamaDosenPembimbing->getPenugasanDosenPembimbing($_GET['formulirId'], 'penugasan_dosen_pembimbing_uji_kelayakan_judul');
        foreach ($result as $item) {
            $row = [];
            $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
            $row['formulir_uji_kelayakan_id'] = $this->classesModel->encrypter($item->formulir_uji_kelayakan_id);
            $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
            $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
            $row['nama_dosen'] = $this->inputNamaDosenPembimbing->getUserData($this->classesModel->encrypter($item->dosen_id))['full_name'];  
            $row['dosen_images'] = array(
                'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->inputNamaDosenPembimbing->getUserData($this->classesModel->encrypter($item->dosen_id))['images']),
                'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->inputNamaDosenPembimbing->getUserData($this->classesModel->encrypter($item->dosen_id))['thumbnail_images'])
            );
            $row['type_penugasan'] = $item->type_penugasan;
            $row['rules'] = $rules;

            $data[] = $row;
        }

        return $this->response->setJson($data);

    }

    public function addPenugasanDosenPembimbing() {
        $post = $this->request->getVar();
        $arrPost = json_decode($post['data']);

        $__data = array(
            "items" => $arrPost,
            "mahasiswa_id" => $this->classesModel->encrypter($this->classesModel->decrypter($post['mahasiswa_id'])),
            "uji_kelayakan_judul_id" => $this->classesModel->encrypter($this->classesModel->decrypter($post['uji_kelayakan_judul_id'])),
            "files" => $_FILES
        );

        $resultData = $this->inputNamaDosenPembimbing->AddNewDataPenugasanDosenPembimbing($__data);

        return $this->response->setJson($resultData);
    }

    public function DeletePenugasanDosenPembimbing() {
        $del = $this->request->getVar();

        $__data = array(
            'items' => array(
                'id' => $_GET['q']
            )
        );
      
        $resultData = $this->inputNamaDosenPembimbing->DeletePenugasanDosenPembimbing($__data);

        return $this->response->setJson($resultData);
    }

}
