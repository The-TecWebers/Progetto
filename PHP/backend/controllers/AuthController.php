<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php');

class AuthController
{
    public static function login(User $user)
    {
        $_SESSION ['username'] = $user->getUsername();
        $_SESSION ['email'] = $user->getEmail();
        $_SESSION ['nome'] = $user->getName();
        $_SESSION ['cognome'] = $user->getSurname();
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
    
    /*
    public static function isAdmin(){
        if (!is_logged())
            return false;
        $result = user_manager::get_admin($_SESSION["username"]);
        if ($result == false || count($result) == 0)
            return false;
        return true;
    }
    */

    public static function serverError()
    {
        http_response_code(500);
        $relativePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . '500.html';
        echo file_get_contents($relativePath);
        die();
    }
}

?>