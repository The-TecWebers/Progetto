<?php
require_once(__DIR__ . '/PHP/backend/controllers/UserController.php');
require_once(__DIR__.'/PHP/backend/controllers/AuthController.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;
    
    if ($action === 'register') {
        if (UserController::create()) {
            header('Location: accedi.php');
        } 
    }
    elseif ($action == "login") {
        $sanitized = InputController::SanitizeInput($_POST);

        $username = $sanitized['username'];
        $password = $sanitized['password'];

        $user = UserController::getUserByUsername($username);
        
        if ($user != null) {
            $userPassword = $user->getPassword();
            
            if (password_verify($password, $userPassword)) {
                AuthController::login($user);
                var_dump($_SESSION);
            }
        }
    }
}

