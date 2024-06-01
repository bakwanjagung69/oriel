<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class MainSite extends BaseController {

    public function index() {
        // return redirect()->to('admin/login');
        return redirect()->to('home');
    }

}
