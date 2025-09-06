<?php
requireConnectUser();

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/student.php';
require BASE_PATH . '/queries/level.php';

if (!empty($_POST)) {
    $name      = isset($_POST['name'])      ? trim((string) $_POST['name'])      : '';
    $firstname = isset($_POST['firstname']) ? trim((string) $_POST['firstname']) : '';
    $gender    = isset($_POST['gender'])    ? trim((string) $_POST['gender'])    : '';
    $level_id  = isset($_POST['level_id'])  ? trim((string) $_POST['level_id'])  : '';

    $errors = [];

    // --- Patterns ---
    $namePattern      = '/^[\p{L} \-\'’]{2,50}$/u'; // lettres, espace, - '
    $firstnamePattern = '/^[\p{L} \-\'’]{2,50}$/u'; // idem
    $genderValues     = ['M', 'F'];

    // --- Validation présence ---
    if ($name === '') {
        $errors['name'] = 'Le nom est requis.';
    }
    if ($firstname === '') {
        $errors['firstname'] = 'Le postnom est requis.';
    }
    if ($gender === '') {
        $errors['gender'] = 'Le genre est requis.';
    }
    if ($level_id === '') {
        $errors['level_id'] = 'La classe est requise.';
    }

    // --- Validation format ---
    if ($name !== '' && !preg_match($namePattern, $name)) {
        $errors['name'] = 'Le nom contient des caractères non autorisés.';
    }
    if ($firstname !== '' && !preg_match($firstnamePattern, $firstname)) {
        $errors['firstname'] = 'Le postnom contient des caractères non autorisés.';
    }
    if ($gender !== '' && !in_array($gender, $genderValues, true)) {
        $errors['gender'] = 'Le genre doit être Masculin ou Féminin.';
    }

    if (!empty($errors)) {
        addInputErrors($errors);
        saveOldInputs($_POST);
        redirect(route('student.create'));
    } else {
        $state = createStudent(compact('name', 'firstname', 'gender', 'level_id'));

        $state
            ? flashMessage("success", "Étudiant créé avec succès.")
            : flashMessage("danger", "Impossible de créer l’étudiant.");

        clearOldInputs();
        clearErrorsInputs();

        redirect(route('student.index'));
    }
}
