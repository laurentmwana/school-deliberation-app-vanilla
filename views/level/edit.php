<?php 
requireConnectUser();
$title = "Edition d'une classe";

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
            <li class="breadcrumb-item active">Edition</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h2 class="h5 mb-0">
                        Editer la classe #<?= $levelId ?>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="<?= route('level.store')?>" method="post">
                        <div class="mb-3">
                            <?= input('name', 'text', $level['name'], 'Nom') ?>
                            <div class="form-text">Le nom complet de la classe</div>
                        </div>
                        
                        <div class="mb-4">
                            <?= input('alias', 'text', $level['alias'], 'Alias') ?>
                            <div class="form-text">Un code court pour identifier la classe</div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="<?= route('level.index') ?>" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg me-1" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                                Editer la classe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
