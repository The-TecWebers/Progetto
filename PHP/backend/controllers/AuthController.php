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
}

?>