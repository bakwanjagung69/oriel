<?php

namespace App\Models\Admin\Messages;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class MessagesModel extends Model {
  protected $table = 'messages';
  protected $builder;

  protected $column_order = [
    'id', 
    'name',
    'email',
    'subject',
    'reading_status',
    'status'
  ];
  protected $column_search = [
    'name',
    'email',
    'subject',
    'reading_status',
    'status'
  ];
  protected $order = ['id' => 'DESC'];
  protected $request;
  protected $db;
  protected $dt;
  protected $session;
  protected $classesModel;

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
  }

  private function getDatatablesQuery($type) {
    $action = ($type == 'inbox' ? '0' : '1');
    $this->dt->where('action',$action);

    $i = 0;
    foreach ($this->column_search as $item) {
        if ($this->request->getPost('search')['value']) {
            if ($i === 0) {
                $this->dt->groupStart();
                $this->dt->like($item, $this->request->getPost('search')['value']);
            } else {
                $this->dt->orLike($item, $this->request->getPost('search')['value']);
            }
            if (count($this->column_search) - 1 == $i)
            $this->dt->groupEnd();
        }
        $i++;
    }

    if ($this->request->getPost('order')) {
        $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
    } else if (isset($this->order)) {
        $order = $this->order;
        $this->dt->orderBy(key($order), $order[key($order)]);
    }
  }

 public function getDatatables($type) {
    $this->getDatatablesQuery($type);

    if ($this->request->getPost('length') != -1) $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    $query = $this->dt->get();
    return $query->getResult();
  }

  public function countFiltered($type) {
    $this->getDatatablesQuery($type);
    return $this->dt->countAllResults();
  }

  public function countAll() {
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }

  public function ComposeMail($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $myIP = $this->classesModel->GETclientIPv2();
    $myBrowser = $this->classesModel->GETclientBrowser();

    /** Check Config Mail enable or disable and empty or not empty */
    $checkConfigMail = $this->checkConfigMail();
    if (empty($checkConfigMail)) {
      return array("code" => 403, "response" => 'Please setup configuration Email!');
      exit();
    }
    if ($checkConfigMail['status'] == 'inactive') {
      return array("code" => 403, "response" => 'Please enable email config become status ACTIVE!');
      exit();
    }
    /** [END] - Check Config Mail enable or disable and empty or not empty */

    $sql = "INSERT INTO `messages` (
      `uuid`,
      `name`,
      `email`,
      `subject`,
      `message`,
      `ip_address`,
      `user_agent`,
      `reading_status`,
      `browser_name`,
      `sendBy`,
      `sendDate`,
      `action`
    )
    VALUES
    (
      UUID(),
      '{$data['items']['name']}',
      '{$data['items']['mailTo']}',
      '{$data['items']['subject']}',
      '{$data['items']['message']}',
      '{$myIP}',
      '{$_SERVER['HTTP_USER_AGENT']}',
      '2',
      '{$myBrowser}',
      '{$userId}',
      '{$dateNow}',
      '1'
    )";   

    $result = $this->db->query($sql);
    $lastId = $this->db->insertID();

    if ($result == 1) {

      $getQuery = $this->db->table('email_setting');
      $configData = $getQuery->get()->getRowArray();

      $resultEmailTo = $this->classesModel->sendEmail($configData, $data, false, 'email-from');
      if ($resultEmailTo['status'] == 500) {
        $resultEmailTo = $this->classesModel->sendEmail($configData, $data, false, 'email-from');
      }

      $response = array(
        "code" => 201, 
        "response" => 'Email sent successfully!',
        "responseEmail" => array(
          "status" => $resultEmailTo['status'],
          "message" => $resultEmailTo['message'],
          "valid" => $resultEmailTo['valid']
        )
      );
    } else {
      $response = array(
        "code" => 500, 
        "response" => 'Internal Server Error',
        "responseEmail" => array(
          "status" => $resultEmailTo['status'],
          "message" => $resultEmailTo['message'],
          "valid" => $resultEmailTo['valid']
        )
      );
    }
    return $response;
  }

  public function getById($uuid) {
    // $builder = $this->db->table($this->table);
    // $builder->from($this->table);
    $this->builder->where('uuid', $uuid);
    $query = $this->builder->get(); 
    return $query->getRowArray();
  }

  private function checkConfigMail() {
    $getQuery = $this->db->table('email_setting');
    $configData = $getQuery->get()->getRowArray();
    return $configData;
  }

  public function getDataSenderMail($uuid) {
    $sql = "SELECT * FROM `messages` WHERE `uuid` = '{$uuid}'";
    $data = $this->db->query($sql)->getRowArray(); 
    return $data;
  } 

  public function readMail($uuid) {
    $sql = "UPDATE
      `messages`
    SET
      `reading_status` = '1'
    WHERE `uuid` = '{$uuid}'";

    $result = $this->db->query($sql);
    if ($result) {
      $getDataSender = $this->getDataSenderMail($uuid);
      $_mailTo = $this->checkConfigMail()['main_email'];
      $response = array("code" => 200, "response" => $getDataSender, "mailTo" => $_mailTo);
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function SendReplyEmail($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $myIP = $this->classesModel->GETclientIPv2();
    $myBrowser = $this->classesModel->GETclientBrowser();

    /** Check Config Mail enable or disable and empty or not empty */
    $checkConfigMail = $this->checkConfigMail();
    if (empty($checkConfigMail)) {
      return array("code" => 403, "response" => 'Please setup configuration Email!');
      exit();
    }
    if ($checkConfigMail['status'] == 'inactive') {
      return array("code" => 403, "response" => 'Please enable email config become status ACTIVE!');
      exit();
    }
    /** [END] - Check Config Mail enable or disable and empty or not empty */

    $sql = "INSERT INTO `messages` (
      `name`,
      `email`,
      `subject`,
      `message`,
      `ip_address`,
      `user_agent`,
      `reading_status`,
      `browser_name`,
      `sendBy`,
      `sendDate`,
      `action`
    )
    VALUES
      (
        '{$data['items']['name']}',
        '{$data['items']['mailTo']}',
        '{$data['items']['subject']}',
        '{$data['items']['message']}',
        '{$myIP}',
        '{$_SERVER['HTTP_USER_AGENT']}',
        '2',
        '{$myBrowser}',
        '{$userId}',
        '{$dateNow}',
        '1'
      )";

    $result = $this->db->query($sql);
    $lastId = $this->db->insertID();

    $uuid = $data['items']['uuid'];
    $sqlUpdateUuid = "UPDATE
      `messages`
    SET
      `uuid` = '{$uuid}'
    WHERE `id` = '{$lastId}'";
    $resultUpdateUuid = $this->db->query($sqlUpdateUuid);

    if ($resultUpdateUuid == 1) {
      $getQuery = $this->db->table('email_setting');
      $configData = $getQuery->get()->getRowArray();

      $resultEmailTo = $this->classesModel->sendEmail($configData, $data);
      if ($resultEmailTo['status'] == 500) {
        $resultEmailTo = $this->classesModel->sendEmail($configData, $data);
      }

      $response = array(
        "code" => 201, 
        "response" => $resultEmailTo['message'],
        "responseEmail" => array(
          "status" => $resultEmailTo['status'],
          "message" => $resultEmailTo['message'],
          "valid" => $resultEmailTo['valid']
        )
      );
    } else {
      $response = array(
        "code" => 500, 
        "response" => $resultEmailTo['message'],
        "responseEmail" => array(
          "status" => $resultEmailTo['status'],
          "message" => $resultEmailTo['message'],
          "valid" => $resultEmailTo['valid']
        )
      );
    }
    return $response;
  }

  public function DeleteData($data) {
    $id = $data['items']['id'];  
    $this->builder->where('id', $id);
    $this->builder->delete();
    return array("code" => 200, "response" => 'Data Deleted successfully!');
  }

}