<?php
requireConnectUser();
$title = "Détails d'un étudiant";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/student.php';

$studentId = $routeParams["id"] ?? null;

if ($studentId === null) {
    throw new \Exception("Nous n'avons pas pu trouver l'étudiant avec l'ID fourni.");
}

$student = findStudentByIdWithLevel($studentId) ?? null;

if (! $student) {
    throw new \Exception("Nous n'avons pas pu trouver l'étudiant avec l'ID fourni.");
}
?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('student.index') ?>">Étudiants</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            Détails de l'étudiant #<?= htmlspecialchars($studentId) ?>
        </h2>
        <a href="<?= route('student.edit', ['id' => $studentId]) ?>" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Informations générales</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Nom</label>
                    <p class="fs-5 mb-0"><?= htmlspecialchars($student['student_name'] ?? 'Non spécifié') ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Prénom</label>
                    <p class="fs-5 mb-0"><?= htmlspecialchars($student['student_firstname'] ?? 'Non spécifié') ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Genre</label>
                    <p class="fs-5 mb-0">
                        <span class="badge bg-secondary fs-6"><?= htmlspecialchars($student['student_gender'] ?? 'Non spécifié') ?></span>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Classe associée</label>
                    <p class="fs-5 mb-0">
                        <a href="<?= route('level.show', ['id' => $student['level_id']]) ?>">
                            <?= htmlspecialchars($student['level_name'] ?? 'Non spécifiée') ?>
                        </a>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Matricule</label>
                    <p class="fs-5 mb-0">
                      <?= htmlspecialchars($student['student_registration_token'] ?? 'Non spécifiée') ?>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small mb-1">Date d’inscription</label>
                    <p class="fs-5 mb-0"><?= isset($student['student_created_at']) ? ago($student['student_created_at']) : 'Non spécifiée' ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="<?= route('student.index') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
        <form method="post" action="<?= route('student.destroy', ['id' => $studentId]) ?>" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');" class="d-inline">
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash me-1"></i> Supprimer
            </button>
        </form>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
