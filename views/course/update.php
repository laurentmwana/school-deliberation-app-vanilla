<?php
requireConnectUser();

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/course.php';
require BASE_PATH . '/queries/level.php';

$courseId = $routeParams["id"] ?? null;

if ($courseId === null) {
    throw new \Exception("Nous n'avons pas pu trouver le cours avec l'ID fourni.");
}

$course = findCourseById($courseId);

if (!$course) {
    throw new \Exception("Nous n'avons pas pu trouver le cours avec l'ID fourni.");
}

if (!empty($_POST)) {
    $name     = isset($_POST['name'])     ? trim((string) $_POST['name'])     : '';
    $credits  = isset($_POST['credits'])  ? trim((string) $_POST['credits'])  : '';
    $level_id = isset($_POST['level_id']) ? trim((string) $_POST['level_id']) : '';

    $errors = [];

    // Patterns
    $namePattern    = '/^[\p{L}0-9 \-\'’]{2,50}$/u'; // lettres, chiffres, espace, - ' ’
    $creditsPattern = '/^\d{1,2}$/';                 // 1 à 2 chiffres

    // --- Validation présence ---
    if ($name === '') {
        $errors['name'] = 'Le nom du cours est requis.';
    }
    if ($credits === '') {
        $errors['credits'] = 'Le nombre de crédits est requis.';
    }
    if ($level_id === '') {
        $errors['level_id'] = 'La classe associée est requise.';
    }

    // --- Validation format/longueur ---
    if ($name !== '' && !preg_match($namePattern, $name)) {
        $errors['name'] = 'Le nom contient des caractères non autorisés ou n’est pas valide.';
    }

    if ($credits !== '' && !preg_match($creditsPattern, $credits)) {
        $errors['credits'] = 'Le nombre de crédits doit être un entier valide.';
    }

    // --- Unicité (exclure l'enregistrement courant) ---
    if (empty($errors)) {
        if (findCourseIfExist('name', $name, $courseId, $level_id)) {
            $errors['name'] = 'Ce nom de cours est déjà utilisé dans cette classe.';
        }
    }

    if (!empty($errors)) {
        addInputErrors($errors);
        saveOldInputs($_POST);
        redirect(route('course.edit', ['id' => $courseId]));
    } else {
        $state = updateCourse($courseId, compact('name', 'credits', 'level_id'));

        $state 
            ? flashMessage("success", "Cours modifié avec succès.")
            : flashMessage("danger", "Impossible de modifier le cours.");

        clearOldInputs();
        clearErrorsInputs();

        redirect(route('course.index'));
    }
}
