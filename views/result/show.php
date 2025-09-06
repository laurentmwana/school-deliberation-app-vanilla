<?php
requireConnectUser();
$title = "Détails d'un résultat";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/result.php';

$resultId = $routeParams["id"] ?? null;

if ($resultId === null) {
    throw new \Exception("Nous n'avons pas pu trouver le résultat avec l'ID fourni.");
}

$result = findResultByIdWithDetails($resultId) ?? null;

if (!$result) {
    throw new \Exception("Nous n'avons pas pu trouver le résultat avec l'ID fourni.");
}
?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('result.index') ?>">Résultats</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            Détails du résultat #<?= $resultId ?>
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Informations générales</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Étudiant</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('student.show', ['id' => $result['student_id']]) ?>">
                            <?= htmlspecialchars($result['student_name'] ?? 'Non spécifié') ?>
                        </a>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Classe</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('level.show', ['id' => $result['level_id']]) ?>">
                            <?= htmlspecialchars($result['level_name'] ?? 'Non spécifiée') ?>
                        </a>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Année scolaire</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('year.show', ['id' => $result['year_id']]) ?>">
                            <?= $result['year_start'] ?> - <?= $result['year_end'] ?>
                        </a>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Pourcentage</label>
                    <p class="fs-5 mb-0">
                        <?php if ($result['result_percent'] < 50): ?>
                            <span class="badge bg-danger fs-6"><?= $result['result_percent'] ?>%</span>
                        <?php else: ?>
                            <span class="badge bg-success fs-6"><?= $result['result_percent'] ?>%</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Date de création</label>
                    <p class="fs-5 mb-0"><?= isset($result['result_created_at']) ? ago($result['result_created_at']) : 'Non spécifiée' ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="<?= route('result.index') ?>" class="btn btn-outline-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Retour à la liste
        </a>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
