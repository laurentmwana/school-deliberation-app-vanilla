<?php

/**
 * Permet de récupérer tous les étudiants avec leur classe
 * @return array
 */
function findStudents(): array
{
    $pdo = getPdo();

    $sql = "
        SELECT 
            s.id AS student_id,
            s.name AS student_name,
            s.firstname AS student_firstname,
            s.gender AS student_gender,
            s.registration_token AS student_registration_token,
            s.created_at AS student_created_at,
            l.id AS level_id,
            l.name AS level_name,
            l.created_at AS level_created_at
        FROM students s
        INNER JOIN levels l ON l.id = s.level_id
        ORDER BY s.created_at DESC
    ";

    $statement = $pdo->query($sql);

    if ($statement === false) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Trouver un étudiant par ID
 * @param string $id
 * @return array
 */
function findStudentById(string $id): array
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM students WHERE id = ? ");
    $statement->execute([$id]);

    if (is_bool($statement)) {
        return [];
    }

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Vérifie si un étudiant existe
 * @param string $field
 * @param string $value
 * @param string|null $exceptId
 * @param string|null $levelId
 * @throws \InvalidArgumentException
 * @return bool
 */
function findStudentIfExist(string $field, string $value, ?string $exceptId = null, ?string $levelId = null): bool
{
    $pdo = getPdo();

    // 🔒 Autoriser uniquement certains champs
    $allowedFields = ['name', 'firstname', 'gender', 'level_id'];
    if (!in_array($field, $allowedFields, true)) {
        throw new InvalidArgumentException("Champ invalide : $field");
    }

    if ($exceptId !== null && $levelId !== null) {
        $sql = "SELECT 1 FROM students WHERE $field = ? AND id != ? AND level_id = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$value, $exceptId, $levelId]);
    } else {
        $sql = "SELECT 1 FROM students WHERE $field = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$value]);
    }

    return (bool) $stmt->fetchColumn();
}

/**
 * Supprimer un étudiant
 */
function destroyStudentById(string $id): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("DELETE FROM students WHERE id = ?");
    return $statement->execute([$id]);
}

/**
 * Créer un étudiant
 */
function createStudent(array $data): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("
        INSERT INTO students (name, firstname, gender, level_id, registration_token, created_at) 
        VALUES (:name, :firstname, :gender, :level_id, :registration_token, NOW())
    ");

    return $statement->execute([
        ...$data,
        'registration_token' => uniqid()
    ]);
}

/**
 * Mettre à jour un étudiant
 */
function updateStudent(string $id, array $newData): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("
        UPDATE students 
        SET name = :name, firstname = :firstname, gender = :gender, level_id = :level_id 
        WHERE id = :id
    ");
    return $statement->execute([
        ...$newData,
        'id' => $id,
    ]);
}

/**
 * Trouver un étudiant avec sa classe
 */
function findStudentByIdWithLevel(string $id): array
{
    $pdo = getPdo();
    $sql = "
        SELECT 
            s.id AS student_id,
            s.name AS student_name,
            s.firstname AS student_firstname,
            s.gender AS student_gender,
            s.registration_token AS student_registration_token,
            s.created_at AS student_created_at,
            l.id AS level_id,
            l.name AS level_name,
            l.created_at AS level_created_at
        FROM students s
        INNER JOIN levels l ON l.id = s.level_id
        WHERE s.id = ?
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    if (!$stmt->execute([$id])) {
        return [];
    }

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}


function findStudentsByLevel(string $levelId)
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM students s WHERE s.level_id = ?");
    $statement->execute([$levelId]);

    if ($statement === false) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}