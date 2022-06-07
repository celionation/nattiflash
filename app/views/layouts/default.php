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
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>app/assets/css/style.css?v=<?= Config::get('version') ?>">
    <title><?= $this->getSiteTitle(); ?> | NattiFlash</title>
    <?php $this->content('head') ?>
</head>
<body>
    <?= $this->components('mainMenu') ?>
<div>
    <?php $this->content('content') ?>
</div>

    <?= $this->components('mainFooter') ?>
    <script src="<?= ROOT ?>app/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT ?>app/assets/js/main.js"></script>
</body>
</html>
