<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SuratTugas\SuratTugasModel;
use App\Models\SuratTugas\SuratTugasPembimbingModel;
use App\Models\ClassesModel;
use Config\Services;

class SuratTugas extends BaseController {
    protected $classesModel;
    protected $SuratTugasModel;
    protected $SuratTugasPembimbingModel;
    protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->SuratTugasModel = new SuratTugasModel();
        $this->SuratTugasPembimbingModel = new SuratTugasPembimbingModel();
        $this->request = Services::request();
        $this->session = \Config\Services::session();

        /** Check if not login */
        $this->classesModel->checkIsNotLogin();
    }

    public function index() {
        // $data['uri'] = $this->request->uri->getSegments();
        $getDataMasterSemester = $this->classesModel->getDataMasterSemester();
        $data['master_semester'] = $getDataMasterSemester;

        return $this->template->Frontend("surat-tugas/component-view-surat-tugas", $data);
    }

    public function getdata() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->SuratTugasModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $mhsId  = $this->classesModel->encrypter($this->SuratTugasModel->getUserData($this->classesModel->encrypter($list->mahasiswa_id))['id']);
                $mhsNim = $this->SuratTugasModel->getUserData($this->classesModel->encrypter($list->mahasiswa_id))['nim'];
                $dataFormUjiKelayakanMhs = $this->SuratTugasModel->getDataFormUjiKelayakanByNim($this->classesModel->encrypter($mhsNim));

                $no++;
                $row = [];
                $row['id'] = $_ids;
                $row['uji_kelayakan_id'] = $this->classesModel->encrypter($list->uji_kelayakan_id);
                $row['assigment_from_user_id'] = $this->classesModel->encrypter($list->assigment_from_user_id);
                $row['assigment_from_username'] = $this->SuratTugasModel->getUserData($this->classesModel->encrypter($list->assigment_from_user_id))['full_name'];

                $row['assigment_to_user_id'] = $this->classesModel->encrypter($list->assigment_to_user_id);
                $row['assigment_to_username'] = $this->SuratTugasModel->getUserData($this->classesModel->encrypter($list->mahasiswa_id))['full_name'];
                $row['mahasiswa_id'] = $mhsId;
                $row['mahasiswa_nim'] = $mhsNim;
                $row['mahasiswa_proposal_file_form_uji_kelayakan'] = $this->classesModel->encrypter('/assets/upload/uji-kelayakan/'.$dataFormUjiKelayakanMhs['files']);
                $row['mahasiswa_hasil_penilaian_result'] = $this->SuratTugasModel->checkDataHasilForMahasiswa($mhsId, $this->classesModel->encrypter($list->uji_kelayakan_id));

                $row['judul'] = $list->judul;                                
                $row['createDate'] = date("d M Y", strtotime($list->createDate)); 
                $row['surat_tugas_to_mahasiswa_files'] = $this->classesModel->encrypter('/assets/upload/surat-tugas/'.$list->surat_tugas_to_mahasiswa_files);
                $row['surat_tugas_to_dosen_files'] = $this->classesModel->encrypter('/assets/upload/surat-tugas/'.$list->surat_tugas_to_dosen_files);
                $row['status'] = $list->status;
                $row['semester'] = $dataFormUjiKelayakanMhs['semester'];
               
                $data[] = $row;
            }

            $setData = [];
            if (!empty($dataFormUjiKelayakanMhs)) {
                if ($dataFormUjiKelayakanMhs['semester'] == $this->request->getPost('semester')) {
                    for ($i = 0; $i < count($data); ++$i) {
                        if ($data[$i]['semester'] == $this->request->getPost('semester')) {
                            array_push($setData, $data[$i]);
                        }
                    }
                } else {
                    if ($this->request->getPost('semester') == '') {
                        $setData = $data;
                    } else {
                        $setData = [];
                    }
                }
            } else {
                $setData = $data;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => (!empty($setData) ? $this->SuratTugasModel->countAll() : ''),
                'recordsFiltered' => (!empty($setData) ? $this->SuratTugasModel->countFiltered() : ''),
                'data' => $setData
            ];
        }
        return $this->response->setJson($output);
    }

    public function getdataPembimbing() {
        /** Check if not login */
        $this->classesModel->checkIsNotLogin();

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->SuratTugasPembimbingModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $_ids = $this->classesModel->encrypter($list->id);
                $mhsId  = $this->classesModel->encrypter($this->SuratTugasPembimbingModel->getUserData($this->classesModel->encrypter($list->mahasiswa_id))['id']);
                $mhsNim = $this->SuratTugasPembimbingModel->getUserData($this->classesModel->encrypter($list->mahasiswa_id))['nim'];
                $dataFormUjiKelayakanMhs = $this->SuratTugasPembimbingModel->getDataFormUjiKelayakanByNim($this->classesModel->encrypter($mhsNim));

                $no++;
                $row = [];
                $row['id'] = $_ids;
                $row['uji_kelayakan_id'] = $this->classesModel->encrypter($list->uji_kelayakan_id);
                $row['assigment_from_user_id'] = $this->classesModel->encrypter($list->assigment_from_user_id);
                $row['assigment_from_username'] = $this->SuratTugasPembimbingModel->getUserData($this->classesModel->encrypter($list->assigment_from_user_id))['full_name'];

                $row['assigment_to_user_id'] = $this->classesModel->encrypter($list->assigment_to_user_id);
                $row['assigment_to_username'] = $this->SuratTugasPembimbingModel->getUserData($this->classesModel->encrypter($list->mahasiswa_id))['full_name'];
                $row['mahasiswa_id'] = $mhsId;
                $row['mahasiswa_nim'] = $mhsNim;
                $row['mahasiswa_proposal_file_form_uji_kelayakan'] = $this->classesModel->encrypter('/assets/upload/uji-kelayakan/'.$dataFormUjiKelayakanMhs['files']);
                $row['mahasiswa_hasil_penilaian_result'] = $this->SuratTugasPembimbingModel->checkDataHasilForMahasiswa($mhsId, $this->classesModel->encrypter($list->uji_kelayakan_id));

                $row['judul'] = $list->judul;                                
                $row['createDate'] = date("d M Y", strtotime($list->createDate)); 
                $row['surat_tugas_to_mahasiswa_files'] = $this->classesModel->encrypter('/assets/upload/surat-tugas-bimbingan/'.$list->surat_tugas_to_mahasiswa_files);
                $row['surat_tugas_to_dosen_files'] = $this->classesModel->encrypter('/assets/upload/surat-tugas-bimbingan/'.$list->surat_tugas_to_dosen_files);
                $row['semester'] = $dataFormUjiKelayakanMhs['semester'];
               
                $data[] = $row;
            }

            $setData = [];
            if (!empty($dataFormUjiKelayakanMhs)) {
                if ($dataFormUjiKelayakanMhs['semester'] == $this->request->getPost('semester')) {
                    for ($i = 0; $i < count($data); ++$i) {
                        if ($data[$i]['semester'] == $this->request->getPost('semester')) {
                            array_push($setData, $data[$i]);
                        }
                    }
                } else {
                    if ($this->request->getPost('semester') == '') {
                        $setData = $data;
                    } else {
                        $setData = [];
                    }
                }
            } else {
                $setData = $data;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => (!empty($setData) ? $this->SuratTugasPembimbingModel->countAll() : ''),
                'recordsFiltered' => (!empty($setData) ? $this->SuratTugasPembimbingModel->countFiltered() : ''),
                'data' => $setData
            ];

        }
        return $this->response->setJson($output);
    }

    public function penilaianForm() {
        $data['dosenId'] = $_GET['dosenId'];
        $data['mhsId']   = $_GET['mhsId'];
        $data['ujiKelayakanId'] = $_GET['ujiKelayakanId'];
        $data['status'] = $_GET['status'];
        
        $data['catatan_penilaian_kelayakan'] = '';
        $data['kesimpulan'] = '';
        $data['kesimpulan_dengan_catatan'] = '';

        if ($_GET['status'] == '7') { // Status 7 (Selesai)
            return $this->template->Frontend("surat-tugas/component-view-surat-tugas-penilaian", $data);
        } else {
            $resultData = $this->SuratTugasModel->getDataHasilPenilaianForDosen($_GET['dosenId'], $_GET['ujiKelayakanId']);
            $data['catatan_penilaian_kelayakan'] = (!empty($resultData['catatan_penilaian_kelayakan']) ? $resultData['catatan_penilaian_kelayakan'] : '');
            $data['kesimpulan'] = (!empty($resultData['kesimpulan']) ? $resultData['kesimpulan'] : '');
            $data['kesimpulan_dengan_catatan'] = (!empty($resultData['kesimpulan_dengan_catatan']) ? $resultData['kesimpulan_dengan_catatan'] : '');
            return $this->template->Frontend("surat-tugas/component-view-surat-tugas-penilaian", $data);
        }
        
    }

    public function insertPenilaian() {
        $post = $this->request->getVar();

        $__data = array(
            "items" => $post,
            "files" => $_FILES
        );

        $resultData = $this->SuratTugasModel->insertPenilaianUjiKelayakan($__data);
        return $this->response->setJson($resultData);
    }

    public function hasilPenilaian() {
        $data['mhsId']   = $_GET['mhsId'];
        $data['ujiKelayakanId'] = $_GET['ujiKelayakanId'];

        $resultData = $this->SuratTugasModel->getDataHasilPenilaianForMahasiswa($_GET['mhsId'], $_GET['ujiKelayakanId']);

        $dataSet = [];
        foreach ($resultData as $item) {
            $row = [];

            $row['id'] = $this->classesModel->encrypter($item->id);
            $row['uji_kelayakan_id'] = $this->classesModel->encrypter($item->uji_kelayakan_id);
            $row['dosen_id'] = $this->classesModel->encrypter($item->dosen_id);
            $row['dosen_name'] = $this->SuratTugasModel->getUserData($this->classesModel->encrypter($item->dosen_id))['full_name'];
            $row['mahasiswa_id'] = $this->classesModel->encrypter($item->mahasiswa_id);
            $row['catatan_penilaian_kelayakan'] = $item->catatan_penilaian_kelayakan;
            $row['kesimpulan'] = $this->getKesimpulanText($item->kesimpulan);
            $row['kesimpulan_flag'] = $item->kesimpulan;
            $row['kesimpulan_dengan_catatan'] = $item->kesimpulan_dengan_catatan;

            $dataSet[] = $row;
        }

        $data['listDataPenilaianDosenForMahasiswa'] = $dataSet;

        return $this->template->Frontend("surat-tugas/component-view-surat-tugas-hasil-penilaian-uji-kelayakan", $data);
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

}
