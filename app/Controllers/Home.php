<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index() {
    	// $data["data"] = '';
        // return $this->template->Frontend("home/component-view-home", $data);
        return view('welcome_message');
    }
}
