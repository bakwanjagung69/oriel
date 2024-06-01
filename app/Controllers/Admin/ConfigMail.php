<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\ConfigMail\ConfigMailModel;
use App\Models\ClassesModel;
use Config\Services;

class ConfigMail extends BaseController {
    protected $classesModel;
    protected $configMailModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->configMailModel = new ConfigMailModel();
        $this->request = Services::request();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        return $this->template->Cms("admin/config-mail/component-view-config-mail");
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->configMailModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $value) {
                $no++;
                $row = array();         
                $row['id'] = $this->classesModel->encrypter($value->id);  
                $row['main_email'] = $value->main_email; 
                $row['email_name'] = $value->email_name;
                $row['logo'] = $this->classesModel->encrypter('/assets/upload/config-email/'.$value->logo);
                $row['thumbnail_logo'] = $this->classesModel->encrypter('/assets/upload/config-email/'.$value->thumbnail_logo);
                $row['social_media'] = $value->social_media;           
                $row['subject_email'] = $value->subject_email;         
                $row['body_email_to'] = $value->body_email_to;        
                $row['email_received'] = $value->email_received;             
                $row['body_email_received'] = $value->body_email_received;                             
                $row['email_cc'] = $value->email_cc;                                                     
                $row['reply_to_email'] = $value->reply_to_email;
                $row['reply_to_email_name'] = $value->reply_to_email_name;            
                $row['mail_type'] = $value->mail_type;                                                     
                $row['protocol'] = $value->protocol;                                                     
                $row['host'] = $value->host;                                                     
                $row['username'] = $value->username; 
                $row['password'] = $value->password;
                $row['port'] = $value->port;                                          
                $row['charset'] = $value->charset;                                          
                $row['timeout'] = $value->timeout;                                          
                $row['validation'] = $value->validation;                                          
                $row['wordwrap'] = $value->wordwrap;    
                $row['status'] = $value->status;                                          

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->configMailModel->countAll(),
                'recordsFiltered' => $this->configMailModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
        exit();
    }

    public function form($id = '') {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if (isset($_GET['q'])) {
            $data['data'] = array(
                'id' => $_GET['q'],
                'icon' => $this->classesModel->getIcon()
            );
        } else {
            $data["data"] = array(
                'id' => '',
                'icon' => $this->classesModel->getIcon()
            );
        }
        return $this->template->Cms("admin/config-mail/component-view-config-mail-form", $data);
    }

    public function getDataById() {
        $post = $this->request->getVar();
        $__data = $this->configMailModel->getById($post['id']);

        $arrSet = array_replace($__data, array(
            'id' => $this->classesModel->encrypter($__data['id']),
            'logo' => $this->classesModel->encrypter('/assets/upload/config-email/'.$__data['logo']),
            'thumbnail_logo' => $this->classesModel->encrypter('/assets/upload/config-email/'.$__data['thumbnail_logo'])
        ));

        $data['data'] = $arrSet;

        echo json_encode($data['data']);
    }

    public function addNewData() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->configMailModel->AddNew($__data);
        echo(json_encode($resultData));
        exit();
    }

    public function updateData() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->configMailModel->UpdateData($__data);
        echo(json_encode($resultData));
        exit();
    }

    public function Delete() {
        $del = $this->request->getVar();

        $__data = array(
            'items' => array(
                'id' => $_GET['q']
            )
        );
      
        $resultData = $this->configMailModel->DeleteData($__data);
        echo(json_encode($resultData));
        exit();
    }

}
