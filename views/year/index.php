<?php 
require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH .'/queries/year.php';

$years = findYears();

?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestion des années scolaires</h2>
            <p class="text-muted">Gérez les périodes scolaires de votre établissement</p>
        </div>
    </div>

    <?php require BASE_VIEW_PATH . '/inc/flash.php' ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Status</th>
                            <th>Création</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($years)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-x text-muted mb-2" viewBox="0 0 16 16">
                                        <path d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>
                                    <p class="text-muted">Aucune année scolaire n'a été créée</p>
                                    <a href="<?= route('year.create') ?>" class="btn btn-primary mt-2">Créer la première année</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($years as $year): ?>
                            <tr>
                                <td class="ps-4 fw-semibold"><?= $year['id'] ?></td>
                                <td>
                                    <span class="badge bg-light text-dark fs-6"><?= $year['start'] ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark fs-6"><?= $year['end'] ?></span>
                                </td>
                                <td>
                                    <?php if ($year['is_closed'] == 0): ?>
                                        <span class="badge bg-success">En cours</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Clôturée</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted"><?= ago($year['created_at'] ?? new DateTime()) ?></small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2 pe-3">
                                        <?php if ($year['is_closed'] === 0): ?>
                                        <form method="post" action="<?= route('year.closed', ['id' => $year['id']]) ?>" onsubmit="return confirm('Voulez-vous vraiment clôturer cette année scolaire ?')">
                                            <button type="submit" class="btn btn-sm btn-outline-warning d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-lock-fill me-1" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                                </svg>
                                                Clôturer
                                            </button>
                                        </form>
                                        <?php endif; ?>

                                        <a href="<?= route('year.show', ['id' => $year['id']]) ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye-fill me-1" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                            Voir
                                        </a>

                                        <form method="post" action="<?= route('year.destroy', ['id' => $year['id']]) ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer cette année scolaire ?')">
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash-fill me-1" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1h13V2a1 1 0 0 0-1-1h-11zm1 4v9a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2V5h-9z"/>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php' ?>