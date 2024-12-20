<?php

require_once('AbstractController.php');
require_once('../models/User.php');
require_once('DBController.php');
class UserController extends AbstractController
{
    public static function create()
    {
        //Sanificazione input
        $input['email'] = InputController::SanitizeInput($_POST['email']);
        $input['username'] = InputController::SanitizeInput(($_POST['username']));
        $input['password'] = InputController::SanitizeInput($_POST['password']);
        $password_confirmation = InputController::SanitizeInput(($_POST['password_confirmation']));
        $input['nome'] = InputController::SanitizeInput($_POST['nome']);
        $input['cognome'] = InputController::SanitizeInput($_POST['cognome']);
        $input['suggerimento_password'] = InputController::SanitizeInput($_POST['suggerimento_password']);

        //Hashing password
        $input['password'] = password_hash($input['password'], PASSWORD_BCRYPT);

        //Logica di salvataggio
        if(!UserController::isDuplicate($input['username'], email: $input['email']))
        {
            $user = new User($input);
            $user->save();
            return true;
        }
        return "L'utente è duplicato";

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
    //Autenticazione


}

//TESTS
/*if (!UserController::isDuplicate('testuser', 'testuser@example.com')) {
=======


    //Getters

    public static function getUserByEmail($email)
    {
        $conn = DBController::connect();
        $sql = "SELECT * FROM utente WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows>0)
        {
            $user = new User($result->fetch_assoc());
            return $user;
        }
    }

}


if (!UserController::isDuplicate('testuser', 'testuser@example.com')) {
    $_POST['email'] = 'testuser@example.com';
    $_POST['username'] = 'testuser';
    $_POST['password'] = 'password123';
    $_POST['password_confirmation'] = 'password123';
    $_POST['nome'] = 'John';
    $_POST['cognome'] = 'Doe';
    $_POST['suggerimento_password'] = 'Password suggerimento_password example';

    UserController::create();
}

