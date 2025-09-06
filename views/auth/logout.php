<?php
requireConnectUser();

require BASE_PATH . '/queries/auth.php'; // doit contenir la logique de déconnexion (si besoin)

// Si on soumet le formulaire (par exemple bouton "Se déconnecter")
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireDisconnectUser(); // détruit la session + redirige
}
