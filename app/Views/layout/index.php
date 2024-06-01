<!DOCTYPE html>
<html lang="en">
<head><?= $header; ?></head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?= $mainSidebar; ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #EBEFF7;">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?= $mainHeader; ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid"><?= $content; ?></div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?= $footer; ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- [END] - Scroll to Top Button-->
</body>
</html>