<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\HasilPenilaianJudul\HasilPenilaianJudulModel;
use App\Models\ClassesModel;
use Config\Services;

class HasilPenilaianJudul extends BaseController {
    protected $classesModel;
    protected $HasilPenilaianJudulModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->HasilPenilaianJudulModel = new HasilPenilaianJudulModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("hasil-penilaian-judul/component-view-hasil-penilaian-judul", $data);
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->HasilPenilaianJudulModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                // $_ids = $this->classesModel->encrypter($list->id);
                $mahasiswaId  = $this->HasilPenilaianJudulModel->getUserDataByNim($list->nim)['id'];
                $mahasiswaName  = $this->HasilPenilaianJudulModel->getUserDataByNim($list->nim)['full_name'];
                $userRules = $this->session->user_logged['rules'];

                $no++;
                $row = [];

                $row['uji_kelayakan_id'] = $list->id;
                $row['mahasiswa_id'] = $mahasiswaId;
                $row['mahasiswa_nim'] = $list->nim;
                $row['mahasiswa_name'] = $mahasiswaName;
                $row['judul'] = $list->judul;
                $row['semester'] = $list->semester;
                $row['status'] = $list->status;
                $row['createDate'] = date("d M Y", strtotime($list->createDate)); 
                $row['userRules'] = $userRules;

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->HasilPenilaianJudulModel->countAll(),
                'recordsFiltered' => $this->HasilPenilaianJudulModel->countFiltered(),
                'data' => $data
            ];
        }
        return $this->response->setJson($output);
    }

    public function hasilPenilaian() {
        $data['mhsId']   = $_GET['mhsId'];
        $data['ujiKelayakanId'] = $_GET['ujiKelayakanId'];
        $data['statusPenugasan'] = $_GET['statusPenugasan'];
        $data['status'] = $_GET['status'];

        $resultData = $this->HasilPenilaianJudulModel->getDataHasilPenilaianForMahasiswa($_GET['mhsId'], $_GET['ujiKelayakanId']);

        $mahasiswaName  = $this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($_GET['mhsId']))['full_name'];
        $mahasiswaNim  = $this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($_GET['mhsId']))['nim'];
        $mahasiswaImage  = $this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($_GET['mhsId']))['images'];

        $data['mahasiswa_id'] = $this->classesModel->encrypter($_GET['mhsId']);
        $data['mahasiswa_name'] = $mahasiswaName;
        $data['mahasiswa_nim'] = $mahasiswaNim;
        $data['mahasiswa_image'] = $this->classesModel->encrypter('/assets/upload/users/'.$mahasiswaImage);

        $dataSet = [];
        foreach ($resultData as $item) {
            $row = [];

            $row['id'] = $this->classesModel->encrypter($item->id);
            $row['uji_kelayakan_id'] = $this->classesModel->encrypter($item->uji_kelayakan_id);
            $row['dosen_id'] = $this->classesModel->encrypter($item->dosen_id);
            $row['dosen_name'] = $this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($item->dosen_id))['full_name'];
            $row['mahasiswa_id'] = $this->classesModel->encrypter($item->mahasiswa_id);
            $row['catatan_penilaian_kelayakan'] = $item->catatan_penilaian_kelayakan;
            $row['kesimpulan'] = $this->getKesimpulanText($item->kesimpulan);
            $row['kesimpulan_flag'] = $item->kesimpulan;
            $row['kesimpulan_dengan_catatan'] = $item->kesimpulan_dengan_catatan;

            $dataSet[] = $row;
        }

        $data['listDataPenilaianDosenForMahasiswa'] = $dataSet;

        if ($_GET['statusPenugasan'] == 1) {
            return $this->template->Frontend("hasil-penilaian-judul/component-view-hasil-penilaian-judul-hasil-penilaian-uji-kelayakan", $data);
        }

        if ($_GET['statusPenugasan'] == 2) {
            return $this->template->Frontend("hasil-penilaian-judul/component-view-hasil-penilaian-judul-hasil-penilaian-uji-kelayakan-final", $data);
        }
        
    }


    private function getKesimpulanText($value) {
        $text = '';
        if ($value == 1) {
            $text = 'Layak dilanjutkan ke Seminar Proposal';
        } else if ($value == 2) {
            $text = 'Layak dilanjutkan ke Seminar Proposal dengan Catatan';
        } else if ($value == 3) {
            $text = 'Tidak Layak harus ganti judul/tema baru';
        }

        return $text;
    }

    public function kirimSuratKelayakanJudul() {
        $data['mhsId']   = $_GET['mhsId'];
        $data['ujiKelayakanId'] = $_GET['ujiKelayakanId'];

        $resultDataFormUjiKelayakan = $this->HasilPenilaianJudulModel->getDataFormUjiKelayakanById($_GET['ujiKelayakanId']);

        $data['mahasiswa_name'] = $resultDataFormUjiKelayakan['nama'];
        $data['mahasiswa_nim'] = $resultDataFormUjiKelayakan['nim'];
        $data['mahasiswa_judul'] = $resultDataFormUjiKelayakan['judul'];
        $data['mahasiswa_images'] = $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilPenilaianJudulModel->getUserDataByNim($resultDataFormUjiKelayakan['nim'])['images']);

        return $this->template->Frontend("hasil-penilaian-judul/component-view-hasil-penilaian-kirim-surat-tugas-uji-kelayakan", $data);
    }


    public function insertKirimSuratKelayakanJudul() {
        $post = $this->request->getVar();
        
        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->HasilPenilaianJudulModel->insertDataSuratKelayakanJudul($__data);

        return $this->response->setJson($resultData);
    }

    public function getDataPenugasanDosenPembimbing() {
        $userId = $this->session->user_logged['id'];
        $rules  = $this->session->user_logged['rules'];
        $data = [];

        $result = $this->HasilPenilaianJudulModel->getPenugasanDosenPembimbing($this->classesModel->encrypter($_GET['formulirId']));

        foreach ($result as $item) {
            $row = [];

            $row['penugasan_id'] = $this->classesModel->encrypter($item->id);
            $row['formulir_uji_kelayakan_id'] = $this->classesModel->encrypter($item->formulir_uji_kelayakan_id);
            $row['kaprodi_id'] = $this->classesModel->encrypter($item->kaprodi_id);  
            $row['dosen_id']   = $this->classesModel->encrypter($item->dosen_id);  
            $row['nama_dosen'] = $this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($item->dosen_id))['full_name'];  
            $row['dosen_images'] = array(
                'images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($item->dosen_id))['images']),
                'thumbnail_images' => $this->classesModel->encrypter('/assets/upload/users/'.$this->HasilPenilaianJudulModel->getUserData($this->classesModel->encrypter($item->dosen_id))['thumbnail_images'])
            );
            $row['type_penugasan'] = $item->type_penugasan;
            $row['rules'] = $rules;

            $data[] = $row;
        }
        return $this->response->setJson($data);
    }

    public function addSuratTugasPembimbing() {
        $post = $this->request->getVar();
        $resultData = '';

        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->HasilPenilaianJudulModel->addSuratTugasPembimbing($__data);

        return $this->response->setJson($resultData);
    }

    public function ApprovePenilaianUjiKelayakan() {
        $post = $this->request->getVar();
        $resultData = '';

        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->HasilPenilaianJudulModel->approveHasilPenilaianJudul($__data);

        return $this->response->setJson($resultData);
    }

    public function NotApprovePenilaianUjiKelayakan() {
        $post = $this->request->getVar();
        $resultData = '';

        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->HasilPenilaianJudulModel->notApproveHasilPenilaianJudul($__data);

        return $this->response->setJson($resultData);
    }

}
