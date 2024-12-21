<?php

require_once(__DIR__."/backend/controllers/DBController.php");
$conn = DBController::connect();
$sql = file_get_contents(__DIR__ . "/../DB/edilscavi.sql");
if ($conn->multi_query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
} else {
    echo "Database tables created successfully.";
}
$conn->close();

?>
