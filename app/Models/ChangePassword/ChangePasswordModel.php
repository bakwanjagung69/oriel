<?php

namespace App\Models\ChangePassword;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class ChangePasswordModel extends Model {
  protected $table = 'user';
  protected $builder;

 
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

  public function getById($id) {
    $id = $this->classesModel->decrypter($id);

    $this->builder->where('id',$id);
    $query = $this->builder->get(); 
    return $query->getRowArray();
  }

  public function updatePassword($data) {
    date_default_timezone_set("Asia/Bangkok");
    $__data = $data['items'];
    $dateNow = date('Y-m-d H:i:s');
    $userId = $this->session->user_logged['id'];

    $ids = $this->classesModel->decrypter($__data['id']);

    $getOldPass = $this->getById($__data['id'])['password'];
    $isPasswordTrue = sha1($__data["password_lama"]) == $getOldPass ? true : false;

    if (!$isPasswordTrue) {
      /** Password not match! */
      return array("code" => 302, "response" => 'Password Lama Tidak sesuai!');
      exit();
    }

    $_password = sha1($__data['password_baru']);

    $sql = "UPDATE
      `{$this->table}`
    SET
      `password` = '{$_password}',
      `updateBy` = '{$userId}',
      `updateDate` = '{$dateNow}'
    WHERE `id` = '{$ids}'";

    $result = $this->db->query($sql);

    if ($result == 1) {
      $response = array("code" => 201, "response" => 'Password Berhasil Diperbaruhi.');
    } else {
      $response = array("code" => 500, "response" => 'Internal Server Error');
    }
    return $response;
  }

}