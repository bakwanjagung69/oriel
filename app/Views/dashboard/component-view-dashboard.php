<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;"><i class="fa fa-home" aria-hidden="true"></i> Home</h1>
</div>
<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">Selamat Datang <span style="font-weight: 700;"><?= ucfirst(session()->get('user_logged')['full_name']); ?></span>!</h4>
            <?php if (session()->get('user_logged')['rules'] == 1) { ?>
                <!-- Administrator -->
                <p>Di Sistem Penilaian Akhir Mahasiswa Pendidikan Teknik Elektro.</p>
            <?php } else if (session()->get('user_logged')['rules'] == 2) { ?>
                <!-- Admin -->
                <p>Di Sistem Penilaian Akhir Mahasiswa Pendidikan Teknik Elektro, pastikan kamu selalu mengecek "Data Pendaftar, Input Jadwal & Hasil Uji Kelayakan" untuk menginputkan data jadwal dan persetujuan document lainya.</p>
            <?php } else if (session()->get('user_logged')['rules'] == 3) { ?>
                <!-- Dosen -->
                <p>Di Sistem Penilaian Akhir Mahasiswa Pendidikan Teknik Elektro, pastikan kamu selalu mengecek "Surat Tugas & Jadwal Sidang" untuk menginputkan Nilai.</p>
            <?php } else if (session()->get('user_logged')['rules'] == 4) { ?>
                <!-- Kaprodi -->
                <p>Pastikan kamu selalu meriksa "Data Pendaftar" untuk penginputan data Penugasan Dosen.</p>
            <?php } else if (session()->get('user_logged')['rules'] == 5) { ?>
                <!-- Mahasiswa -->
                <p>Di Sistem Penilaian Akhir Mahasiswa Pendidikan Teknik Elektro, Semoga dapat membantu pada setiap kegiatan administrasi akademik anda.</p>
            <?php } ?>
          <hr>
          <p class="mb-0 font-italic small">Jika mengalami masalah pada sistem pengisian nilai, segera menghubungi Support (Pendidikan Elektro) UNJ – Universitas Negeri Jakarta.</p>
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><@?= $totalMahasiswa; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Dosen</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><@?= $totalDosen; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Your IP Address
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><$?= $_SERVER['REMOTE_ADDR']; ?></div>
                            </div>
                           <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div> -->
<!--                         </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa fa-rss fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<!--     <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total USER</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><@?= $totalUser ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Content Row -->
<!-- <div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold" style="color: #0F0F10;">Total Mahasiswa Lulus</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div> -->