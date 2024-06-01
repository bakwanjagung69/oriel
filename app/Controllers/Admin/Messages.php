<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\Messages\MessagesModel;
use App\Models\ClassesModel;
use Config\Services;

class Messages extends BaseController {
    protected $classesModel;
    protected $messagesModel;
    protected $request;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->messagesModel = new MessagesModel();
        $this->request = Services::request();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
    $email = \Config\Services::email();

        // $data['uri'] = $this->request->uri->getSegments();
        return $this->template->Cms("admin/messages/component-view-messages");
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->messagesModel->getDatatables($_GET['q']);
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $value) {
                $no++;
                $row = array();         
                $row['id'] = $value->id;  
                $row['uuid'] = $value->uuid;
                $row['name'] = $value->name;
                $row['email'] = $value->email;
                $row['subject'] = $value->subject;
                $row['message'] = $value->message;
                $row['ip_address'] = $value->ip_address;      
                $row['reading_status'] = $value->reading_status;          
                $row['user_agent'] = $value->user_agent;
                $row['browser_name'] = $value->browser_name;         
                $row['sendBy'] = $value->sendBy;                                                    
                $row['sendDate'] = date('d M Y - H:i',strtotime($value->sendDate));                                                    
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->messagesModel->countAll(),
                'recordsFiltered' => $this->messagesModel->countFiltered($_GET['q']),
                'data' => $data
            ];

            echo json_encode($output);
        }
        exit();
    }

    public function compose($uuid = '') {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if (isset($uuid)) {
            $data['data'] = array('uuid' => $uuid);
        } else {
            $data["data"] = array('uuid' => '');
        }
        return $this->template->Cms("admin/messages/component-view-messages-form", $data);
    }

    public function getDataByUuid() {
        $post = $this->request->getVar();
        $data["data"] = $this->messagesModel->getById($post['uuid']);
        echo json_encode($data['data']);
    }

    public function composeMail() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => ''
        );

        $resultData = $this->messagesModel->ComposeMail($__data);
        echo(json_encode($resultData));
        exit();
    }

    public function ReadMail($uuid = NULL) {
      $data["data"] = $this->messagesModel->readMail($uuid);
      return $this->template->Cms("admin/messages/component-view-messages-read-mail", $data);
    }

    public function Reply($uuid = '') {
        $resultData = $this->messagesModel->getDataSenderMail($uuid);
        $data["data"] = $resultData;
        return $this->template->Cms("admin/messages/component-view-messages-form", $data);
    }

    public function SentReplyMail() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post,
            "files" => ''
        );

        $resultData = $this->messagesModel->SendReplyEmail($__data);
        echo(json_encode($resultData));
        exit();
    }

    public function Delete() {
        $post = $this->request->getVar();
        $__data = array(
            "items" => $post
        );
      
        $resultData = $this->messagesModel->DeleteData($__data);
        echo(json_encode($resultData));
        exit();
    }

}
