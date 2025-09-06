<?php
requireConnectUser();
$title = "Proclamation des résultats";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/level.php';
require BASE_PATH . '/queries/year.php';

// Récupération des listes
$levels = array_column(findLevels(), 'name', 'id');
$yearsData = findYearCurrent();
$years = [];
foreach ($yearsData as $y) {
    $years[$y['id']] = $y['start'] . '-' . $y['end'];
}

?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('result.index') ?>">Résultats</a></li>
            <li class="breadcrumb-item active">Proclamation</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h2 class="h5 mb-0">Nouvelle proclamation</h2>
                </div>
                <div class="card-body">
                    <form action="<?= route('result.store')?>" method="post">
                        
                        <!-- Classe / Niveau -->
                        <div class="mb-3">
                            <?= select('level_id', $levels, null, 'Niveau / Classe') ?>
                            <div class="form-text">Choisissez la classe</div>
                        </div>

                        <!-- Année académique -->
                        <div class="mb-3">
                            <?= select('year_id', $years, null, 'Année académique') ?>
                            <div class="form-text">Exemple : 2024-2025</div>
                        </div>
 
                        <!-- Période -->
                        <div class="mb-4">
                            <?= select('period', PERIODS, null, 'Période / Examen') ?>
                            <div class="form-text">Choisissez la période ou l’examen</div>
                        </div>
                        
                        <!-- Boutons -->
                        <div class="d-flex gap-2">
                            <a href="<?= route('result.index') ?>" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Lancer la proclamation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
