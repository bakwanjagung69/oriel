<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Auth\AuthModel;
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
        $checkisLogin = $this->classesModel->checkIsLogin();
        if ($checkisLogin) {
            return redirect()->to('dashboard');
        }
        
        return view('login/component-view-login');
    }

    public function auth() {
        $post = $this->request->getVar();
        $G_recaptchaResponse = $this->request->getVar('g-recaptcha-response');
        
        if ($post) {
            $setArrData = array(
                'nim' => $post['nim'],
                'password' => $post['password']
            );
            if ($this->authModel->doLogin($setArrData, $G_recaptchaResponse)) {
                $rules = $this->session->user_logged['rules'];

                if (in_array(session()->get('user_logged')['rules'], ['1', '2', '3', '4'])) {
                    return redirect()->to('dashboard');
                }

                if (in_array(session()->get('user_logged')['rules'], ['5'])) {
                    return redirect()->to('jadwalSidang');
                }
            }
        }

        return redirect()->to('login');
    }

    public function logout() {   
        $userId = $this->session->user_logged['id'];
        $this->authModel->LogoutData($userId);

        $this->session->destroy();
        return redirect()->to('login');
    }

}
