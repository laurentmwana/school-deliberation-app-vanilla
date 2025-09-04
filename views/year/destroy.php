<?php

require BASE_PATH . '/app/queries/year.php';

$yearId = $routeParams["id"] ?? null;

if ($yearId === null) {
    throw new \Exception("Nous n'avons pas pu trouver l'année scolaire avec l'ID fourni.");
}

$year = findYearById($yearId);

if (! $year) {
    throw new \Exception("Nous n'avons pas pu trouver l'année scolaire avec l'ID fourni.");
}

if ($year['is_closed'] === 0) {
    throw new \Exception("Nous ne pouvais pas supprimer l'année en cours...");
}

// Supprime l'année
$isDeleted = destroyYearById($yearId);

// Définir le message avant de rediriger
$isDeleted 
    ? flashMessage("success", "Année supprimée avec succès.")
    : flashMessage("danger", "Impossible de supprimer l'année.");

// Redirection vers la liste des années
redirect(route("year.index"));
