<?php
require('db_connect.php');
// Create database
$sql = "CREATE DATABASE IF NOT EXISTS OneSports";

if ($conn->query($sql) !== TRUE) {
  die("Error creating database: " . $conn->error);
}
/*
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}
*/

$conn->close();
?>