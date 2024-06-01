<?php

namespace App\Models\Admin\Auth;
use App\Models\ClassesModel;
use CodeIgniter\Model;
 
class AuthModel extends Model {

  protected $session;
  protected $db;
  protected $classesModel;
  protected $encrypter;

  protected $table = 'user';
  protected $allowedFields = ['emailOrUsername', 'password']; 

  public function __construct() {
    $this->session = \Config\Services::session();
    $this->db = \Config\Database::connect();
    $this->classesModel = new ClassesModel();
  }

  public function doLogin($data, $G_recaptchaResponse = '') {
    $sql   = "SELECT * FROM {$this->table} WHERE `email` = '{$data['emailOrUsername']}' OR `username` = '{$data['emailOrUsername']}'";
    $query = $this->db->query($sql);
    $row   = $query->getRowArray();

    if (!empty($row)) {
      $isPasswordTrue = sha1($data["password"]) == $row['password'] ? true : false;

      $isAdmin = $row['rules'] == "1";

      if (ENVIRONMENT == 'production' && env('RECAPTCHA_IS_ACTIVE')) {
        $statusReCaptcha = $this->googleCaptachStore($G_recaptchaResponse);

        if (!$statusReCaptcha) {
          /** ReCaptcha Not Valid */
          $this->session->setFlashdata(['login_error' => "Error verifiying reCAPTCHA, please try again."]);
          return false;
        }
      }

      if ($row['status'] == '0') {
        /** User Status Inactive */
        $this->session->setFlashdata(['login_error' => "Akun sudah di nonaktifkan."]);
        return false;
      }

      if (!$isPasswordTrue) {
        /** Password not match! */
        $this->session->setFlashdata(['login_error' => "Incorrect password!"]);
        return false;
      }

      /** is Administrator */ 
      if($isPasswordTrue && $isAdmin) { 
        /** login Success */
        $this->updateLogData($row);            
        $arrSet = array_replace($row, array(
            'images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['images']),
            'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['thumbnail_images'])
        ));
        $this->session->set(['user_logged' => $arrSet]);
        return true;
      }

      /** is Admin */
      if($isPasswordTrue && $row['rules'] == '2'){ 
        /** login Success */
        $this->updateLogData($row);
        $arrSet = array_replace($row, array(
            'images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['images']),
            'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['thumbnail_images'])
        ));
        $this->session->set(['user_logged' => $arrSet]);
        return true;
      }

      /** is Employee */
      if($isPasswordTrue && $row['rules'] == '3'){ 
        /** login Success */
        $this->updateLogData($row);
        $arrSet = array_replace($row, array(
            'images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['images']),
            'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['thumbnail_images'])
        ));
        $this->session->set(['user_logged' => $arrSet]);
        return true;
      }

      /** is Owner */
      if($isPasswordTrue && $row['rules'] == '4'){ 
        /** login Success */
        $this->updateLogData($row);
        $arrSet = array_replace($row, array(
            'images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['images']),
            'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$row['thumbnail_images'])
        ));
        $this->session->set(['user_logged' => $arrSet]);
        return true;
      }

    } else {
      $this->session->setFlashdata(['login_error' => "Email, Username atau Password tidak sesuai."]);
      return false;
    }
  }

  public function LogoutData($id) {
    $sql = "UPDATE
      `user`
    SET
      `is_online` = '0',
      `is_online` = '0'
    WHERE `id` = '{$id}'";        
    return $this->db->query($sql);
  }

  public function updateLogData($data) {
    date_default_timezone_set("Asia/Bangkok");        

    $dataNow   = date('Y-m-d H:i:s');
    $myIP      = $this->classesModel->GETclientIP();
    $myBrowser = $this->classesModel->GETclientBrowser();

    $sql = "UPDATE
      `user`
    SET
      `last_login` = '{$dataNow}',
      `last_login_ip` = '{$myIP}',
      `last_login_agent` = '{$_SERVER['HTTP_USER_AGENT']}',
      `browser_name` = '{$myBrowser}',
      `is_online` = '1',
      `uuid` = UUID(),
      `updateBy` = '{$data['id']}',
      `updateDate` = '{$dataNow}'
    WHERE `id` = '{$data['id']}'";
    $result = $this->db->query($sql);

    return $result;
  }

  public function googleCaptachStore($G_recaptchaResponse) {
    $recaptchaResponse = trim($G_recaptchaResponse);

    // form data
    $secret = env('RECAPTCHAV2_SECRET');

    $credential = array(
      'secret' => $secret,
      'response' => $recaptchaResponse
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $status = json_decode($response, true);

    return $status['success'];
  }

}