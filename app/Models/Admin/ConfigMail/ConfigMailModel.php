<?php

namespace App\Models\Admin\ConfigMail;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class ConfigMailModel extends Model {
  protected $table = 'email_setting';
  protected $builder;

  protected $column_order = [
    'id', 
    'main_email',
    'email_name',
    'logo',
    'social_media',
    'subject_email',
    'body_email_to',
    'email_received',
    'body_email_received',
    'email_cc',
    'reply_to_email',
    'reply_to_email_name',
    'mail_type',
    'protocol',
    'host',
    'username',
    'password',
    'port',
    'charset',
    'timeout',
    'validation',
    'wordwrap',
    'status'

  ];
  protected $column_search = [
    'id', 
    'main_email',
    'email_name',
    'logo',
    'social_media',
    'subject_email',
    'body_email_to',
    'email_received',
    'body_email_received',
    'email_cc',
    'reply_to_email',
    'reply_to_email_name',
    'mail_type',
    'protocol',
    'host',
    'username',
    'password',
    'port',
    'charset',
    'timeout',
    'validation',
    'wordwrap',
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

  private function getDatatablesQuery() {
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

 public function getDatatables(){
    $this->getDatatablesQuery();
    if ($this->request->getPost('length') != -1) $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    $query = $this->dt->get();
    return $query->getResult();
  }

  public function countFiltered() {
    $this->getDatatablesQuery();
    return $this->dt->countAllResults();
  }

  public function countAll() {
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }

  public function AddNew($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $emailCCList = implode(',', json_decode($data['items']['email_cc_list']));

    $query = "SELECT COUNT(1) AS count FROM `email_setting`";
    $row   = $this->db->query($query)->getRowArray(); 
    if ($row['count'] > 0) {
      return array("code" => 403, "response" => 'Data can only be one!');
      exit();
    }

    $_thumbDir = '';
    $_thumbFile = '';

    if ($data['files']['logo']['name'] !== '') {
      $valid = true;
      $files = explode('.', $data['files']['logo']['name']);
      $countArr = (count($files) - 1);
      
      switch ($files[$countArr]) {
        case 'pdf':
         $valid = false;
        break;
        case 'xls':
          $valid = false;
        break;
        case 'xlsx':
          $valid = false;
        break;
        case 'doc':
          $valid = false;
        break;
        case 'txt':
          $valid = false;
        break;
        case 'ppt':
          $valid = false;
        break;
        case 'pptx':
          $valid = false;
        break;
        default:
          $valid = true;
        break;
      }

      if ($valid) {
        $uploaddir  = 'assets/upload/config-email/';
        $fileName   = rand(1000,100000).'-'.$data['files']['logo']['name'];
        $fileTmp    = $data['files']['logo']['tmp_name'];
        $fileSize   = $data['files']["logo"]['size'];
        $fileExtArr = explode('.',$fileName);
        $fileExt    = strtolower(end($fileExtArr));
        $uploadfile = $uploaddir . $fileName;
 
       //validate file size
        if ($fileSize == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          echo $this->response->setJson(array("code" => 400, "response" => $errors));
          exit();
        }

        if($fileSize > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { /** 2MB */ 
          $errors = 'Maximum 2MB files are allowed';
          return $arr = array("code" => 400, "response" => $errors);
          exit();
        }

        $_thumbDir = $uploaddir.'/thumbnails/'.'thumb-'.$fileName;
        $_thumbFile = 'thumbnails/thumb-'.$fileName;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }

    }

    $sql = "INSERT INTO `email_setting` (
      `main_email`,
      `email_name`,
      `logo`,
      `thumbnail_logo`,
      `social_media`,
      `subject_email`,
      `body_email_to`,
      `email_received`,
      `body_email_received`,
      `email_cc`,
      `reply_to_email`,
      `reply_to_email_name`,
      `mail_type`,
      `protocol`,
      `host`,
      `username`,
      `password`,
      `port`,
      `charset`,
      `timeout`,
      `validation`,
      `wordwrap`,
      `status`,
      `createDate`,
      `createBy`
    )
    VALUES
    (
      '{$data['items']['main_email']}',
      '{$data['items']['email_name']}',
      '{$fileName}',
      '{$_thumbFile}',
      '{$data['items']['sosmed_list']}',
      '{$data['items']['subject_email']}',
      '{$data['items']['body_email_to']}',
      '{$data['items']['email_received']}',
      '{$data['items']['body_email_received']}',
      '{$emailCCList}',
      '{$data['items']['reply_to_email']}',
      '{$data['items']['reply_to_email_name']}',
      '{$data['items']['mail_type']}',
      '{$data['items']['protocol']}',
      '{$data['items']['host']}',
      '{$data['items']['username']}',
      '{$data['items']['password']}',
      '{$data['items']['port']}',
      '{$data['items']['charset']}',
      '{$data['items']['timeout']}',
      '{$data['items']['validation']}',
      '{$data['items']['wordwrap']}',
      '{$data['items']['status']}',
      '{$dateNow}',
      '{$userId}'
    )";        

    $result = $this->db->query($sql);
    $lastId = $this->db->insertID();

    if ($result == 1) {
        $moveUpload = move_uploaded_file($fileTmp, $uploadfile);       

        $this->classesModel->createThumbnail(
          $uploaddir.$fileName, 
          $fileExt,
          $_thumbDir, 
          150,
          90
        );

      $response = array("code" => 201, "response" => 'Data saved successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function getById($id) {
    $id = $this->classesModel->decrypter($id);
    $this->builder->where('id',$id);
    $query = $this->builder->get(); 
    return $query->getRowArray();
  }

  public function UpdateData($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];
    $emailCCList = implode(',', json_decode($data['items']['email_cc_list']));
    $ids = $this->classesModel->decrypter($data['items']['id']);

    $_thumbDir = '';
    $_thumbFile = '';

    if ($data['files']['logo']['name'] !== '') {
      $valid = true;
      $files = explode('.', $data['files']['logo']['name']);
      $countArr = (count($files) - 1);
      
      switch ($files[$countArr]) {
        case 'pdf':
         $valid = false;
        break;
        case 'xls':
          $valid = false;
        break;
        case 'xlsx':
          $valid = false;
        break;
        case 'doc':
          $valid = false;
        break;
        case 'txt':
          $valid = false;
        break;
        case 'ppt':
          $valid = false;
        break;
        case 'pptx':
          $valid = false;
        break;
        default:
          $valid = true;
        break;
      }

      if ($valid) {
        $uploaddir  = 'assets/upload/config-email/';
        $fileName   = rand(1000,100000).'-'.$data['files']['logo']['name'];
        $fileTmp    = $data['files']['logo']['tmp_name'];
        $fileSize   = $data['files']["logo"]['size'];
        $fileExtArr = explode('.',$fileName);
        $fileExt    = strtolower(end($fileExtArr));
        $uploadfile = $uploaddir . $fileName;
 
        //validate file size
        if ($fileSize == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          echo $this->response->setJson(array("code" => 400, "response" => $errors));
          exit();
        }

        if($fileSize > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { /** 2MB */ 
          $errors = 'Maximum 2MB files are allowed';
          return $arr = array("code" => 400, "response" => $errors);
          exit();
        }

        $_thumbDir = $uploaddir.'/thumbnails/'.'thumb-'.$fileName;
        $_thumbFile = 'thumbnails/thumb-'.$fileName;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }

      /** Remove File Images and Thumnails */
      $sql = "SELECT
          `logo`,
          `thumbnail_logo`
        FROM
          `email_setting`
        WHERE id = '{$ids}'";
      $__resImg = $this->db->query($sql)->getRowArray();

      $images_value_all = array(
        $__resImg['logo'],
        $__resImg['thumbnail_logo']
      );

      foreach ($images_value_all as $value) {
        $url         = 'assets/upload/config-email/'.$value;
        $cek_files   = file_exists($url);
        if ($cek_files == 1) {
          @unlink($url);
        }
      }
      /** [END] Remove File Images and Thumnails */
    }

    $sql = "UPDATE
      `email_setting`
    SET
      `main_email` = '{$data['items']['main_email']}',
      `email_name` = '{$data['items']['email_name']}',
      `social_media` = '{$data['items']['sosmed_list']}',
      `subject_email` = '{$data['items']['subject_email']}',
      `body_email_to` = '{$data['items']['body_email_to']}',
      `email_received` = '{$data['items']['email_received']}',
      `body_email_received` = '{$data['items']['body_email_received']}',
      `email_cc` = '{$emailCCList}',
      `reply_to_email` = '{$data['items']['reply_to_email']}',
      `reply_to_email_name` = '{$data['items']['reply_to_email_name']}',
      `mail_type` = '{$data['items']['mail_type']}',
      `protocol` = '{$data['items']['protocol']}',
      `host` = '{$data['items']['host']}',
      `username` = '{$data['items']['username']}',
      `password` = '{$data['items']['password']}',
      `port` = '{$data['items']['port']}',
      `charset` = '{$data['items']['charset']}',
      `timeout` = '{$data['items']['timeout']}',
      `validation` = '{$data['items']['validation']}',
      `wordwrap` = '{$data['items']['wordwrap']}',
      `status` = '{$data['items']['status']}',";

    $sql .=  ($data['files']['logo']['name'] !== '') ? "`logo` = '".$fileName."', `thumbnail_logo` = '".$_thumbFile."'," : '';

    $sql .=  "`updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$ids}'";

    $result = $this->db->query($sql);

    if ($result == 1) {
      if ($data['files']['logo']['name'] !== '') {
        $moveUpload = move_uploaded_file($fileTmp, $uploadfile);       

        $this->classesModel->createThumbnail(
          $uploaddir.$fileName, 
          $fileExt,
          $_thumbDir, 
          150,
          90
        );
      }

      $response = array("code" => 201, "response" => 'Data saved successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function DeleteData($data) {
    $id = $this->classesModel->decrypter($data['items']['id']);

    $sql = "SELECT
            `logo`,
            `thumbnail_logo`
          FROM
            `email_setting`
          WHERE id = '{$id}';";
    $data = $this->db->query($sql)->getRowArray();

    $images_value_all = array(
      $data['logo'],
      $data['thumbnail_logo']
    );

    $valid = false;
    foreach ($images_value_all as $value) {
      $url         = 'assets/upload/config-email/'.$value;
      $cek_files   = file_exists($url);
      if ($cek_files == 1) {
        @unlink($url);
        $valid = true;
      }
      $valid = true;
    }

    if ($valid) {
      $this->builder->where('id', $id);
      $this->builder->delete();
    }
    return array("code" => 200, "response" => 'Data Deleted successfully!');
  }

}