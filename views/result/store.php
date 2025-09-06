<?php
requireConnectUser();
require BASE_PATH . '/queries/result.php';
require BASE_PATH . '/queries/student.php';
require BASE_PATH . '/queries/note.php';

if (!empty($_POST)) {
    $level_id = $_POST['level_id'] ?? null;
    $year_id  = $_POST['year_id'] ?? null;
    $period   = $_POST['period'] ?? null;

    if (!$level_id || !$year_id || !$period) {
        flashMessage("danger", "Tous les champs sont requis.");
        redirect(route('result.proclamation'));
    }

    // 1. Récupérer les étudiants de ce niveau
    $students = findStudentsByLevel($level_id);

    if (empty($students)) {
        flashMessage("warning", "Aucun étudiant trouvé pour ce niveau.");
        redirect(route('result.create'));
    }

    $resultsInserted = 0;

    $maxNote = 20;

    foreach ($students as $student) {
        $student_id = $student['id'];

        // 2. Récupérer les notes pour cet étudiant, année et période
        // Chaque note doit avoir : obtained (note obtenue), course_credits, max (note maximale du cours)
        $notes = findNotesByStudentYearPeriod($student_id, $year_id, $period);

        if (empty($notes)) continue;

        // 3. Calculer la moyenne pondérée en pourcentage
        $totalObtained = 0;
        $totalMax = 0;

        foreach ($notes as $note) {
            $obtained = $note['obtained'] ?? 0;
            $credits  = $note['course_credits'] ?? 1;
            $totalObtained += $obtained * $credits;
            $totalMax += $maxNote * $credits;
        }

        $percent = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0;

        // 4. Déterminer la mention
        if ($percent >= 85) $mention = 'A';
        elseif ($percent >= 70) $mention = 'B';
        elseif ($percent >= 50) $mention = 'C';
        else $mention = 'F';

        // 5. Préparer les données pour insertion
        $data = [
            'student_id' => $student_id,
            'level_id'   => $level_id,
            'year_id'    => $year_id,
            'period'     => $period,
            'percent'    => $percent,
            'mention'    => $mention,
        ];

        // 6. Vérifier si le résultat existe déjà
        if (!resultExists($student_id, $year_id, $level_id, $period)) {
            createResult($data); // createResult doit accepter 'period' dans le SQL
            $resultsInserted++;
        }
    }

    flashMessage("success", "$resultsInserted résultats proclamés avec succès.");
    redirect(route('result.index'));
}
