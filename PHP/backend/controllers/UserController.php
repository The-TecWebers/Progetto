<?php

require_once 'AbstractController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php';
require_once 'DBController.php';

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

        AuthController::login($user);

        return true;
    }

    public static function read()
    {
        if(isset($_SESSION['nome']) && isset($_SESSION['cognome']) && isset($_SESSION['email']) && isset($_SESSION['username'])){
            $userData = [
                'nome' => $_SESSION['nome'],
                'cognome' => $_SESSION['cognome'],
                'email' => $_SESSION['email'],
                'username' => $_SESSION['username']
            ];
            return $userData;
        }

        return false;
    }

    public static function update()
    {
    }

    public static function delete()
    {
    }

    public static function login()
    {
        if(InputController::loginFieldsNotEmpty($_POST) !== true)
        {
            return InputController::loginFieldsNotEmpty($_POST);
        }

        $sanitized = InputController::sanitizeLogin($_POST);

        $username = $sanitized['username'];
        $password = $sanitized['password'];

        $user = self::getUserByUsername($username);

        if ($user == null) {
            return "<ul class=\"errorMessages\"><li>Credenziali non valide</li></ul>";
        }
        
        $userPassword = $user->getPassword();

        if(!password_verify($password, $userPassword))
        {
            return "<ul class=\"errorMessages\"><li>Credenziali non valide</li></ul>";
        }

        AuthController::login($user);

        return true;
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

        if($result === false)
        {
            return false;
        }

        if(count($result)>0)
        {
            $user = new User($result);
            return $user;
        }
    }

    public static function getUserByUsername($username)
    {
        $result = DBController::runQuery("SELECT * FROM utente WHERE username = ?", $username);

        if($result === false)
        {
            return false;
        }

        if(count($result)>0)
        {
            $user = new User($result);
            return $user;
        }
    }

}