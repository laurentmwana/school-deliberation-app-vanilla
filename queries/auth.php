<?php

function findUserBy(string $key, string $value): array
{
    $pdo = getPdo();

    $statement = $pdo->prepare("SELECT * FROM users WHERE $key = ? LIMIT 1");
    $statement->execute([$value]);

    if (is_bool($statement)) { 
        return [];
    }

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return is_array($result) ? $result : [];
}

