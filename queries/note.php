<?php

/**
 * Récupérer toutes les notes avec informations sur l'étudiant, cours, niveau et année
 * @return array
 */
function findNotes(): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            n.id AS note_id,
            n.obtained AS note_obtained,
            n.is_closed AS note_is_closed,
            n.created_at AS note_created_at,
            s.id AS student_id,
            s.name AS student_name,
            s.firstname AS student_firstname,
            c.id AS course_id,
            c.name AS course_name,
            l.id AS level_id,
            l.name AS level_name,
            y.id AS year_id,
            y.start AS year_start,
            y.end AS year_end,
            y.is_closed AS year_is_closed
        FROM notes n
        INNER JOIN students s ON s.id = n.student_id
        INNER JOIN courses c ON c.id = n.course_id
        INNER JOIN levels l ON l.id = n.level_id
        INNER JOIN years y ON y.id = n.year_id
        ORDER BY n.created_at DESC
    ";

    $stmt = $pdo->query($sql);

    if ($stmt === false) {
        return [];
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Trouver une note par ID
 * @param string $id
 * @return array
 */
function findNoteById(string $id): array
{
    $pdo = getPdo();

    $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Vérifie si une note existe pour un étudiant sur un cours et année donnés
 * @param int $studentId
 * @param int $courseId
 * @param int $yearId
 * @param int|null $exceptId
 * @return bool
 */
function findNoteIfExist(int $studentId, int $courseId, int $yearId, string $period, ?int $exceptId = null): bool
{
    $pdo = getPdo();

    if ($exceptId !== null) {
        $sql = "SELECT 1 FROM notes WHERE student_id = ? AND course_id = ? AND year_id = ?  AND period = ? AND id != ? AND is_closed = 0 LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId, $yearId, $period, $exceptId]);
    } else {
        $sql = "SELECT 1 FROM notes WHERE student_id = ? AND course_id = ? AND year_id = ? AND period = ? AND is_closed = 0 LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId, $yearId, $period]);
    }

    return (bool) $stmt->fetchColumn();
}

/**
 * Créer une note
 * @param array $data
 *      required keys: student_id, course_id, level_id, year_id, obtained
 * @return bool
 */
function createNote(array $data): bool
{
    $pdo = getPdo();

    $stmt = $pdo->prepare("
        INSERT INTO notes (student_id, course_id, level_id, year_id, obtained, period, is_closed, created_at)
        VALUES (:student_id, :course_id, :level_id, :year_id, :obtained, :period, 0, NOW())
    ");

    return $stmt->execute($data);
}

/**
 * Mettre à jour une note
 * @param string $id
 * @param array $data
 *      keys: student_id, course_id, level_id, year_id, obtained, is_closed
 * @return bool
 */
function updateNote(string $id, array $data): bool
{
    $pdo = getPdo();

    $stmt = $pdo->prepare("
        UPDATE notes 
        SET student_id = :student_id, course_id = :course_id, level_id = :level_id, year_id = :year_id,
            obtained = :obtained, period = :period 
        WHERE id = :id
    ");

    return $stmt->execute([
        ...$data,
        'id' => $id
    ]);
}

/**
 * Supprimer une note
 * @param string $id
 * @return bool
 */
function destroyNoteById(string $id): bool
{
    $pdo = getPdo();

    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
    return $stmt->execute([$id]);
}

/**
 * Récupérer une note avec toutes les infos liées
 * @param string $id
 * @return array
 */
function findNoteByIdWithDetails(string $id): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            n.id AS note_id,
            n.obtained AS note_obtained,
            n.is_closed AS note_is_closed,
            n.period AS note_period,
            n.created_at AS note_created_at,
            s.id AS student_id,
            s.name AS student_name,
            s.firstname AS student_firstname,
            c.id AS course_id,
            c.name AS course_name,
            l.id AS level_id,
            l.name AS level_name,
            y.id AS year_id,
            y.start AS year_start,
            y.end AS year_end,
            y.is_closed AS year_is_closed
        FROM notes n
        INNER JOIN students s ON s.id = n.student_id
        INNER JOIN courses c ON c.id = n.course_id
        INNER JOIN levels l ON l.id = n.level_id
        INNER JOIN years y ON y.id = n.year_id
        WHERE n.id = ?
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute([$id])) {
        return [];
    }

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

function findNotesByStudentYearPeriod(string $studentId, string $yearId, string $period): array
{
    $pdo = getPdo();

    $statement = $pdo->prepare("
        SELECT 
            n.*, 
            c.name AS course_name,
            c.credits AS course_credits
        FROM notes n
        INNER JOIN courses c ON c.id = n.course_id
        WHERE n.student_id = ? 
          AND n.year_id = ? 
          AND n.period = ?
    ");

    $statement->execute([$studentId, $yearId, $period]);

    if ($statement === false) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
