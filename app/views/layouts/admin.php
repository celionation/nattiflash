<?php


use Core\Config;

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
    <script src="<?= ROOT ?>app/assets/vendor/ckeditor5/ckeditor.js"></script>
    <title><?= $this->getSiteTitle(); ?> | NattiFlash</title>
    <?php $this->content('head') ?>
    <script>
        import {ClassicEditor} from "../../assets/vendor/ckeditor5/ckeditor";

        window.addEventListener('load', function() {
            ClassicEditor
                .create(document.querySelector('#body'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }

        .is-invalid+.ck-editor .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: crimson;
        }

        button[type='submit'] {
            cursor: pointer;
        }
    </style>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?= $this->components('admin/Navbar') ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?= $this->components('admin/Crumbs') ?>
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