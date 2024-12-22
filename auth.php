<?php
require_once(__DIR__ . '/PHP/backend/controllers/UserController.php');
require_once(__DIR__.'/PHP/backend/controllers/AuthController.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;
    
    if ($action === 'register') {
        if (UserController::create() == true) {
            // string_replace
            header('Location: area_privata.php');
        } 
        else {
            // string_replace
            header('Location: registrati.php');
        }
    }
    elseif ($action == "login") {
        if(InputController::loginFieldsNotEmpty($_POST) !== true)
        {
            return InputController::loginFieldsNotEmpty($_POST);
        }

        $sanitized = InputController::sanitizeLogin($_POST);

        $username = $sanitized['username'];
        $password = $sanitized['password'];

        $user = UserController::getUserByUsername($username);
        
        if ($user != null) {
            $userPassword = $user->getPassword();
            
            if (password_verify($password, $userPassword)) {
                AuthController::login($user);
                // var_dump($_SESSION);   Per stampare la variabile di sessione
                header('Location: area_privata.php');
            }
            else {
                // string_replace
                header('Location: login.php');
            }
        }
        else {
            // string_replace
            header('Location: login.php');
        }
    }
}

