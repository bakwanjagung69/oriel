<?php

namespace App\Models\Admin\Profile;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class ProfileModel extends Model {
  protected $table = 'user';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/users/';

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
  }

  public function getDataProfileFromSessionData() {
    $sessionData = $this->session->user_logged;
    return $sessionData;
  }

  public function getDataProfile($userId) {
    $getQuery = $this->db->table('user');
    $configData = $getQuery->getWhere(['id' => $userId])->getRowArray();
    return $configData;
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

    if ($data['files']['images']['name'] !== '') {
      /** Remove File Images and Thumnails */
      $ids = $data['items']['userId'];
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

      $valid = false;
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

    $sql = "UPDATE
      `{$this->table}`
    SET
      `full_name` = '{$data['items']['full_name']}',
      `email` = '{$data['items']['email']}',";

    $sql .=  ($data['files']['images']['name'] !== '') ? "`images` = '".$fileName."', `thumbnail_images` = '".$_thumbFile."'," : '';

    $sql .=  "`updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$data['items']['userId']}'";

    $result = $this->db->query($sql);
    // $id = $this->db->insert_id();

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

      $setArrayObj = (object) array(
        'images' => ($data['files']['images']['name'] !== '') ? '/assets/upload/users/'.$fileName : $this->classesModel->decrypter($this->session->user_logged['images']),
        'thumbnail_images' => ($data['files']['images']['name'] !== '') ? '/assets/upload/users/'.$_thumbFile : $this->classesModel->decrypter($this->session->user_logged['thumbnail_images']),
        'full_name' => $data['items']['full_name'],
        'email' => $data['items']['email'],
        'updateBy' => $userId,
        'updateDate' => $dateNow
      );
      $this->classesModel->updateDataSession($setArrayObj);  

      $response = array("code" => 201, "response" => 'Data saved successfully!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function changePassword($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $ids = $data['userId'];
    $newPass = sha1($data['confirm_password']);

    $sql = "UPDATE
      `{$this->table}`
    SET
      `password` = '{$newPass}',
      `updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$ids}'";
    $result = $this->db->query($sql);

    if ($result == 1) {

       $setArrayObj = (object) array(
        'password' => $newPass,
        'updateBy' => $userId,
        'updateDate' => $dateNow
      );
      $this->classesModel->updateDataSession($setArrayObj);  

      $response = array("code" => 201, "response" => 'Profile data successfully update!');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;

  }

}