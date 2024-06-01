<?php

namespace App\Models\UjiKelayakan;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class UjiKelayakanModel extends Model {
  protected $table = 'formulir_uji_kelayakan';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/uji-kelayakan/';

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
  }

  public function getDataFormUjiKelayakanByNimAndStatus($nim) {
    $getQuery   = $this->db->table('formulir_uji_kelayakan');
    $getQuery->select('*');
    $resultData = $getQuery->where("`nim` = '".$nim."' AND `status` IN ('1', '2', '3', '4', '5', '6')")->countAllResults();
    return intval($resultData);
  }

  public function AddNew($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $validationData = $this->getDataFormUjiKelayakanByNimAndStatus($data['items']['nim']);

    if ($validationData > 0) {
      return array("code" => 302, "response" => '<div style="font-size: 15px;">Anda sebelumnya sudah pernah membuat Uji Kelayakan, harap menunggu hasil Uji Kelayakan anda sebelumnya dari Admin TU.</div>');
      exit();
    }

    if ($data['files']['proposal_file']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $_thumbDir = '';
    $_thumbFile = '';

    if ($data['files']['proposal_file']['name'] !== '') {
      // $valid = false;

      $valid = true;
      $files = explode('.', $data['files']['proposal_file']['name']);
      $countArr = (count($files) - 1);
      
      switch ($files[$countArr]) {
        case 'pdf':
         $valid = true;
        break;
      //   case 'xls':
      //     $valid = false;
      //   break;
      //   case 'xlsx':
      //     $valid = false;
      //   break;
      //   case 'doc':
      //     $valid = false;
      //   break;
      //   case 'txt':
      //     $valid = false;
      //   break;
      //   case 'ppt':
      //     $valid = false;
      //   break;
      //   case 'pptx':
      //     $valid = false;
      //   break;
        default:
          $valid = true;
        break;
      }

      if ($valid) {
        $uploaddir  = $this->directoryUploaded;
        $fileName   = rand(1000,100000).'-'.$data['files']['proposal_file']['name'];
        $fileTmp    = $data['files']['proposal_file']['tmp_name'];
        $fileSize   = $data['files']["proposal_file"]['size'];
        $fileExtArr = explode('.',$fileName);
        $fileExt    = strtolower(end($fileExtArr));
        $uploadfile = $uploaddir . $fileName;
 
        //validate file size
        // if ($fileSize == 0) { /** If config php.ini standart 2MB */
        //   $errors = 'Image maximum 2MB files are allowed';
        //   return $this->response->setJson(array("code" => 400, "response" => $errors));
        // }

        // if($fileSize > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
        //   $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
        //   return $this->response->setJson(array("code" => 400, "response" => $errors));
        // }

        $_thumbDir = $uploaddir.'/thumbnails/'.'thumb-'.$fileName;
        $_thumbFile = 'thumbnails/thumb-'.$fileName;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }

    }

    $sql = "INSERT INTO `{$this->table}` (
      `nama`,
      `nim`,
      `judul`,
      `files`,
      `semester`,
      `status`,
      `createBy`,
      `createDate`
    )
    VALUES
    (
      '{$data['items']['nama']}',
      '{$data['items']['nim']}',
      '{$data['items']['judul']}',
      '{$fileName}',
      '{$data['items']['semester']}',
      '1',
      '{$userId}',
      '{$dateNow}'
    )";       

    $result = $this->db->query($sql);
    $lastUserId = $this->db->insertID();

    if ($result == 1) {
      if ($data['files']['proposal_file']['name'] !== '') {
        $moveUpload = move_uploaded_file($fileTmp, $uploadfile);       
      }

      $response = array("code" => 201, "response" => 'Silahkan menunggu hasil uji kelayakan di halaman surat tugas.');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

  public function getUserDataById($id) {
    $getQuery   = $this->db->table('user');
    $resultData = $getQuery->getWhere(['id' => $id])->getRowArray();
    return $resultData;
  }



}