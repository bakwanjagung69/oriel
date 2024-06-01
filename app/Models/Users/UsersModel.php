<?php

namespace App\Models\Users;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class UsersModel extends Model {
  protected $table = 'user';
  protected $directoryUploaded = 'assets/upload/users/';
  protected $builder;

  protected $column_order = [
    'id', 
    'full_name', 
    'nim', 
    'username', 
    'email', 
    'password', 
    'uuid',
    'last_login',
    'last_login_ip',
    'last_login_agent',
    'browser_name',
    'is_online',
    'status',
    'rules',
    'images',
    'thumbnail_images',
    'createBy',
    'createDate',
    'updateBy',
    'updateDate'
  ];
  protected $column_search = [
    'full_name', 
    'nim', 
    'username', 
    'email', 
    'status',
    'is_online',
    'rules',
    'images',
    'thumbnail_images'
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

    if ($data['files']['images']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $fileName = 'default-avatar.png';
    $_thumbFile = 'thumbnails/thumb-default-avatar.png';

    if ($data['files']['images']['name'] !== '') {
      $_thumbDir = '';
      $_thumbFile = '';

      if ($data['files']['images']['name'] !== '') {
        $valid = true;
        $files = explode('.', $data['files']['images']['name']);
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
          $uploaddir  = $this->directoryUploaded;
          $fileName   = rand(1000,100000).'-'.$data['files']['images']['name'];
          $fileTmp    = $data['files']['images']['tmp_name'];
          $fileSize   = $data['files']["images"]['size'];
          $fileExtArr = explode('.',$fileName);
          $fileExt    = strtolower(end($fileExtArr));
          $uploadfile = $uploaddir . $fileName;
   
          //validate file size
          if ($fileSize == 0) { /** If config php.ini standart 2MB */
            $errors = 'Image maximum 2MB files are allowed';
            return $this->response->setJson(array("code" => 400, "response" => $errors));
          }

          if($fileSize > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
            $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
            return $this->response->setJson(array("code" => 400, "response" => $errors));
          }

          $_thumbDir = $uploaddir.'/thumbnails/'.'thumb-'.$fileName;
          $_thumbFile = 'thumbnails/thumb-'.$fileName;
        } else {
          return array("code" => 500, "response" => 'Incompatible file format!');
          exit();
        }

      }
    }

    $_password = sha1($data['items']['pass']);

    $sql = "INSERT INTO `{$this->table}` (
      `full_name`,
      `nim`,
      `username`,
      `email`,
      `images`,
      `thumbnail_images`,
      `password`,
      `status`,
      `rules`,
      `createBy`,
      `createDate`
    )
    VALUES
    (
      '{$data['items']['full_name']}',
      '{$data['items']['nim']}',
      '{$data['items']['username']}',
      '{$data['items']['email']}',
      '{$fileName}',
      '{$_thumbFile}',
      '{$_password}',
      '{$data['items']['status']}',
      '{$data['items']['rules']}',
      '{$userId}',
      '{$dateNow}'
    )";       

    $result = $this->db->query($sql);
    $lastUserId = $this->db->insertID();

    if ($result == 1) {

      if ($data['files']['images']['name'] !== '') {
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

  public function getById($id) {
    $id = $this->classesModel->decrypter($id);

    $this->builder->where('id',$id);
    $query = $this->builder->get(); 
    return $query->getRowArray();
  }

  public function UpdateData($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    if ($data['files']['images']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $_thumbDir = '';
    $_thumbFile = '';

    $ids = $this->classesModel->decrypter($data['items']['id']);

    if ($data['files']['images']['name'] !== '') {
      $valid = true;
      $files = explode('.', $data['files']['images']['name']);
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
        $uploaddir  = $this->directoryUploaded;
        $fileName   = rand(1000,100000).'-'.$data['files']['images']['name'];
        $fileTmp    = $data['files']['images']['tmp_name'];
        $fileSize   = $data['files']["images"]['size'];
        $fileExtArr = explode('.',$fileName);
        $fileExt    = strtolower(end($fileExtArr));
        $uploadfile = $uploaddir . $fileName;
 
        //validate file size
        if ($fileSize == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        if($fileSize > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
          $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        $_thumbDir = $uploaddir.'/thumbnails/'.'thumb-'.$fileName;
        $_thumbFile = 'thumbnails/thumb-'.$fileName;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }

      /** Remove File Images and Thumnails */
      $sql = "SELECT
          `images`,
          `thumbnail_images`
        FROM
          `{$this->table}`
        WHERE id = '{$ids}'";
      $__resImg = $this->db->query($sql)->getRowArray();

      $images_value_all = array(
        $__resImg['images'],
        $__resImg['thumbnail_images']
      );

      foreach ($images_value_all as $value) {
        $url         = $this->directoryUploaded.$value;
        $cek_files   = file_exists($url);
        if ($cek_files == 1) {
          @unlink($url);
        }
      }
      /** [END] Remove File Images and Thumnails */
    }

    $_password = sha1($data['items']['pass']);

    $sql = "UPDATE
      `{$this->table}`
    SET
      `full_name` = '{$data['items']['full_name']}',
      `nim` = '{$data['items']['nim']}',
      `username` = '{$data['items']['username']}',
      `email` = '{$data['items']['email']}',";

    $sql .= ($data['items']['pass'] !== '') ? "`password` = '".$_password."'," : '';

    $sql .=  "`status` = '{$data['items']['status']}',
      `rules` = '{$data['items']['rules']}',";

    $sql .=  ($data['files']['images']['name'] !== '') ? "`images` = '".$fileName."', `thumbnail_images` = '".$_thumbFile."'," : '';

    $sql .=  "`updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$ids}'";

    $result = $this->db->query($sql);

    if ($result == 1) {
      if ($data['files']['images']['name'] !== '') {
        $moveUpload = move_uploaded_file($fileTmp, $uploadfile);       

        $this->classesModel->createThumbnail(
          $uploaddir.$fileName, 
          $fileExt,
          $_thumbDir, 
          150,
          90
        );
      }

      if ($this->session->user_logged['id'] == $ids) {
        $setArrayObj = (object) array(
          'images' => ($data['files']['images']['name'] !== '') ? '/assets/upload/users/'.$fileName : $this->classesModel->decrypter($this->session->user_logged['images']),
          'thumbnail_images' => ($data['files']['images']['name'] !== '') ? '/assets/upload/users/'.$_thumbFile : $this->classesModel->decrypter($this->session->user_logged['thumbnail_images']),
          'full_name' => $data['items']['full_name'],
          'username' => $data['items']['username'],
          'password' => ($data['items']['pass'] !== '') ? $_password : $this->session->user_logged['password'],
          'email' => $data['items']['email'],
          'status' => $data['items']['status'],
          'rules' => $data['items']['rules'],
          'updateBy' => $data['items']['id'],
          'updateDate' => $dateNow
        );
        $this->classesModel->updateDataSession($setArrayObj);
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
            `images`,
            `thumbnail_images`
          FROM
            `{$this->table}`
          WHERE id = '{$id}'";
    $data = $this->db->query($sql)->getRowArray();

    $images_value_all = array(
      $data['images'],
      $data['thumbnail_images']
    );

    $valid = false;
    foreach ($images_value_all as $value) {
      $url         = $this->directoryUploaded.$value;
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