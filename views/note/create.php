<?php
requireConnectUser();
$title = "Création d'une note";

require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH . '/queries/student.php';
require BASE_PATH . '/queries/course.php';
require BASE_PATH . '/queries/note.php';
require BASE_PATH . '/queries/level.php';
require BASE_PATH . '/queries/year.php';

// Récupérer les niveaux et années
$allLevels = array_column(findLevels(), 'name', 'id');
$yearsData = findYearCurrent();
$years = [];
foreach ($yearsData as $y) {
    $years[$y['id']] = $y['start'] . '-' . $y['end'];
}

// Déterminer le level sélectionné via query param (default au premier niveau)
$selectedLevelId = $_GET['level_id'] ?? array_key_first($allLevels);

// Filtrer les étudiants pour le select selon le niveau
$allStudents = findStudents();
$students = array_column(
    array_filter($allStudents, fn($s) => (int)$s['level_id'] === (int)$selectedLevelId),
    'student_name',
    'student_id'
);

// Filtrer les cours selon le niveau sélectionné
$allCoursesData = findCourses();
$courses = array_column(
    array_filter($allCoursesData, fn($c) => (int)$c['level_id'] === (int)$selectedLevelId),
    'course_name',
    'course_id'
);
?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= route('note.index') ?>">Notes</a></li>
            <li class="breadcrumb-item active">Création</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar: Levels -->
        <div class="col-md-3 mb-3" style="max-height: 80vh; overflow-y: auto;">
            <?php foreach ($allLevels as $levelId => $levelName): ?>
                <a href="<?= route('note.create') . '?level_id=' . $levelId ?>" class="text-decoration-none mb-2 d-block">
                    <div class="card text-center shadow-sm <?= ((int)$selectedLevelId === (int)$levelId) ? 'border-primary' : '' ?>">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-0"><?= htmlspecialchars($levelName) ?></h6>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Formulaire à droite -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h2 class="h5 mb-0">Création d'une note</h2>
                </div>
                <div class="card-body">
                    <form action="<?= route('note.store') ?>" method="post">
                        
                        <!-- Niveau (hidden) -->
                        <input type="hidden" name="level_id" value="<?= (int)$selectedLevelId ?>">

                        <div class="mb-3">
                            <?= select('student_id', $students, null, 'Étudiant') ?>
                        </div>

                        <div class="mb-3">
                            <?= select('year_id', $years, null, 'Année scolaire') ?>
                        </div>

                        <div class="mb-3">
                            <?= select('course_id', $courses, null, 'Cours') ?>
                        </div>

                          <!-- Période -->
                        <div class="mb-4">
                            <?= select('period', PERIODS, null, 'Période / Examen') ?>
                            <div class="form-text">Choisissez la période ou l’examen</div>
                        </div>

                        <div class="mb-3">
                            <?= input('obtained', 'number', null, 'Note obtenue') ?>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="<?= route('note.index') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Créer la note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
