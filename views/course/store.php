<?php 
require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/course.php';
require BASE_PATH . '/queries/level.php';

if (!empty($_POST)) {
    $name     = isset($_POST['name'])     ? trim((string) $_POST['name'])     : '';
    $credits  = isset($_POST['credits'])  ? trim((string) $_POST['credits'])  : '';
    $level_id = isset($_POST['level_id']) ? trim((string) $_POST['level_id']) : '';

    $errors = [];

    // Patterns
    $namePattern    = '/^[\p{L}0-9 \-\'’]{2,50}$/u'; // lettres, chiffres, espace, - ' ’
    $creditsPattern = '/^\d{1,2}$/';                 // 1 à 2 chiffres (tu peux ajuster)

    // --- Validation présence ---
    if ($name === '') {
        $errors['name'] = 'Le nom est requis.';
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

    // --- Unicité ---
    if (empty($errors)) {
        if (findCourseIfExist('name', $name, null)) {
            $errors['name'] = 'Ce nom de cours est déjà utilisé dans cette classe.';
        }
    }

    if (!empty($errors)) {
        addInputErrors($errors);
        saveOldInputs($_POST);
        redirect(route('course.create'));
    } else {
        $state = createCourse(compact('name', 'credits', 'level_id'));

        $state 
            ? flashMessage("success", "Cours créé avec succès.")
            : flashMessage("danger", "Impossible de créer le cours.");

        clearOldInputs();
        clearErrorsInputs();

        redirect(route('course.index'));
    }
}
