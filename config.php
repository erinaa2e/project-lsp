<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbHost = "localhost";
$dbName = "oceango";
$dbUser = "root";
$dbPass = "";

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    $pdo = null;
}

define("APP_NAME", "Oceango");
define("CURRENCY", "Rp");
?>