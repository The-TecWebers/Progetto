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
        $input['name'] = InputController::SanitizeInput($_POST['name']);
        $input['surname'] = InputController::SanitizeInput($_POST['surname']);
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
        $conn = DBController::connect();
        $sql = "SELECT username FROM utente WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing the SQL statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }


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
    $_POST['name'] = 'John';
    $_POST['surname'] = 'Doe';
    $_POST['suggerimento_password'] = 'Password suggerimento_password example';

    UserController::create();
}


$user = UserController::getUserByEmail("testuser@example.com");

echo $user->getEmail();




