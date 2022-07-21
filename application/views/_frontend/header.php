<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/quill/quill.snow.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/quill/quill.bubble.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/remixicon/remixicon.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/simple-datatables/style.css">




    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/style.css">


    <script src="<?= base_url() ?>assets/bower_components/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/select2/js/select2.full.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/moment/min/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/mystyle.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <script type="text/javascript">
        let base_url = '<?= base_url() ?>';
    </script>
    <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
======================================================== -->
</head>

<body>


    <header>
        <?php require_once("menubar.php"); ?>
    </header>

    <!--Sidebar -->

    <?php require_once("sidebar.php"); ?>

    <!-- sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">



            <h1>
                <?= $judul ?>
                <small><?= $subjudul ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><?= $judul; ?></li>
                <li class="active"><?= $subjudul ?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content container-fluid">

            <main id="main" class="main">

                <div class="pagetitle">
                    <h1>
                        <?= $judul ?>
                        <small><?= $subjudul ?></small>
                    </h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><?= $judul; ?></li>
                            <li class="breadcrumb-item active"><?= $subjudul ?></li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->