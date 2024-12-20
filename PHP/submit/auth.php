<?php
require_once(__DIR__ . '/../backend/controllers/UserController.php');

// Correct the typo 'REUQEST_METHOD' to 'REQUEST_METHOD'
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null; // Check if the 'action' parameter is set in the query string
    
    if ($action === 'register') {
        UserController::create(); // Call the 'create' method of UserController to register a user
    }
}
