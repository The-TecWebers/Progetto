<?php
require('./controllers/DBController.php');

$conn = DBController::connect();
// Create database
$sql = "CREATE DATABASE IF NOT EXISTS EdilScavi";
if ($conn->query($sql) !== TRUE) {
  die("Error creating database: " . $conn->error);
}

//Creazione tabelle
$sql=file_get_contents(realpath("./../../DB/edilscavi.sql"));
if($conn->multi_query($sql)!==TRUE)
{
  die("Error creating database: " . $conn->error);
}

$conn->close();
