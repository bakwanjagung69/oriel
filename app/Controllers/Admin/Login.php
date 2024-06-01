<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\Auth\AuthModel;
use App\Models\ClassesModel;

class Login extends BaseController {
    protected $classesModel;
    protected $authModel;
    protected $session;
    protected $db;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->authModel = new AuthModel();
        $this->session = \Config\Services::session();
        $this->db      = \Config\Database::connect();
    }

    public function index() {
        // $checkisLogin = $this->classesModel->checkIsLogin();
        // if ($checkisLogin) {
        //     return redirect()->to('admin/dashboard');
        // }
        
        // return view('admin/login/component-view-login');
        return redirect()->to('main');
    }

    public function auth() {
        $post = $this->request->getVar();
        $G_recaptchaResponse = $this->request->getVar('g-recaptcha-response');
        
        if ($post) {
            $setArrData = array(
                'emailOrUsername' => $post['emailOrUsername'],
                'password' => $post['password']
            );
            if ($this->authModel->doLogin($setArrData, $G_recaptchaResponse)) {
                return redirect()->to('admin/dashboard');
            }
        }
        return redirect()->to('admin/login');
    }

    public function logout() {   
        $userId = $this->session->user_logged['id'];
        $this->authModel->LogoutData($userId);

        $this->session->destroy();
        return redirect()->to('admin/login');
    }

}
