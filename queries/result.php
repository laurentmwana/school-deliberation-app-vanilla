<?php

/**
 * Récupérer tous les résultats avec infos liées (étudiant, niveau, année)
 * @return array
 */
function findResults(): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            r.id AS result_id,
            r.percent AS result_percent,
            r.created_at AS result_created_at,
            s.id AS student_id,
            s.name AS student_name,
            s.firstname AS student_firstname,
            l.id AS level_id,
            l.name AS level_name,
            y.id AS year_id,
            y.start AS year_start,
            y.end AS year_end
        FROM results r
        INNER JOIN students s ON s.id = r.student_id
        INNER JOIN levels l ON l.id = r.level_id
        INNER JOIN years y ON y.id = r.year_id
        ORDER BY r.created_at DESC
    ";

    $stmt = $pdo->query($sql);

    if ($stmt === false) {
        return [];
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Trouver un résultat par ID
 * @param string $id
 * @return array
 */
function findResultById(string $id): array
{
    $pdo = getPdo();

    $stmt = $pdo->prepare("SELECT * FROM results WHERE id = ?");
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Vérifie si un résultat existe déjà pour un étudiant, un niveau et une année
 * @param int $studentId
 * @param int $levelId
 * @param int $yearId
 * @param int|null $exceptId
 * @return bool
 */
function findResultIfExist(int $studentId, int $levelId, int $yearId, ?int $exceptId = null): bool
{
    $pdo = getPdo();

    if ($exceptId !== null) {
        $sql = "SELECT 1 FROM results WHERE student_id = ? AND level_id = ? AND year_id = ? AND id != ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $levelId, $yearId, $exceptId]);
    } else {
        $sql = "SELECT 1 FROM results WHERE student_id = ? AND level_id = ? AND year_id = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $levelId, $yearId]);
    }

    return (bool) $stmt->fetchColumn();
}

/**
 * Créer un résultat
 * @param array $data
 *      required keys: student_id, level_id, year_id, percent
 * @return bool
 */
function createResult(array $data): bool
{
    $pdo = getPdo();

    $stmt = $pdo->prepare("
        INSERT INTO results (student_id, level_id, year_id, period, percent, mention, created_at)
        VALUES (:student_id, :level_id, :year_id, :period, :percent, :mention, NOW())
    ");

    return $stmt->execute($data);
}


/**
 * Récupérer un résultat avec toutes les infos liées
 * @param string $id
 * @return array
 */
function findResultByIdWithDetails(string $id): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            r.id AS result_id,
            r.percent AS result_percent,
            r.created_at AS result_created_at,
            s.id AS student_id,
            s.name AS student_name,
            s.firstname AS student_firstname,
            l.id AS level_id,
            l.name AS level_name,
            y.id AS year_id,
            y.start AS year_start,
            y.end AS year_end
        FROM results r
        INNER JOIN students s ON s.id = r.student_id
        INNER JOIN levels l ON l.id = r.level_id
        INNER JOIN years y ON y.id = r.year_id
        WHERE r.id = ?
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute([$id])) {
        return [];
    }

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}


function resultExists(string $studentId, string $yearId, string $levelId, string $period)
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM results r WHERE r.student_id = ? AND r.year_id = ? AND r.level_id = ? AND r.period = ?");
    $statement->execute([$studentId, $yearId, $levelId, $period]);

    if ($statement === false) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}