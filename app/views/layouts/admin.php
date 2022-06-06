<?php


use Core\Config;
use core\Session;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('/app/assets/img/favicon.png') ?>">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/css/all.css">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/vendor/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/vendor/datatables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/css/admin/sb-admin.css">
    <title><?= $this->getSiteTitle(); ?> | NattiFlash</title>
    <?php $this->content('head') ?>

    <style>
        ::selection{
            background: #000;
            color: #fff;
        }
        .nav-item a:hover{
            color: #111 !important;
            background-color: #F1F1F1 !important;
        }
        .active{
            color: #111 !important;
            background-color: #F1F1F1 !important;
        }
        button[type='submit'],
        button{
            cursor: pointer;
        }
    </style>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?= $this->components('admin/Navbar') ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?= $this->components('admin/Crumbs') ?>
        <?= Session::displaySessionAlerts(); ?>
        <?php $this->content('content') ?>
        <?= $this->components('admin/Footer') ?>
    </div>
</div>

<script type="application/javascript" src="<?= asset('/app/assets/vendor/jquery/jquery.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/vendor/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/vendor/datatables/jquery.dataTables.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/vendor/datatables/dataTables.bootstrap4.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/js/admin/sb-admin.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/js/admin/sb-admin-datatables.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/js/admin/sb-admin-charts.min.js') ?>"></script>
<script type="application/javascript" src="<?= asset('/app/assets/js/all.js') ?>"></script>
</body>
</html>