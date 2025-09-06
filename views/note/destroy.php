<?php
requireConnectUser();

require BASE_PATH . '/queries/note.php';

$noteId = $routeParams["id"] ?? null;

if ($noteId === null) {
    throw new \Exception("Nous n'avons pas pu trouver la note avec l'ID fourni.");
}

// Récupérer la note
$note = findNoteById($noteId);

if (!$note) {
    throw new \Exception("Nous n'avons pas pu trouver la note avec l'ID fourni.");
}

// Vérifier si la note est fermée
if ((int)$note['is_closed'] === 1) {
    flashMessage("danger", "Cette note est fermée et ne peut pas être supprimée.");
    redirect(route("note.index"));
}

// Supprimer la note
$isDeleted = destroyNoteById($noteId);

// Définir le message avant de rediriger
$isDeleted 
    ? flashMessage("success", "Note supprimée avec succès.")
    : flashMessage("danger", "Impossible de supprimer la note.");

// Redirection vers la liste des notes
redirect(route("note.index"));
