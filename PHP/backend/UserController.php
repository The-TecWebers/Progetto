<?php

include('AbstractController.php');
include('InputController.php');
require('DBController.php');
class UserController extends AbstractController
{
    public static function create()
    {
        $email = InputController::SanitizeInput($_POST['email']);
        $username = InputController::SanitizeInput(($_POST['username']));
        $password = InputController::SanitizeInput($_POST['password']);
        $password_confirmation = InputController::SanitizeInput(($_POST['password_confirmation']));
        $name = InputController::SanitizeInput($_POST['name']);
        $surname = InputController::SanitizeInput($_POST['surname']);
        $hint = InputController::SanitizeInput($_POST['hint']);

        $pass = password_hash($password, PASSWORD_BCRYPT);

        DBController::runQuery("INSERT INTO utente (username, email, password, suggerimento_password, nome, cognome) VALUES (?,?,?,?,?,?);", $username, $email, $pass, $hint, $name, $surname);
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

    public static function isDuplicate($username, $email)
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

}
if (!UserController::isDuplicate('testuser', 'testuser@example.com')) {
    $_POST['email'] = 'testuser@example.com';
    $_POST['username'] = 'testuser';
    $_POST['password'] = 'password123';
    $_POST['password_confirmation'] = 'password123';
    $_POST['name'] = 'John';
    $_POST['surname'] = 'Doe';
    $_POST['hint'] = 'Password hint example';

    UserController::create();
}



