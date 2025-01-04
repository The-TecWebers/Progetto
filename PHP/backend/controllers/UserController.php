<?php

require_once 'AbstractController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php';
require_once 'DBController.php';

class UserController extends AbstractController
{
    public static function create(): bool|string
    {
        $input = $_POST;

        $resultNotEmpty = InputController::registrationFieldsNotEmpty($input);
        if($resultNotEmpty !== true)
        {
            return $resultNotEmpty;
        }

        $resultValidation = InputController::validateRegistration($input);
        if($resultValidation !== true)
        {
            return $resultValidation;
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
        $input = $_POST;

        $resultNotEmpty = InputController::privateAreaFieldsNotEmpty($input);
        if($resultNotEmpty !== true)
        {
            return $resultNotEmpty;
        }

        $resultValidation = InputController::validatePrivateArea($input);
        if($resultValidation !== true)
        {
            return $resultValidation;
        }

        $input = InputController::sanitizePrivateArea($input);

        if (!empty($input['new_password'])) {
            $input['password'] = InputController::hashPassword($input['new_password']);
        }
        unset($input['old_password'], $input['new_password'], $input['repeated_password']);

        $user = self::getUserByUsername($_SESSION['username']);
        $userId = self::getUserId($user);

        $user->update($userId, $input);

        AuthController::login($user);

        return true;
    }

    public static function delete()
    {
    }

    public static function login()
    {
        $input = $_POST;

        $resultNotEmpty = InputController::loginFieldsNotEmpty($input);
        if($resultNotEmpty !== true)
        {
            return $resultNotEmpty;
        }

        $sanitized = InputController::sanitizeLogin($input);

        $resultValidation = InputController::checkLogin($sanitized);
        if(!$resultValidation instanceof User)
        {
            return $resultValidation;
        }

        AuthController::login($resultValidation);

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
            return new User($result);
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
            return new User($result);
        }
    }

    public static function getUserId(User $user)
    {
        $username = $user->getUsername();

        $result = DBController::runQuery("SELECT id FROM utente WHERE username = ?", $username);

        if($result === false)
        {
            return false;
        }
        
        if(count($result)>0)
        {
            return $result['id'];
        }
    }

}