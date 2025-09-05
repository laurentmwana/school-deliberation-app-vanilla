<?php 
require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/level.php';

$levelId = $routeParams["id"] ?? null;

if ($levelId === null) {
    throw new \Exception("Nous n'avons pas pu trouver la classe avec l'ID fourni.");
}

$level = findLevelById($levelId);

if (! $level) {
    throw new \Exception("Nous n'avons pas pu trouver la classe avec l'ID fourni.");
}

?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('level.index') ?>">Classes</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            Détails de la classe #<?= $levelId ?>
        </h2>
        <a href="<?= route('level.edit', ['id' => $levelId]) ?>" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil me-1" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
            Modifier
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Informations générales</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Nom de la classe</label>
                    <p class="fs-5 mb-0"><?= htmlspecialchars($level['name'] ?? 'Non spécifié') ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Alias</label>
                    <p class="fs-5 mb-0">
                        <span class="badge bg-secondary fs-6"><?= htmlspecialchars($level['alias'] ?? 'Non spécifié') ?></span>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">ID</label>
                    <p class="fs-5 mb-0"><?= $levelId ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Date de création</label>
                    <p class="fs-5 mb-0"><?= isset($level['created_at']) ? ago($level['created_at']) : 'Non spécifiée' ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="<?= route('level.index') ?>" class="btn btn-outline-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Retour à la liste
        </a>
        <form method="post" action="<?= route('level.destroy', ['id' => $levelId]) ?>" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');" class="d-inline">
            <button type="submit" class="btn btn-outline-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash me-1" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                </svg>
                Supprimer
            </button>
        </form>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>