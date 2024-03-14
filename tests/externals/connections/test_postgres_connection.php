<?php

require_once '../../bootstrap.php';

// Database configuration
$dsn = sprintf(
    '%s:host=%s;dbname=%s;port=%s',
    'pgsql',
    $_ENV['DB_HOST'],
    $_ENV['DB_DATABASE'],
    $_ENV['DB_PORT'] ?? '5432',
);
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Connected successfully to PostgreSQL!";
} catch (Throwable $e) {
    die("Connection failed: " . $e->getMessage() . PHP_EOL);
}
