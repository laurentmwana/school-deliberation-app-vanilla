<?php

/**
 * Permet de récupèrer toutes les classes
 * @return array
 */
function findCourses(): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            c.id AS course_id,
            c.name AS course_name,
            c.created_at AS course_created_at,
            l.id AS level_id,
            l.name AS level_name,
            l.created_at AS level_created_at,
            c.credits
        FROM courses c
        INNER JOIN levels l ON l.id = c.level_id
        ORDER BY c.created_at DESC
    ";

    $statement = $pdo->query($sql);

    if ($statement === false) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


 /**
  * @param string $id
  * @return array
  */
function findCourseById(string $id): array
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM courses WHERE id = ? ");
    $statement->execute([$id]);

    if (is_bool($statement)) {
        return [];
    }

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * @param string $field
 * @param string $value
 * @param mixed $exceptId
 * @param mixed $levelId
 * @throws \InvalidArgumentException
 * @return bool
 */
function findCourseIfExist(string $field, string $value, ?string $exceptId = null, ?string $levelId = null): bool
{
    $pdo = getPdo();

    // 🔒 Autoriser uniquement certains champs pour éviter l'injection SQL
    $allowedFields = ['name', 'credits', 'level_id'];
    if (!in_array($field, $allowedFields, true)) {
        throw new InvalidArgumentException("Champ invalide : $field");
    }

    if ($exceptId !== null && $levelId !== null) {
        // Vérifie l'existence en excluant l'ID donné et filtrant par niveau
        $sql = "SELECT 1 FROM courses WHERE $field = ? AND id != ? AND level_id = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$value, $exceptId, $levelId]);
    }  else {
        // Vérifie l'existence sans exclure d'ID (nouvelle création)
        $sql = "SELECT 1 FROM courses WHERE $field = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$value]);
    }

    // fetchColumn retourne false si aucune ligne
    return (bool) $stmt->fetchColumn();
}



/**
 * Permet de supprimer une année scolaire
 * @param string $id
 * @return bool
 */
function destroyCourseById(string $id): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("DELETE FROM courses WHERE id = ?");
    return $statement->execute([$id]);
}

/**
 * @param array $newData
 * @return bool
 */
function createCourse(array $newData): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("INSERT INTO courses SET name = :name, credits = :credits, level_id = :level_id, created_at = NOW()");
    return $statement->execute($newData);
}


function updateCourse(string $id, array $newData): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("UPDATE courses SET name = :name, credits = :credits, level_id = :level_id WHERE id = :id");
    return $statement->execute([
        ...$newData,
        'id' => $id,
    ]);
}

function findCourseByIdWithLevel(string $id): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            c.id AS course_id,
            c.name AS course_name,
            c.created_at AS course_created_at,
            l.id AS level_id,
            l.name AS level_name,
            l.created_at AS level_created_at,
            c.credits
        FROM courses c
        INNER JOIN levels l ON l.id = c.level_id
        WHERE c.id = ?
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    if (! $stmt->execute([$id])) {
        return [];
    }

    // ⚡ fetch() pour récupérer directement le tableau associatif
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    return $res ?: [];
}
