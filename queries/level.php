<?php

/**
 * Permet de récupèrer toutes les classes
 * @return array
 */
function findLevels(): array
{
    $pdo = getPdo();

    $statement = $pdo->query("SELECT * FROM levels ORDER BY created_at DESC");

    if (is_bool($statement)) {
        return [];
    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

 /**
  * @param string $id
  * @return array
  */
function findLevelById(string $id): array
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM levels WHERE id = ? ");
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
 * @return bool
 */
function findLevelIfExist(string $field, string $value, ?string $exceptId = null): bool
{
    $pdo = getPdo();

    if ($exceptId !== null) {
        // Vérifie l'existence en excluant l'ID donné
        $statement = $pdo->prepare("SELECT 1 FROM levels WHERE $field = ? AND id != ? LIMIT 1");
        $statement->execute([$value, $exceptId]);
    } else {
        // Vérifie l'existence sans exclure d'ID (nouvelle création)
        $statement = $pdo->prepare("SELECT 1 FROM levels WHERE $field = ? LIMIT 1");
        $statement->execute([$value]);
    }

    // fetchColumn retourne false si aucune ligne
    return (bool) $statement->fetchColumn();
}



/**
 * Permet de supprimer une année scolaire
 * @param string $id
 * @return bool
 */
function destroyLevelById(string $id): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("DELETE FROM levels WHERE id = ?");
    return $statement->execute([$id]);
}

/**
 * @param array $newData
 * @return bool
 */
function createLevel(array $newData): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("INSERT INTO levels SET name = :name, alias = :alias, created_at = NOW()");
    return $statement->execute($newData);
}


function updateLevel(string $id, array $newData): bool
{
    $pdo = getPdo();

    $statement = $pdo->prepare("UPDATE levels SET name = :name, alias = :alias WHERE id = :id");
    return $statement->execute([
        ...$newData,
        'id' => $id,
    ]);
}

