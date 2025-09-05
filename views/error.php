<?php 
$title = "Un problème est survenue";

require 'inc/header.php'; ?>

<div class="container text-center mt-5">
    <h1 class="display-1 text-danger">Un problème est survenue</h1>
    <h2 class="mb-4">Page Not Found</h2>
    <p class="lead">
        <?= $errorMessage ?>
    </p>
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
</div>

<?php require 'inc/footer.php'; ?>
