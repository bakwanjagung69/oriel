<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color: #ffffff;">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Search -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <!-- <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
            </a> -->
            <!-- Dropdown - Alerts -->
            <!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div> -->
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="<?= base_url('/files/loaderImg?loader=loader-image') ?>" data-src="<?= base_url('/files/images?q='.session()->get('user_logged')['thumbnail_images']); ?>" class="img-profile rounded-circle lazy-load-img-avatar" alt="User Image">&nbsp;&nbsp;&nbsp;
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="min-width: 70px;">
                    <div><?= ucfirst(session()->get('user_logged')['full_name']); ?></div>
                    <div>
                        <small class="badge badge-secondary"><?php
                            if (session()->get('user_logged')['rules'] == 1) {
                                echo 'Administrator';
                            } else if (session()->get('user_logged')['rules'] == 2) {
                                echo 'Admin';
                            } else if (session()->get('user_logged')['rules'] == 3) {
                                echo 'Dosen';
                            } else if (session()->get('user_logged')['rules'] == 4) {
                                echo 'Kaprodi';
                            } else if (session()->get('user_logged')['rules'] == 5) {
                                echo 'Mahasiswa';
                            }
                        ?></small>
                    </div>
                </span>
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('changePassword'); ?>">
                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                    Lupa Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" id="logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>