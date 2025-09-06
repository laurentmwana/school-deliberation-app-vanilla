<?php
requireConnectUser();

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/student.php';
require BASE_PATH . '/queries/course.php';
require BASE_PATH . '/queries/note.php';
require BASE_PATH . '/queries/level.php';
require BASE_PATH . '/queries/year.php';

if (!empty($_POST)) {
    $student_id = isset($_POST['student_id']) ? trim((string) $_POST['student_id']) : '';
    $level_id   = isset($_POST['level_id'])   ? trim((string) $_POST['level_id'])   : '';
    $year_id    = isset($_POST['year_id'])    ? trim((string) $_POST['year_id'])    : '';
    $course_id  = isset($_POST['course_id'])  ? trim((string) $_POST['course_id'])  : '';
    $obtained   = isset($_POST['obtained'])   ? trim((string) $_POST['obtained'])   : '';

    $errors = [];

    // --- Validation présence ---
    if ($student_id === '') {
        $errors['student_id'] = 'L’étudiant est requis.';
    }
    if ($level_id === '') {
        $errors['level_id'] = 'La classe est requise.';
    }
    if ($year_id === '') {
        $errors['year_id'] = 'L’année scolaire est requise.';
    }
    if ($course_id === '') {
        $errors['course_id'] = 'Le cours est requis.';
    }
    if ($obtained === '') {
        $errors['obtained'] = 'La note obtenue est requise.';
    }

    // --- Validation format ---
    if ($obtained !== '' && !is_numeric($obtained)) {
        $errors['obtained'] = 'La note doit être un nombre.';
    } else {
        if ((int)$obtained < 0 || (int)$obtained > 20)  {
            $errors['obtained'] = 'Doit être entre 0 et 20';
        }
    }

    if (empty($errors)) {
        if (findNoteIfExist($student_id, $course_id, $year_id)) {
            $errors['obtained'] = 'Une note pour cet élève, ce cours et cette année existe déjà.';
        }
    }


    // --- Gestion des erreurs ---
    if (!empty($errors)) {
        addInputErrors($errors);
        saveOldInputs($_POST);
        redirect(route('note.create'));
    } else {
        // Création de la note
        $state = createNote(compact('student_id', 'level_id', 'year_id', 'course_id', 'obtained'));

        $state
            ? flashMessage("success", "Note créée avec succès.")
            : flashMessage("danger", "Impossible de créer la note.");

        clearOldInputs();
        clearErrorsInputs();

        redirect(route('note.index'));
    }
}
