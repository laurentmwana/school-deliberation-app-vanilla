<?php
requireConnectUser();
$title = "Liste des résultats";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/result.php';

$results = findResults();
?>

<div class="container py-5">
    <!-- En-tête de page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestion des résultats</h2>
            <p class="text-muted">Consultez les résultats des étudiants par cours</p>
        </div>
        <div>
            <a href="<?= route('result.create') ?>" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-megaphone-fill me-1" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 0-.5.5V6H7V4.5A1.5 1.5 0 0 1 8.5 3h6A1.5 1.5 0 0 1 16 4.5V6h-.5V4.5a.5.5 0 0 0-.5-.5h-6z"/>
                    <path d="M0 7a1 1 0 0 0 1 1h1.5a3.5 3.5 0 0 1 7 0H15a1 1 0 0 0 1-1v-.5a.5.5 0 0 0-.5-.5H1.5A.5.5 0 0 0 1 6.5V7z"/>
                </svg>
                Proclamation
            </a>
        </div>
    </div>

    <?php require BASE_VIEW_PATH . '/inc/flash.php'; ?>

    <!-- Carte -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Année</th>
                            <th>Pourcentage</th>
                            <th>Création</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($results)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-inbox text-muted mb-2" viewBox="0 0 16 16">
                                        <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z"/>
                                    </svg>
                                    <p class="text-muted">Aucun résultat n'a été enregistré pour le moment</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($results as $result): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= $result['result_id'] ?></td>
                                <td>
                                    <a href="<?= route('student.show', ['id' => $result['student_id']]) ?>">
                                        <?= htmlspecialchars($result['student_name']) ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= route('level.show', ['id' => $result['level_id']]) ?>">
                                        <?= htmlspecialchars($result['level_name']) ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= route('year.show', ['id' => $result['year_id']]) ?>">
                                        <?= $result['year_start'] ?>-<?= $result['year_end'] ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($result['result_percent'] < 50): ?>
                                        <span class="text-danger fw-bold"><?= $result['result_percent'] ?>%</span>
                                    <?php else: ?>
                                        <span class="text-success fw-bold"><?= $result['result_percent'] ?>%</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-muted"><?= ago($result['result_created_at'] ?? new DateTime()) ?></div>
                                </td>
                                <td>
                                  <div>
                                     <a href="<?= route('result.show', ['id' => $result['result_id']]) ?>" class="btn btn-sm btn-outline-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </a>
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

<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
