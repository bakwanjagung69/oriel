<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Dashboard\DashboardModel;
use App\Models\ClassesModel;

class Dashboard extends BaseController {
    protected $DashboardModel;

    public function __construct() {
        $classesModel = new ClassesModel();
        $this->DashboardModel = new DashboardModel();

        /** Check if not login */
        $classesModel->checkIsNotLogin();
    }

    public function index() {
        $data['uri'] = $this->request->uri->getSegments();
    	// $data['datas_dashboard'] = "Dashboard Data";

        $getTotalDosen = $this->DashboardModel->getTotalDosen();
        $getTotalMahasiswa = $this->DashboardModel->getTotalMahasiswa();
        $getTotalUser = $this->DashboardModel->getTotalUser();

        $data['totalDosen'] = $getTotalDosen;
        $data['totalMahasiswa'] = $getTotalMahasiswa;
        $data['totalUser'] = $getTotalUser;

        return $this->template->Frontend("dashboard/component-view-dashboard", $data);
    }

    public function form($id = '') {
    	// if ($id == '') {
    	// 	return redirect()->to('admin/dashboard');
    	// }
    	// print_r('CONTROLLER FORM ==> '.$id);die;
        $data['uri'] = $this->request->uri->getSegments();
        $data['datas_dashboard'] = "Dashboard Data";
        return $this->template->Frontend("dashboard/component-view-dashboard", $data);
    }

}
