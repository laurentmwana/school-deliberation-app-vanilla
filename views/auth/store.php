<?php
userAlreadyConnect();


require BASE_PATH . '/queries/auth.php'; // tu devrais avoir une fonction pour trouver un user

// Récupération des données du formulaire
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validation basique
if ($username === '' || $password === '') {
    flashMessage("danger", "Veuillez remplir tous les champs.");
    redirect(route("auth.login"));
    exit;
}

// Recherche de l'utilisateur par username
$user = findUserBy('username', $username);

if (! $user) {
    flashMessage("danger", "Aucun utilisateur trouvé avec cet username.");
    redirect(route("auth.login"));
    exit;
}

// Vérification du mot de passe
if (! password_verify($password, $user['password'])) {
    flashMessage("danger", "Mot de passe incorrect.");
    redirect(route("auth.login"));
    exit;
}

// Authentification réussie → enregistre la session
saveUserToSession([
    'id' => $user['id'],
    'username' => $user['username'],
]);

flashMessage("success", "Bienvenue, {$user['username']} !");

redirect(route("home"));
