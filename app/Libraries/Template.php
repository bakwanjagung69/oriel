<?php

namespace App\Libraries;

class Template {

    public function __construct() {
 
    }

	function Cms($view, $data = []) {
		/*
		 * $data['header'] , $data['content'] , $data['footer']
		 * variabel diatas ^ nantinya akan dikirim ke file views/site/index.php
		 * */

        $data['header']         = view('admin/layout/header', $data);
        $data['mainHeader']     = view('admin/layout/mainHeader', $data);
        $data['mainSidebar']    = view('admin/layout/mainSidebar', $data);
        $data['controlSidebar'] = view('admin/layout/controlSidebar', $data);
        $data['breadcrumb']     = view('admin/layout/breadcrumb', $data);
        $data['content']        = view($view, $data);
        $data['footer']         = view('admin/layout/footer', $data);

        return view('admin/layout/index', $data);
    }

    function Frontend($view, $data = []) {
        /*
         * $data['header'] , $data['content'] , $data['footer']
         * variabel diatas ^ nantinya akan dikirim ke file views/site/index.php
         * */

        $data['header']         = view('layout/header', $data);
        $data['mainHeader']     = view('layout/mainHeader', $data);
        $data['mainSidebar']    = view('layout/mainSidebar', $data);
        $data['content']        = view($view, $data);
        $data['footer']         = view('layout/footer', $data);
        $data['modal']         = view('layout/modal', $data);

        return view('layout/index', $data);
    }

    function Error404($view, $data = []){

    }

}

