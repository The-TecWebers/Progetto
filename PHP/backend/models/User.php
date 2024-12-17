<?php
include('InputController.php');
class User
{
    private $username;
    private $password;
    private $email;
    private $name;
    private $surname;
    private $suggerimento_password;

    function __construct(array $array)
    {
        $this->email = $array['email'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->name = $array['username'];
        $this->suggerimento_password = $array['suggerimento_password'];
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getSurname()
    {
        return $this->surname;
    }
    public function getsuggerimento_password()
    {
        return $this->suggerimento_password;
    }
    
    public function save()
    {
        DBController::runQuery("INSERT INTO utente (username, email, password, suggerimento_password, nome, cognome) VALUES (?,?,?,?,?,?);", $this->username, $this->email, $this->password, $this->suggerimento_password, $this->name, $this->surname);
    }
}