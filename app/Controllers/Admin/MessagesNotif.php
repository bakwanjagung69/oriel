<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\MessagesNotif\MessagesNotifModel;
use App\Models\ClassesModel;
use Config\Services;

class MessagesNotif extends BaseController {
    protected $classesModel;
    protected $MessagesNotifModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->MessagesNotifModel = new MessagesNotifModel();
        $this->request = Services::request();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        return view('404/component-view-404');
    }

    public function getNotif() {
        $lastIdx = ($this->request->getGet()['last_idx']);
        $sorting = ($this->request->getGet()['sort']);
        $result  = $this->MessagesNotifModel->getLoadData(5, $lastIdx, $sorting);

        return $this->response->setJson($result);
    }
}
