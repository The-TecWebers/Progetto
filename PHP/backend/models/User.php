<?php

include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'InputController.php');

class User
{
    private $username;
    private $password;
    private $email;
    private $nome;
    private $cognome;

    function __construct(array $array)
    {
        $this->email = $array['email'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->nome = $array['nome'];
        $this->cognome = $array['cognome'];
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getName()
    {
        return $this->nome;
    }
    public function getSurname()
    {
        return $this->cognome;
    }
    
    public function save()
    {
        DBController::runQuery("INSERT INTO utente (username, email, password, nome, cognome) VALUES (?,?,?,?,?);", $this->username, $this->email, $this->password, $this->nome, $this->cognome);
    }
}