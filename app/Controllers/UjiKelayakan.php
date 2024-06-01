<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UjiKelayakan\UjiKelayakanModel;
use App\Models\ClassesModel;
use Config\Services;

class UjiKelayakan extends BaseController {
    protected $classesModel;
    protected $ujiKelayakanModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->ujiKelayakanModel = new UjiKelayakanModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();

        $userId   = $this->session->user_logged['id'];
        $userData = $this->ujiKelayakanModel->getUserDataById($userId);
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        $data['data'] = array(
            'nama' => $userData['full_name'],
            'nim' => $userData['nim']
        );

        return $this->template->Frontend("uji-kelayakan/component-view-uji-kelayakan-form", $data);
    }

    public function form($id = '') {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if (isset($_GET['q'])) {
            $data['data'] = array('id' => $_GET['q']);
        } else {
            $data["data"] = array('id' => '');
        }
        return $this->template->Frontend("uji-kelayakan/component-view-uji-kelayakan-form", $data);
    }

    public function addNewData() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->ujiKelayakanModel->AddNew($__data);
        return $this->response->setJson($resultData);
    }

}
