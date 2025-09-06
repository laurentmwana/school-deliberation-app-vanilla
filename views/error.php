<?php 
$title = "Une erreur est survenue";
?>

<div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
    <!-- Icône ou gros chiffre -->
    <div class="mb-4">
        <span class="display-1 fw-bold text-danger">⚠️</span>
    </div>

    <!-- Titre principal -->
    <h1 class="display-4 text-danger mb-3">Oups ! Une erreur est survenue</h1>

    <!-- Sous-titre -->
    <h2 class="h5 text-muted mb-4">Page non trouvée ou problème interne</h2>

    <!-- Message d'erreur -->
    <p class="lead mb-4">
        <?= htmlspecialchars($errorMessage ?? "Erreur inconnue.") ?>
    </p>

    <!-- Bouton retour -->
    <a href="/" class="btn btn-lg btn-primary">
        <i class="bi bi-house-door-fill"></i> Retour à l'accueil
    </a>
</div>