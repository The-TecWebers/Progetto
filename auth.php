<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'UserController.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;
    
    if ($action === 'register') {
        $result = UserController::create();
        if ($result === true) {
            $_SESSION['error-reg'] = null;
            // string_replace dei bottoni di registrazione e login
            header('Location: area_privata.php');
        } 
        $_SESSION['error-reg'] = $result;
        header("Location: registrati.php");
    }
    elseif ($action == "login") {
        $result = UserController::login();
        if ($result === true) {
            $_SESSION['error-login'] = null;
            header('Location: area_privata.php');
        }
        $_SESSION['error-login'] = $result;
        header("Location: accedi.php");
    }
}

