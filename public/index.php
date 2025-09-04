<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

try {
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
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Chemin vers les vues
define("BASE_VIEW_PATH", __DIR__ . '/../views');
define('BASE_RESOURCE', dirname($_SERVER['SCRIPT_NAME']) . 'assets');

$url = $_SERVER['REQUEST_URI'] ?? '/';

switch ($url) {
    case '/':
        require BASE_VIEW_PATH . '/welcome.php';
        break;

    default:
        http_response_code(404);
        require BASE_VIEW_PATH . '/404.php';
}
