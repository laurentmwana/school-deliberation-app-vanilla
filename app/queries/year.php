<?php

/**
 * Permet de récupèrer toutes les années scolaires
 * @return array
 */
function findYears(): array
{
    $pdo = getPdo();

    $statement = $pdo->query("SELECT * FROM years ORDER BY created_at DESC");

    if (is_bool($statement)) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Permet de récupèrer une année académique
 * @param string $id
 * @return array
 */
function findYearById(string $id): array
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM years WHERE id = ?");
    $statement->execute([$id]);

    if (is_bool($statement)) {
        return [];
    }
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de supprimer une année scolaire
 * @param string $id
 * @return bool
 */
function destroyYearById(string $id): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("DELETE FROM years WHERE id = ?");
    return $statement->execute([$id]);
}

/**
 * Permet de cloturer une année académique
 * @param array $newData
 * @return void
 */
function createYear(array $newData): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("INSERT INTO years SET start = :start, end = :end, created_at = NOW()");
    return $statement->execute($newData);
}



/**
 * Permet de cloturer une année académique
 * @param array $newData
 * @return void
 */
function closedYear(string $id): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("UPDATE years SET is_closed = ? WHERE id = ?");
    return $statement->execute([1, $id]);
}