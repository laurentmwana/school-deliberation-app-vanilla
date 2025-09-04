<?php

require BASE_PATH . '/queries/year.php';

$yearId = $routeParams["id"] ?? null;

if ($yearId === null) {
    throw new \Exception("Nous n'avons pas pu trouver l'année scolaire avec l'ID fourni.");
}

$year = findYearById($yearId);

if (! $year) {
    throw new \Exception("Nous n'avons pas pu trouver l'année scolaire avec l'ID fourni.");
}

require BASE_VIEW_PATH . '/inc/header.php';
?>
<div class="container py-5">
    <h2>
        En savoir plus sur une année académique
    </h2>

    <h2>
        <?= $year['start'] ?> - <?= $year['end'] ?>
    </h2>
    <p>
        <?= $year['is_closed'] == 0 ? 'en cours' : 'Cloturée' ?>
    </p>

    <p>
        <?= ago($year['created_at']) ?>
    </p>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php' ?>