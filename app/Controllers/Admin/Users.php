<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\Users\UsersModel;
use App\Models\ClassesModel;
use Config\Services;

class Users extends BaseController {
    protected $classesModel;
    protected $usersModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->usersModel = new UsersModel();
        $this->request = Services::request();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        return $this->template->Cms("admin/users/component-view-users");
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->usersModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);

                $no++;
                $row = [];
                $row['id'] = $_ids;  
                $row['images'] = $this->classesModel->encrypter('/assets/upload/users/'.$list->images);
                $row['thumbnail_images'] = $this->classesModel->encrypter('/assets/upload/users/'.$list->thumbnail_images);
                $row['full_name'] = $list->full_name;
                $row['username'] = $list->username;
                $row['email'] = $list->email;                                
                $row['password'] = $list->password; 
                $row['is_online'] = $list->is_online;   
                $row['status'] = $list->status;            
                $row['rules'] = $list->rules;                 
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->usersModel->countAll(),
                'recordsFiltered' => $this->usersModel->countFiltered(),
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
        return $this->template->Cms("admin/users/component-view-users-form", $data);
    }

    public function getDataById() {
        $post = $this->request->getVar();
        $__data = $this->usersModel->getById($post['id']);

        $arrSet = array_replace($__data, array(
            'id' => $this->classesModel->encrypter($__data['id']),
            'images' => $this->classesModel->encrypter('/assets/upload/users/'.$__data['images']),
            'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$__data['thumbnail_images'])
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

        $resultData = $this->usersModel->AddNew($__data);
        return $this->response->setJson($resultData);
    }

    public function updateData() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        if ($post['full_name'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Full Name cannot be empty!'));
        }

        if ($post['username'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Username cannot be empty!'));
        }

        if ($post['email'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Email cannot be empty!'));
        }

        if ($post['status'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Status cannot be empty!'));
        }

        if ($post['rules'] == '') {
          return $this->response->setJson(array("code" => 405, "response" => 'Rules cannot be empty!'));
        }

        if (!isset($_FILES['images']['name'])) {
          return $this->response->setJson(array("code" => 405, "response" => 'Picture cannot be empty!'));
        }

        $resultData = $this->usersModel->UpdateData($__data);
        return $this->response->setJson($resultData);
    }

    public function Delete() {
        $del = $this->request->getVar();

        $__data = array(
            'items' => array(
                'id' => $_GET['q']
            )
        );
      
        $resultData = $this->usersModel->DeleteData($__data);
        return $this->response->setJson($resultData);
    }

}
