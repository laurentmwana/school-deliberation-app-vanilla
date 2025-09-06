<?php
requireConnectUser();
$title = "Détails d'une année scolaire";

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
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('year.index') ?>">Années scolaires</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Détails de l'année académique</h2>
            <p class="text-muted">Informations complètes sur cette période scolaire</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h3 class="h5 mb-0"><?= $year['start'] ?> - <?= $year['end'] ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Année de début</label>
                            <p class="fs-5 fw-semibold mb-0"><?= $year['start'] ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Année de fin</label>
                            <p class="fs-5 fw-semibold mb-0"><?= $year['end'] ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Statut</label>
                            <p class="mb-0">
                                <?php if ($year['is_closed'] == 0): ?>
                                    <span class="badge bg-success fs-6">En cours</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary fs-6">Clôturée</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Date de création</label>
                            <p class="mb-0"><?= ago($year['created_at']) ?></p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small mb-1">ID de l'année</label>
                            <p class="mb-0"><code><?= $yearId ?></code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h3 class="h5 mb-0">Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= route('year.index') ?>" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Retour à la liste
                        </a>
                        
                        <?php if ($year['is_closed'] === 0): ?>
                        <form method="post" action="<?= route('year.closed', ['id' => $yearId]) ?>" onsubmit="return confirm('Voulez-vous vraiment clôturer cette année scolaire ?')">
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill me-1" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                                Clôturer l'année
                            </button>
                        </form>
                        <?php endif; ?>
                        
                        <form method="post" action="<?= route('year.destroy', ['id' => $yearId]) ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer cette année scolaire ? Cette action est irréversible.');">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill me-1" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1h13V2a1 1 0 0 0-1-1h-11zm1 4v9a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2V5h-9z"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php' ?>