<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'minishop_cse485');
define('DB_USER', 'root');
define('DB_PASS', '');

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS,$options);
            } catch (PDOException $e) {
                die("Lỗi kết nối CSDL: " . htmlspecialchars($e->getMessage()));
            }
        }
        return self::$instance;
    }
}