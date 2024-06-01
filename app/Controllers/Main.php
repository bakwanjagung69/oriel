<?php

namespace App\Controllers;

class Main extends BaseController {

    public function index() {
    	/** Uncoment if not include frontend */
    	// $data["data"] = '';
        // return $this->template->Frontend("home/component-view-home", $data);
        return redirect()->to('login');

        /** Uncoment if only CMS system */
        // return redirect()->to('admin/login');

    }

}
