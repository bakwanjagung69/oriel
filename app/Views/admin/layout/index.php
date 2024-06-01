<!DOCTYPE html>
<html lang="en">
<head>
  <?= $header; ?>
</head>

<!-- Loaders -->
<div id="loadedLoader__" style="width: 100%;height:100%;z-index: 100111;background: #000;opacity: 0.60;position: fixed;top: 0;left: 0;">
    <div id="loader-overlay">
        <div class="loaderCss"></div>
        <div class="loaders">Loading...</div>
    </div>
</div>
<!-- [END] - Loaders -->

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?= $mainHeader; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?= $mainSidebar; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= $breadcrumb; ?>
    <!-- Main content -->
    <section class="content">
      <?= $content; ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?= $footer; ?>
  <?= $controlSidebar; ?>
</div>
<!-- ./wrapper -->
</body>
</html>
