<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? "Welcome" ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= rtrim(BASE_RESOURCE, '/') ?>/bootstrap/css/bootstrap.min.css">

    <!-- Fichier CSS custom -->
    <link rel="stylesheet" href="<?= rtrim(BASE_RESOURCE, '/') ?>/app.css">

    <!-- Exemple d’image dans le head (favicon) -->
    <!-- <link rel="icon" href="<?= rtrim(BASE_RESOURCE, '/') ?>/images/logo.png" type="image/png"> -->

    <!-- JS de Bootstrap et dépendances -->
    <script src="<?= rtrim(BASE_RESOURCE, '/') ?>/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="<?= rtrim(BASE_RESOURCE, '/') ?>/bootstrap/js/bootstrap.min.js" defer></script>

    <!-- Fichier JS custom -->
    <script src="<?= rtrim(BASE_RESOURCE, '/') ?>/app.js" defer></script>
</head>
<body>
