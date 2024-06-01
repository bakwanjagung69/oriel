<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\Profile\ProfileModel;
use App\Models\ClassesModel;
use Config\Services;

class Profile extends BaseController {
    protected $classesModel;
    protected $profileModel;
    protected $request;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->profileModel = new ProfileModel();
        $this->request = Services::request();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        $data['profileData'] = $this->profileModel->getDataProfileFromSessionData();
        return $this->template->Cms("admin/profile/component-view-profile", $data);
    }

    public function getDataById() {
        $post = $this->request->getVar();
        $data["data"] = $this->profileModel->getDataProfile($post['userId']);
        return $this->response->setJson($data['data']);
    }

    public function updateData() {
      $__data = array(
        "items" => $this->request->getVar(),
        "files" => $_FILES
      );
      $resultData = $this->profileModel->UpdateData($__data);
      return $this->response->setJson($resultData);
    }

    public function changePassword() {
      $resultData = $this->profileModel->changePassword($this->request->getVar());
      return $this->response->setJson($resultData);
    }

}
