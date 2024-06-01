<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= SITE_NAME; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/vendor/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/vendor/animate/animate.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/vendor/css-hamburgers/hamburgers.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/vendor/animsition/css/animsition.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/vendor/select2/select2.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/login/vendor/daterangepicker/daterangepicker.css') ?>">
  <link rel="stylesheet" href="<?= base_url('modules/style/frontend/login/util.css') ?>">
  <link rel="stylesheet" href="<?= base_url('modules/style/frontend/login/main.css') ?>">
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    button.close {
      padding: 13px !important;
    }

    .label-input100 {
      top: 14px;
      font-size: 13px;
    }
    input::placeholder {
        font-size: 13px;
    }
  </style>
</head>
<body style="background-color: #666666;">
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form class="login100-form validate-form" action="<?= site_url('login/auth'); ?>" method="post">
          <div class="text-center">
            <img class="bg-side-left" src="<?= base_url('assets/frontend/system/logo.png'); ?>" style="width: 138px; height: 161px;">
          </div>
          <span class="login100-form-title p-b-43">
            <div class="text-blue">Penilaian Akhir Mahasiswa</div>
            <div class="text-orange">Pendidikan Teknik Elektro</div>
            <div class="m-t-30">Silahkan Login</div>
          </span>
          <?php if(session()->getFlashdata('login_error')) : ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('login_error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php session()->getFlashdata('login_error'); ?>
          <?php endif;?>
          <div class="wrap-input100 validate-input" data-validate = "Valid nim is required only number" p>
            <input class="input100" type="text" name="nim" placeholder="Tulis NIM/Email anda...">
            <span class="focus-input100"></span>
            <span class="label-input100">Username</span>
          </div>
          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="password" autocomplete="off" placeholder="Tulis Password anda...">
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
          </div>
          <!-- <div class="g-recaptcha" data-sitekey="<#?= env('RECAPTCHAV2_SITEKEY') ?>"></div> -->
          <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div>
             <!--  <a href="#" class="txt1">
                Forgot Password?
              </a> -->
              &nbsp;
            </div>
          </div>
          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
              Login
            </button>
          </div>  
        </form>
        <div class="login100-more">
          <img class="bg-side-left" src="<?= base_url('assets/frontend/login/bg.png'); ?>" width="100%">
        </div>
      </div>
    </div>
  </div>
  
  <script src="<?= base_url('assets/frontend/login/vendor/jquery/jquery-3.2.1.min.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/animsition/js/animsition.min.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/bootstrap/js/popper.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/select2/select2.min.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/daterangepicker/moment.min.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/daterangepicker/daterangepicker.js') ?>"></script>
  <script src="<?= base_url('assets/frontend/login/vendor/countdowntime/countdowntime.js') ?>"></script>
  <script src="<?= base_url('modules/script/frontend/login/main.js'); ?>"></script>

</body>
</html>