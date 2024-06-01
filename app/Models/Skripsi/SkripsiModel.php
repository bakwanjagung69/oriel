<?php

namespace App\Models\Skripsi;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class SkripsiModel extends Model {
  protected $table = 'formulir_skripsi';
  protected $builder;
  protected $directoryUploaded = 'assets/upload/skripsi/';

  public function __construct() {
    parent::__construct();
    $this->db = db_connect();
    $this->request = Services::request();
    $this->dt = $this->db->table($this->table);
    $this->session = \Config\Services::session();
    $this->classesModel = new ClassesModel();
    $this->builder = $this->db->table($this->table);
  }

  public function getDataFormSkripsibyNimAndStatus($nim) {
    $getQuery   = $this->db->table('formulir_skripsi');
    $getQuery->select('*');
    $resultData = $getQuery->where("`nim` = '".$nim."' AND `status` IN ('1', '2', '3', '4', '5', '6')")->countAllResults();
    return intval($resultData);
  }

  public function AddNew($data) {
    date_default_timezone_set("Asia/Bangkok"); 

    $validationData = $this->getDataFormSkripsibyNimAndStatus($data['items']['nim']);

    if ($validationData > 0) {
      return array("code" => 302, "response" => '<div style="font-size: 15px;">Anda sebelumnya sudah pernah membuat Pengajuan Skripsi, harap menunggu hasil Skripsi anda sebelumnya dari Admin TU.</div>');
      exit();
    }

    if ($data['files']['skripsi_files']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    if ($data['files']['surat_tugas_file']['error'] == '1') {
      return $this->classesModel->msgCheckingUploadSize();
      exit();
    }

    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $_thumbDir = '';
    $_thumbFile = '';

    if ($data['files']['skripsi_files']['name'] !== '') {
      $valid = false;

      $files = explode('.', $data['files']['skripsi_files']['name']);
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
      //   default:
      //     $valid = true;
      //   break;
      }

      if ($valid) {
        $uploaddir  = $this->directoryUploaded;
        $fileName   = rand(1000,100000).'-'.$data['files']['skripsi_files']['name'];
        $fileTmp    = $data['files']['skripsi_files']['tmp_name'];
        $fileSize   = $data['files']["skripsi_files"]['size'];
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

    if ($data['files']['surat_tugas_file']['name'] !== '') {
      $validSuratTugas = false;

      $filesSuratTugas = explode('.', $data['files']['skripsi_files']['name']);
      $countArrSuratTugas = (count($filesSuratTugas) - 1);
      
      switch ($filesSuratTugas[$countArrSuratTugas]) {
        case 'pdf':
         $validSuratTugas = true;
        break;
      //   case 'xls':
      //     $validSuratTugas = false;
      //   break;
      //   case 'xlsx':
      //     $validSuratTugas = false;
      //   break;
      //   case 'doc':
      //     $validSuratTugas = false;
      //   break;
      //   case 'txt':
      //     $validSuratTugas = false;
      //   break;
      //   case 'ppt':
      //     $validSuratTugas = false;
      //   break;
      //   case 'pptx':
      //     $validSuratTugas = false;
      //   break;
      //   default:
      //     $validSuratTugas = true;
      //   break;
      }

      if ($validSuratTugas) {
        $uploaddirSuratTugas  = $this->directoryUploaded;
        $fileNameSuratTugas   = rand(1000,100000).'-'.$data['files']['surat_tugas_file']['name'];
        $fileTmpSuratTugas    = $data['files']['surat_tugas_file']['tmp_name'];
        $fileSizeSuratTugas   = $data['files']["surat_tugas_file"]['size'];
        $fileExtArrSuratTugas = explode('.',$fileNameSuratTugas);
        $fileExtSuratTugas    = strtolower(end($fileExtArrSuratTugas));
        $uploadfileSuratTugas = $uploaddirSuratTugas . $fileNameSuratTugas;
 
        //validSuratTugasate file size
        if ($fileSizeSuratTugas == 0) { /** If config php.ini standart 2MB */
          $errors = 'Image maximum 2MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        if($fileSizeSuratTugas > (1024 * 1024 * env('MAX_UPLOAD_FILES'))) { 
          $errors = 'Maximum '.env('MAX_UPLOAD_FILES').'MB files are allowed';
          return $this->response->setJson(array("code" => 400, "response" => $errors));
        }

        $_thumbDir = $uploaddirSuratTugas.'/thumbnails/'.'thumb-'.$fileNameSuratTugas;
        $_thumbFile = 'thumbnails/thumb-'.$fileNameSuratTugas;
      } else {
        return array("code" => 500, "response" => 'Incompatible file format!');
        exit();
      }
    }

    $sql = "INSERT INTO `{$this->table}` (
      `nama`,
      `nim`,
      `judul`,
      `skripsi_files`,
      `lembar_tugas_or_konsultasi_files`,
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
      '{$fileNameSuratTugas}',
      '{$data['items']['semester']}',
      '1',
      '{$userId}',
      '{$dateNow}'
    )";       

    $result = $this->db->query($sql);
    $lastUserId = $this->db->insertID();

    if ($result == 1) {
      if ($data['files']['skripsi_files']['name'] !== '') {
        $moveUpload = move_uploaded_file($fileTmp, $uploadfile);       
      }

     if ($data['files']['surat_tugas_file']['name'] !== '') {
        $moveUpload = move_uploaded_file($fileTmpSuratTugas, $uploadfileSuratTugas);       
      }

      $response = array("code" => 201, "response" => 'Pendaftaran Skripsi berhasil dan silahkan menunggu untuk dibuatkan jadwal sidang.');
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