<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'UserController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;
    
    if ($action === 'register') {
        $_SESSION['nome*'] = $_POST['nome'] ?? null;
        $_SESSION['cognome*'] = $_POST['cognome'] ?? null;
        $_SESSION['email*'] = $_POST['email'] ?? null;
        $_SESSION['username*'] = $_POST['username'] ?? null;
        $_SESSION['password*'] = $_POST['password'] ?? null;
        $_SESSION['password_confirmation*'] = $_POST['password_confirmation'] ?? null;

        $result = UserController::create();

        if ($result === true) {
            $_SESSION['error-reg'] = null;
            header('Location: area_privata.php');
        }
        else {
            $_SESSION['error-reg'] = $result;

            $arrayString = "Array: " . print_r($_SESSION, true);
            error_log($arrayString, 3, 'mio_log.log');

            header("Location: registrati.php");
        }
    }
    elseif ($action == "login") {
        $_SESSION['username*'] = $_POST['username'] ?? null;
        $_SESSION['password*'] = $_POST['password'] ?? null;

        $result = UserController::login();
        if ($result === true) {
            $_SESSION['error-login'] = null;
            if(!isset($_GET['intended']))
            {
                header('Location: area_privata.php');
            }
            else
            {
                $route = $_GET['intended'];
                header('Location:'.$route.'.php');
            }
        }
        else{
            $_SESSION['error-login'] = $result;
            header("Location: accedi.php");
        }
    }
}