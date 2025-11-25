<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->getTitle() ?></title>
    <link rel="stylesheet" type="text/css"   href="<?= ROOT ?>assets/css/style.css">
    <?php $style_file = $this->getStyle(); if(isset($style_file)): ?>
    <link rel="stylesheet" type="text/css"   href="<?= ROOT ?>assets/css/<?= $style_file ?>.css">
    <?php endif; ?>
    <meta id="logged-in" name="logged-in" content="<?= Middleware::isLoggedIn() ? "true" : "false" ?>">
</head>
<body>