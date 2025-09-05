<?php

require BASE_PATH . '/queries/level.php';

$levelId = $routeParams["id"] ?? null;

if ($levelId === null) {
    throw new \Exception("Nous n'avons pas pu trouver la classe avec l'ID fourni.");
}

$level = findLevelById($levelId);

if (! $level) {
    throw new \Exception("Nous n'avons pas pu trouver la classe avec l'ID fourni.");
}

$isDeleted = destroyLevelById($levelId);

// Définir le message avant de rediriger
$isDeleted 
    ? flashMessage("success", "Classe supprimée avec succès.")
    : flashMessage("danger", "Impossible de supprimer la classe.");

// Redirection vers la liste des années
redirect(route("level.index"));
