<?php
requireConnectUser();

require BASE_PATH . '/queries/student.php';

$studentId = $routeParams["id"] ?? null;

if ($studentId === null) {
    throw new \Exception("Nous n'avons pas pu trouver l'étudiant avec l'ID fourni.");
}

$student = findStudentById($studentId);

if (! $student) {
    throw new \Exception("Nous n'avons pas pu trouver l'étudiant avec l'ID fourni.");
}

$isDeleted = destroyStudentById($studentId);

// Définir le message avant de rediriger
$isDeleted 
    ? flashMessage("success", "Étudiant supprimé avec succès.")
    : flashMessage("danger", "Impossible de supprimer l'étudiant.");

// Redirection vers la liste des étudiants
redirect(route("student.index"));
