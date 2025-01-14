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
        $_SESSION['telefono*'] = $_POST['telefono'] ?? null;
        $_SESSION['username*'] = $_POST['username'] ?? null;
        $_SESSION['password*'] = $_POST['password'] ?? null;
        $_SESSION['password_confirmation*'] = $_POST['password_confirmation'] ?? null;

        $result = UserController::create();

        if ($result === true) {
            $_SESSION['error-reg'] = null;
            if(!isset($_GET['intended']))
            {
                header('Location: area_privata.php');
            }
            else
            {
                $route = $_GET['intended'];
                if($route == "lista_preventivi")
                {
                    header('Location: lista_preventivi.php');
        
                }
                elseif($route == "crea_preventivo")
                {
                    header('Location: crea_preventivo.php');
                }
                else
                {
                    header('Location: 500.php');
                }
            }
        }
        else {
            $_SESSION['error-reg'] = $result;
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
                if($route == "lista_preventivi")
                {
                    header('Location: lista_preventivi.php');
        
                }
                elseif($route == "crea_preventivo")
                {
                    header('Location: crea_preventivo.php');
                }
                else
                {
                    header('Location: 500.php');
                }
            }
        }
        else{
            $_SESSION['error-login'] = $result;
            header("Location: accedi.php");
        }
    }
    elseif ($action == "private_area") {
        $_SESSION['nome*'] = $_POST['nome'] ?? null;
        $_SESSION['cognome*'] = $_POST['cognome'] ?? null;
        $_SESSION['email*'] = $_POST['email'] ?? null;
        $_SESSION['telefono*'] = $_POST['telefono'] ?? null;
        $_SESSION['username*'] = $_POST['username'] ?? null;
        $_SESSION['old_password*'] = $_POST['old_password'] ?? null;
        $_SESSION['new_password*'] = $_POST['new_password'] ?? null;
        $_SESSION['repeated_password*'] = $_POST['repeated_password'] ?? null;

        $result = UserController::update();

        if ($result === true) {
            $_SESSION['error-priv-area'] = null;
        }
        else {
            $_SESSION['error-priv-area'] = $result;
        }

        header('Location: area_privata.php');
    }
    elseif ($action == "delete_user") {
        $result = UserController::delete();

        if ($result === true) {
            AuthController::logout();
        }
        else {
            header('Location: area_privata.php');
        }
    }
}
