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

if ($year['is_closed'] === 1) {
    throw new \Exception("Cette année est déjà cloturée...");
}

$isClosed = closedYear($yearId);

if ($isClosed) {
    flashMessage("success", "Année cloturée avec succès.");
    $start =(int)$year['end'] + 1;

    $isCreateNewYear = createYear([
        'start' => $start,
        'end' => $start + 1,
    ]);
} else {
    flashMessage("danger", "Impossible de cloturée l'année.");
}

// Redirection vers la liste des années
redirect(route("year.index"));
