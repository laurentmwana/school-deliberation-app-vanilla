<?php 
require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/course.php';

$courses = findCourses();
?>

<div class="container py-5">
    <!-- En-tête de page amélioré -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestion des cours</h2>
            <p class="text-muted">Créez et gérez les différentes cours de votre établissement</p>
        </div>
        <a href="<?= route('course.create') ?>" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Créer un cours
        </a>
    </div>

    <?php require BASE_VIEW_PATH . '/inc/flash.php'; ?>

    <!-- Carte pour un design plus moderne -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nom</th>
                            <th>Pondération</th>
                            <th>Classe</th>
                            <th>Création</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-inbox text-muted mb-2" viewBox="0 0 16 16">
                                        <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z"/>
                                    </svg>
                                    <p class="text-muted">Aucune classe n'a été créée pour le moment</p>
                                    <a href="<?= route('course.create') ?>" class="btn btn-primary mt-2">Créer votre première classe</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($courses as $course): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= $course['course_id'] ?></td>
                                <td>
                                  <?= $course['course_name'] ?>
                                </td>
                                <td>
                                    <?= $course['credits'] ?>
                                </td>
                                 <td>
                                   <a href="<?= route('level.show', ['id' => $course["level_id"] ]) ?>">
                                     <?= $course["level_name"] ?>
                                   </a>
                                </td>
                                <td>
                                    <div class="text-muted"><?= ago($course['course_created_at'] ?? new DateTime()) ?></div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2 pe-3">
                                        <a href="<?= route('course.show', ['id' => $course['course_id']]) ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye-fill me-1" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                            Voir
                                        </a>
                                        <a href="<?= route('course.edit', ['id' => $course['course_id']]) ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            Modifier
                                        </a>
                                        <form method="post" action="<?= route('course.destroy', ['id' => $course['course_id']]) ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer cette classe ? Cette action est irréversible.');">
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

<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>