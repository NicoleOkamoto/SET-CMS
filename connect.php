<?php

define('DB_DSN', 'mysql:host=localhost;dbname=serverside;charset=utf8');
define('DB_USER', 'serveruser');
define('DB_PASS', 'gorgonzola7!');

try {
    // Create new PDO connection to MySQL.
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the exception
    error_log('PDO Exception: ' . $e->getMessage(), 0);

    echo 'An unexpected error occurred. Please try again later.';
    exit(); // Stop execution
}

