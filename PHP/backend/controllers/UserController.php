<?php

require_once('AbstractController.php');
<<<<<<< HEAD
require_once('AuthController.php');
=======
require_once('../models/User.php');
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
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
<<<<<<< HEAD
        $input['nome'] = InputController::SanitizeInput($_POST['nome']);
        $input['cognome'] = InputController::SanitizeInput($_POST['cognome']);
=======
        $input['name'] = InputController::SanitizeInput($_POST['name']);
        $input['surname'] = InputController::SanitizeInput($_POST['surname']);
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
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
<<<<<<< HEAD
    public static function isDuplicate($username, $email) //Controlla se esistono utenti duplicati
    {
        $result=DBController::runQuery("SELECT username FROM utente WHERE username = ? OR email = ?", $username, $email);
        if ($result && count($result) > 0) {
=======

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
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
            return true;
        }
        return false;
    }
<<<<<<< HEAD
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
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
    $_POST['email'] = 'testuser@example.com';
    $_POST['username'] = 'testuser';
    $_POST['password'] = 'password123';
    $_POST['password_confirmation'] = 'password123';
<<<<<<< HEAD
    $_POST['nome'] = 'John';
    $_POST['cognome'] = 'Doe';
=======
    $_POST['name'] = 'John';
    $_POST['surname'] = 'Doe';
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
    $_POST['suggerimento_password'] = 'Password suggerimento_password example';

    UserController::create();
}


<<<<<<< HEAD
$user = UserController::getUserByEmail("testuser@example.com");*/
=======
$user = UserController::getUserByEmail("testuser@example.com");

echo $user->getEmail();


>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)


