<?php
require_once(__DIR__.'/../models/User.php');
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