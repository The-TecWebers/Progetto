<?php

require_once('AbstractController.php');
require_once(__DIR__ . '/../models/User.php');
require_once('DBController.php');
class UserController extends AbstractController
{
    public static function create()
    {
        $input = InputController::SanitizeInput($_POST);
        if($input['password']==$input['password_confirmation'])
        {
            $input['password'] = InputController::HashPassword($input['password']);
            if(!UserController::isDuplicate($input['username'], email: $input['email']))
            {
                $user = new User($input);
                $user->save();
                return true;
            }
            return "L'utente è duplicato";
        }
        return 'password_confirmation_error';


    }

    public static function read()
    {
    }
    public static function update()
    {
    }
    public static function delete()
    {
    }
    public static function isDuplicate($username, $email) //Controlla se esistono utenti duplicati
    {
        $result=DBController::runQuery("SELECT username FROM utente WHERE username = ? OR email = ?", $username, $email);
        if ($result && count($result) > 0) {
            return true;
        }
        return false;
    }
    public static function getUserByEmail($email)
    {
        $result = DBController::runQuery("SELECT * FROM utente WHERE email = ?", $email);
        if(count($result)>0)
        {
            $user = new User($result);
            return $user;
        }
    }

}


