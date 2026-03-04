<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR. "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "DBController.php";

$conn = DBController::connect();
$sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'edilscavi.sql');
if ($conn->multi_query($sql) !== true) {
    die("Error creating database: " . $conn->error . PHP_EOL);
} else {
    echo "Database tables created successfully." . PHP_EOL;
}
$conn->close();
