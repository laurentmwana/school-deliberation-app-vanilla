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

    <!-- Fichier JS custom -->
    <script src="<?= rtrim(BASE_RESOURCE, '/') ?>/app.js" defer></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300i,400,400i,500,500i,600,600i,700,700i,800,800i,900|inter:100,400,700" rel="stylesheet" />
</head>
<body>

<!-- MENU DE NAVIGATIOn -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= route("home") ?>">SchoolDelibe</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= isMenuActive(route("home")) ? 'text-primary fw-semibold' : '' ?>" href="<?= route("home") ?>">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isMenuActive(route("level.index")) ? 'text-primary fw-semibold' : '' ?>" href="<?= route("level.index") ?>">Promotion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isMenuActive(route("year.index")) ? 'text-primary fw-semibold' : '' ?>" href="<?= route("year.index") ?>">Année</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isMenuActive(route("course.index")) ? 'text-primary fw-semibold' : '' ?>" href="<?= route("course.index") ?>">Cours</a>
        </li>
               <li class="nav-item">
          <a class="nav-link <?= isMenuActive(route("student.index")) ? 'text-primary fw-semibold' : '' ?>" href="<?= route("student.index") ?>">Étudiant</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Notes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Résultats</a>
        </li>
      </ul>

      <!-- Dropdown utilisateur connecté -->
      <?php if (hasUserConnect()): ?>
        <?php $user = getUserConnect(); ?>
        <form style="display: inline-block;" action="<?= route('auth.logout') ?>" onsubmit="return confirm('Voulez-vous vraimmnt effectuer cette action ?')" method="post">
          <button type="submit"  class="btn btn-sm btn-danger">
            Se déconnecter
          </button>
        </form>
      <?php else: ?>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="btn btn-sm btn-light" href="<?= route('auth.login') ?>">Se connecter</a>
          </li>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- END MENU -->