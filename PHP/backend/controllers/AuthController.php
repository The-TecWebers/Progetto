<?php
include('../models/User.php');
class AuthController
{
    public static function login(User $user)
    {
        session_start();
        $_SESSION['username'] = $user->getUsername();
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
}