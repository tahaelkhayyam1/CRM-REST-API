<?php

require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$migrationPath = __DIR__ . '/database/migrations/';
$files = scandir($migrationPath);

foreach ($files as $file) {

    // Ignore system files and only allow .php files
    if (
        $file === '.' ||
        $file === '..' ||
        pathinfo($file, PATHINFO_EXTENSION) !== 'php'
    ) {
        continue;
    }

    $sql = require $migrationPath . $file;

    try {
        $conn->exec($sql);
        echo "Migration executed: " . $file . PHP_EOL;

    } catch (PDOException $e) {
        echo "Migration failed: " . $file . " -> " . $e->getMessage() . PHP_EOL;
    }
}