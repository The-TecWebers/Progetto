<?php

require_once('AbstractController.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php');
require_once('DBController.php');

class UserController extends AbstractController
{
    public static function create(): bool|string
    {
        $input = $_POST;

        if(InputController::registrationFieldsNotEmpty($input) !== true)
        {
            return InputController::registrationFieldsNotEmpty($input);
        }

        if(InputController::validateRegistration($input) !== true)
        {
            return InputController::validateRegistration($input);
        }

        $input = InputController::sanitizeRegistration($input);

        $input['password'] = InputController::hashPassword($input['password']);

        $user = new User($input);
        $user->save();

        error_log("Utente registrato con successo", 3, "miolog.log");

        return true;
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

    public static function isUsernameDuplicate($username): bool
    {
        $result=DBController::runQuery("SELECT username FROM utente WHERE username = ?", $username);
        if ($result && count($result) > 0) {
            return true;
        }
        return false;
    }

    public static function isEmailDuplicate($email): bool
    {
        $result=DBController::runQuery("SELECT username FROM utente WHERE email = ?", $email);
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

    public static function getUserByUsername($username)
    {
        $result = DBController::runQuery("SELECT * FROM utente WHERE username = ?", $username);
        if(count($result)>0)
        {
            $user = new User($result);
            return $user;
        }
    }

}

?>
