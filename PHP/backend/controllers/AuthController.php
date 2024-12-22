<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php');

class AuthController
{
    public static function login(User $user)
    {
        $_SESSION ['username'] = $user->getUsername();
    }

    public static function logout()
    {

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
}

?>