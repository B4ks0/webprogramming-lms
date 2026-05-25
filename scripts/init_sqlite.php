<?php

$root = dirname(__DIR__);
$databaseDir = $root . '/database';
$databasePath = $databaseDir . '/database.sqlite';
$schemaPath = $databaseDir . '/schema_sqlite.sql';

if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0777, true);
}

if (!file_exists($schemaPath)) {
    fwrite(STDERR, "Schema file not found: {$schemaPath}" . PHP_EOL);
    exit(1);
}

$pdo = new PDO('sqlite:' . $databasePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec(file_get_contents($schemaPath));

echo "SQLite database created: {$databasePath}" . PHP_EOL;
