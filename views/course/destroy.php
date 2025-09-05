<?php

require BASE_PATH . '/queries/course.php';

$courseId = $routeParams["id"] ?? null;

if ($courseId === null) {
    throw new \Exception("Nous n'avons pas pu trouver le cours avec l'ID fourni.");
}

$course = findCourseById($courseId);

if (! $course) {
    throw new \Exception("Nous n'avons pas pu trouver le cours avec l'ID fourni.");
}

$isDeleted = destroyCourseById($courseId);

// Définir le message avant de rediriger
$isDeleted 
    ? flashMessage("success", "Cours supprimé avec succès.")
    : flashMessage("danger", "Impossible de supprimer le cours.");

// Redirection vers la liste des cours
redirect(route("course.index"));
