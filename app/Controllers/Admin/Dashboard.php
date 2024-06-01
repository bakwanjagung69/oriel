<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ClassesModel;

class Dashboard extends BaseController {

    public function __construct() {
        $classesModel = new ClassesModel();

        /** Check if not login */
        $classesModel->checkIsNotLogin();
    }

    public function index() {
        $data['uri'] = $this->request->uri->getSegments();
    	$data['datas_dashboard'] = "Dashboard Data";
        return $this->template->Cms("admin/dashboard/component-view-dashboard", $data);
    }

    public function form($id = '') {
    	// if ($id == '') {
    	// 	return redirect()->to('admin/dashboard');
    	// }
    	// print_r('CONTROLLER FORM ==> '.$id);die;
        $data['uri'] = $this->request->uri->getSegments();
        $data['datas_dashboard'] = "Dashboard Data";
        return $this->template->Cms("admin/dashboard/component-view-dashboard", $data);
    }

}
