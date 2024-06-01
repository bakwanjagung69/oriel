<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ChangePassword\ChangePasswordModel;
use App\Models\ClassesModel;
use Config\Services;

class ChangePassword extends BaseController {
    protected $classesModel;
    protected $changePassword;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->changePassword = new ChangePasswordModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        $userId = $this->classesModel->encrypter($this->session->user_logged['id']);
        $data['userId'] = $userId;
        return $this->template->Frontend("change-password/component-view-change-password", $data);
    }

    public function update() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->changePassword->updatePassword($__data);
        return $this->response->setJson($resultData);
    }

}
