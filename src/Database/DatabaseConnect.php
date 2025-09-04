<?php

namespace App\Database;

use PDO;
use PDOException;

abstract class DatabaseConnect
{
    private static ?PDO $instance = null;
    private const string HOST     = "localhost";
    private const string USERNAME = "root";
    private const string PWD      = "demo";
    private const string DBNAME   = "school_deliberation_app";
    private const string CHARSET  = "utf8mb4";

    /**
     * Permet de créer une seule instance de la base de données (PDO)
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;dbname=%s;charset=%s",
                    self::HOST,
                    self::DBNAME,
                    self::CHARSET
                );

                self::$instance = new PDO(
                    $dsn,
                    self::USERNAME,
                    self::PWD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
