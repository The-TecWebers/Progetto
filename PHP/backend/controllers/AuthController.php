<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php';

class AuthController
{
    public static function login(User $user)
    {
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['nome'] = $user->getName();
        $_SESSION['cognome'] = $user->getSurname();
    }

    public static function logout()
    {
        session_destroy();
        session_abort();
        header("Location: index.php");
        exit();
    }

    public static function isLogged(){
        return isset($_SESSION["username"]);
    }
    
    public static function isAdmin(){
        if (!self::isLogged()){
            return false;
        }
        $user = UserController::getUserByUsername($_SESSION['username']);
        return $user->getIsAdmin();
    }

    public static function serverError()
    {
        http_response_code(500);
        $relativePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'pages'. DIRECTORY_SEPARATOR . '500.html';
        echo file_get_contents($relativePath);
        die();
    }

    public static function getAuthUser()
    {
        if(isset($_SESSION['email']))
        {
            $result = DBController::runQuery("SELECT * FROM utente WHERE email = ?", $_SESSION['email']);
            if($result !== false)
            {
                return new User($result);
            }
        }
        return null;
    }
}