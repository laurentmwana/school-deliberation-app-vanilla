<?php
requireConnectUser();
$title = "Détails d'une note";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/note.php';
require BASE_PATH . '/queries/student.php';
require BASE_PATH . '/queries/course.php';
require BASE_PATH . '/queries/level.php';
require BASE_PATH . '/queries/year.php';

$noteId = $routeParams["id"] ?? null;

if ($noteId === null) {
    throw new \Exception("Nous n'avons pas pu trouver la note avec l'ID fourni.");
}

$note = findNoteByIdWithDetails($noteId);

if (!$note) {
    throw new \Exception("Nous n'avons pas pu trouver la note avec l'ID fourni.");
}
?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('note.index') ?>">Notes</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Détails de la note #<?= htmlspecialchars($noteId) ?></h2>
        <a href="<?= route('note.edit', ['id' => $noteId]) ?>" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Informations de la note</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Étudiant</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('student.show', ['id' => $note['student_id']]) ?>">
                            <?= htmlspecialchars($note['student_name'] . ' ' . $note['student_firstname']) ?>
                        </a>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Cours</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('course.show', ['id' => $note['course_id']]) ?>">
                            <?= htmlspecialchars($note['course_name']) ?>
                        </a>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Classe</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('level.show', ['id' => $note['level_id']]) ?>">
                            <?= htmlspecialchars($note['level_name']) ?>
                        </a>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Année académique</label>
                    <p class="fs-5 mb-0">
                        <?= htmlspecialchars($note['year_start'] . ' - ' . $note['year_end']) ?>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Note obtenue</label>
                    <p class="fs-5 mb-0"><?= htmlspecialchars($note['note_obtained']) ?>/20</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Fermée</label>
                    <p class="fs-5 mb-0"><?= $note['note_is_closed'] ? 'Oui' : 'Non' ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Période</label>
                    <p class="fs-5 mb-0"><?= $note['note_period'] ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Date de création</label>
                    <p class="fs-5 mb-0"><?= isset($note['note_created_at']) ? ago($note['note_created_at']) : 'Non spécifiée' ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="<?= route('note.index') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
        <form method="post" action="<?= route('note.destroy', ['id' => $noteId]) ?>" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');" class="d-inline">
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash me-1"></i> Supprimer
            </button>
        </form>
    </div>
</div>

<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
