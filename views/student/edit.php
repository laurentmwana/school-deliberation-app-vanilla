<?php
requireConnectUser();
$title = "Édition d'un étudiant";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/level.php';
require BASE_PATH . '/queries/student.php';

$studentId = $routeParams["id"] ?? null;

if ($studentId === null) {
    throw new \Exception("Nous n'avons pas pu trouver l'étudiant avec l'ID fourni.");
}

$student = findStudentById($studentId);

if (! $student) {
    throw new \Exception("Nous n'avons pas pu trouver l'étudiant avec l'ID fourni.");
}

$levels = array_column(findLevels(), 'name', 'id');
?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('student.index') ?>">Étudiants</a></li>
            <li class="breadcrumb-item active">Édition</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h2 class="h5 mb-0">Édition d'un étudiant</h2>
                </div>
                <div class="card-body">
                    <form action="<?= route('student.update', ['id' => $studentId])?>" method="post">
                        <div class="mb-3">
                            <?= input('name', 'text', $student['name'], 'Nom') ?>
                        </div>
                        
                        <div class="mb-3">
                            <?= input('firstname', 'text', $student['firstname'], 'Postnom') ?>
                        </div>

                        <div class="mb-3">
                            <?= select('gender', ['M' => 'Masculin', 'F' => 'Féminin'], $student['gender'], 'Genre') ?>
                        </div>

                        <div class="mb-3">
                            <?= select('level_id', $levels, $student['level_id'], 'Niveau / Classe') ?>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="<?= route('student.index') ?>" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg me-1" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                               Éditer l'étudiant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
