<?php
requireConnectUser();

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/level.php';

if (!empty($_POST)) {
    // --- Validation (placer dans ton if (!empty($_POST)) ) ---
    $name  = isset($_POST['name'])  ? trim((string) $_POST['name'])  : '';
    $alias = isset($_POST['alias']) ? trim((string) $_POST['alias']) : '';

    $errors = [];

    $namePattern  = '/^[\p{L}0-9 \-\'’]{2,50}$/u'; // lettres (accents), chiffres, espace, - ' ’
    $aliasPattern  = '/^[\p{L}0-9 \-\'’]{2,10}$/u'; // lettres (accents), chiffres, espace, - ' ’

    // présence
    if ($name === '') {
        $errors['name'] = 'Le nom est requis.';
    }
    if ($alias === '') {
        $errors['alias'] = "L'alias est requis.";
    }

    // format/longueur name
    if ($name !== '') {
        $len = mb_strlen($name);
        if ($len < 2 || $len > 50) {
            $errors['name'] = 'Le nom doit contenir entre 2 et 50 caractères.';
        } elseif (!preg_match($namePattern, $name)) {
            $errors['name'] = 'Le nom contient des caractères non autorisés.';
        }
    }

    // format/longueur alias
    if ($alias !== '') {
        $len = mb_strlen($alias);
        if ($len < 2 || $len > 10) {
            $errors['alias'] = "L'alias doit contenir entre 2 et 10 caractères.";
        } elseif (!preg_match($aliasPattern, $alias)) {
            $errors['alias'] = "L'alias contient des caractères non autorisés.";
        }
    }

    // unicité (exclure l'enregistrement courant)
    // suppose que getPdo() existe et que $levelId contient l'id en cours (ou null pour création)
    if (empty($errors)) {
        // vérifier name
        if (findLevelIfExist('name', $name)) {
            $errors['name'] = 'Ce nom est déjà utilisé par une autre classe.';
        }

        // vérifier alias
        if (findLevelIfExist('alias', $alias)) {
            $errors['alias'] = "Cet alias est déjà utilisé par une autre classe.";
        }
    }

    if (!empty($errors)) {
        addInputErrors($errors);
        saveOldInputs($_POST);
        redirect(route('level.create'));
    } else {
        $state = createLevel(compact('name', 'alias'));

        $state 
            ? flashMessage("success", "classe créée avec succès.")
            : flashMessage("danger", "Impossible de créer la classe.");

        clearOldInputs();
        clearErrorsInputs();

        redirect(route('level.index'));

    }
}