<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= SITE_NAME; ?></title>
  <link href="<?= base_url('/files/favicon'); ?>" type="image/x-icon" rel="icon">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/cms/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/cms/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/cms/bower_components/Ionicons/css/ionicons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/cms/dist/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/cms/plugins/iCheck/square/blue.css') ?>">
  <link rel="stylesheet" href="<?= base_url('modules/style/cms/login/login.css') ?>">
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:void(0);"><b><?= SITE_NAME; ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in</p>
    <?php if(session()->getFlashdata('login_error')) : ?>
      <div class="alert alert-warning" role="alert">
          <?= session()->getFlashdata('login_error') ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    <?php session()->getFlashdata('login_error'); ?>
    <?php endif;?>
    <form action="<?= site_url('admin/login/auth'); ?>" method="post">
      <div class="form-group has-feedback">
      	<!-- <label>Email</label> -->
        <input type="text" name="emailOrUsername" class="form-control" placeholder="Email or Username" autocomplete="off">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
        <span toggle="#password-field" class="fa fa-fw fa-eye fa-eye-slash field-icon toggle-password"></span>
      </div>
      <div class="g-recaptcha" data-sitekey="<?= env('RECAPTCHAV2_SITEKEY') ?>"></div>
      <br />
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<script src="<?= base_url('assets/cms/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('modules/script/cms/login/login.js'); ?>"></script>
<script src="<?= base_url('assets/cms/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/cms/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/cms/plugins/iCheck/icheck.min.js'); ?>"></script>
</body>
</html>