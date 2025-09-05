<?php

$pdo = new PDO(
    "mysql:host=localhost;dbname=school_deliberation_app;charset=utf8mb4",
    "root",
    "demo",
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  
        PDO::ATTR_EMULATE_PREPARES   => false,                 
    ]
);

// Vider les tables
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0"); // désactiver les contraintes FK
$pdo->exec("TRUNCATE TABLE levels");
$pdo->exec("TRUNCATE TABLE years");
$pdo->exec("TRUNCATE TABLE courses");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1"); // réactiver les contraintes FK

for ($i = 1; $i <= 20; $i++) {     
    $className = "classe $i";

    $insert = $pdo->prepare("INSERT INTO levels (name, alias, created_at) VALUES (?, ?, NOW())");
    $insert->execute([$className, $className]);
}

// YEARS
$startYear = 2024;
$endYear = 2034;
for ($i = $startYear; $i < $endYear; $i++) {
    $insert = $pdo->prepare("INSERT INTO years (start, end, is_closed, created_at) VALUES (?, ?, ?, NOW())");
    $insert->execute([$i, $i + 1, ($endYear === ($i + 1) )? 0 : 1]);
}

$statement = $pdo->query('SELECT id FROM levels');
$levels = $statement->fetchAll();

foreach ($levels as $level) {
    for ($i=0; $i < 5 ; $i++) {
        $name = "Cours - $i";
        $credits = random_int(1, 8);
        $insert = $pdo->prepare("INSERT INTO courses (name, credits, level_id, created_at) VALUES (?, ?, ?, NOW())");
        $insert->execute([$name, $credits, $level['id']]);
    }
}
