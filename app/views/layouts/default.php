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

<script src="<?= ROOT ?>app/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
