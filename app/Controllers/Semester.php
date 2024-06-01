<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Semester\SemesterModel;
use App\Models\ClassesModel;
use Config\Services;

class Semester extends BaseController {
    protected $classesModel;
    protected $semesterModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->semesterModel = new SemesterModel();
        $this->request = Services::request();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        return $this->template->Frontend("semester/component-view-semester");
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->semesterModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['angkatan'] = $list->angkatan;
                $row['dari_tahun'] = $list->dari_tahun;
                $row['sampai_tahun'] = $list->sampai_tahun;
                $row['semester'] = $list->semester;
                $row['status'] = $list->status;              
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->semesterModel->countAll(),
                'recordsFiltered' => $this->semesterModel->countFiltered(),
                'data' => $data
            ];
        }
        return $this->response->setJson($output);
    }

    public function form($id = '') {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if (isset($_GET['q'])) {
            $data['data'] = array('id' => $_GET['q']);
        } else {
            $data["data"] = array('id' => '');
        }
        return $this->template->Frontend("semester/component-view-semester-form", $data);
    }

    public function getDataById() {
        $post = $this->request->getVar();
        $__data = $this->semesterModel->getById($post['id']);

        $arrSet = array_replace($__data, array(
            'id' => $this->classesModel->encrypter($__data['id'])
        ));

        $data['data'] = $arrSet;

        return $this->response->setJson($data['data']);
    }

    public function addNewData() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->semesterModel->AddNew($__data);
        return $this->response->setJson($resultData);
    }

    public function updateData() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        if ($post['angkatan'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Angkatan cannot be empty!'));
        }

        if ($post['dari_tahun'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Dari tahun cannot be empty!'));
        }

        if ($post['sampai_tahun'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Sampai tahun cannot be empty!'));
        }

        if ($post['semester'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Semester cannot be empty!'));
        }

        if ($post['status'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Status cannot be empty!'));
        }

        $resultData = $this->semesterModel->UpdateData($__data);
        return $this->response->setJson($resultData);
    }

    public function Delete() {
        $del = $this->request->getVar();

        $__data = array(
            'items' => array(
                'id' => $_GET['q']
            )
        );
      
        $resultData = $this->semesterModel->DeleteData($__data);
        return $this->response->setJson($resultData);
    }

}
