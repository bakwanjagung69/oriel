<ul class="navbar-nav white sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('/files/loaderImg?loader=loader-image') ?>" data-src="<?= base_url('assets/frontend/system/logo.png'); ?>" style="width: 50 px; height: 50px;" class="rounded lazy-load-img-avatar" alt="image-logo">
            <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3" style="font-size: 10px; color: #FF771F;">Pendidikan Teknik Elektro</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-12">
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading"></div>

    <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '3', '4'])) { ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active" >
        <a class="nav-link" href="<?= base_url(); ?>" style="color: #0A3965;">
            <i class="fas fa-fw fa-home" style="color: #0A3965;"></i>
            <span>Home</span>
        </a>
    </li>
    <?php if (in_array(session()->get('user_logged')['rules'], ['1'])) { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
            aria-expanded="true" aria-controls="collapseMaster" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-list-ul" style="color: #A6A6A6;"></i>
            <span>Master</span>
        </a>
        <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub Menu:</h6>
                <a class="collapse-item" href="<?= base_url('users'); ?>">Users</a>
                <a class="collapse-item" href="<?= base_url('semester'); ?>">Semester</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2'])) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('inputJadwal'); ?>" style="color: #A6A6A6;">
            <i class="fas fa-fw fa-calendar-check-o" style="color: #A6A6A6;"></i>
            <span>Input Jadwal</span>
        </a>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['1', '4', '2'])) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('listPendaftaran'); ?>" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-book" style="color: #A6A6A6;"></i>
            <span>Data Pendaftar</span>
        </a>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '3'])) { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNilai"
            aria-expanded="true" aria-controls="collapseNilai" style="color: #A6A6A6;">
            <i class="fas fa-fw fa-pencil-square-o" style="color: #A6A6A6;"></i>
            <span>Nilai</span>
        </a>
        <div id="collapseNilai" class="collapse" aria-labelledby="headingFolmulir"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub Menu:</h6>
                <?php if (in_array(session()->get('user_logged')['rules'], ['1', '4', '2', '3'])) { ?>
                    <a class="collapse-item" href="<?= base_url('hasilNilai'); ?>">Hasil Nilai</a>
                 <?php } ?>
                 <?php if (in_array(session()->get('user_logged')['rules'], ['1', '4', '3',])) { ?>
                    <a class="collapse-item" href="<?= base_url('inputNilai'); ?>">Input Nilai</a>
                 <?php } ?>
            </div>
        </div>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['3', '2', '5', '4'])) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('jadwalSidang'); ?>" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-calendar" style="color: #A6A6A6;"></i>
            <span>Jadwal Sidang</span>
        </a>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2'])) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('hasilPenilaianJudul'); ?>" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-id-card-o" style="color: #A6A6A6;"></i>
            <span style="font-size: 12.2px;">Hasil Penilaian Kelayakan Judul</span>
        </a>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['5'])) { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFormulir"
            aria-expanded="true" aria-controls="collapseFormulir" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-address-card-o" style="color: #A6A6A6;"></i>
            <span>Formulir</span>
        </a>
        <div id="collapseFormulir" class="collapse" aria-labelledby="headingFolmulir"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub Menu:</h6>
                <a class="collapse-item" href="<?= base_url('ujiKelayakan'); ?>">Uji Kelayakan</a>
                <a class="collapse-item" href="<?= base_url('sup'); ?>">SUP</a>
                <a class="collapse-item" href="<?= base_url('skripsi'); ?>">Skripsi</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['5', '3'])) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('suratTugas'); ?>" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-envelope-o" style="color: #A6A6A6;"></i>
            <span>Surat Tugas</span>
        </a>
    </li>
    <?php } ?>
    <?php if (in_array(session()->get('user_logged')['rules'], ['4'])) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('inputNamaDosenPembimbing'); ?>" style="color: #A6A6A6;">
            <i class="fas fa-fw fa fa-users" style="color: #A6A6A6;"></i>
            <span style="font-size: 11.2px;">Input Nama Dosen Pembimbing</span>
        </a>
    </li>
    <?php } ?>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline" style="margin-top: 20px;">
        <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgba(90,92,105,.5);"></button>
    </div>
</ul>