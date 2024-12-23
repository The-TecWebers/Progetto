<?php

include(__DIR__.'/../controllers/InputController.php');
class User
{
    private $username;
    private $password;
    private $email;
    private $nome;
    private $cognome;
    private $suggerimento_password;

    function __construct(array $array)
    {
        $this->email = $array['email'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->nome = $array['nome'];
        $this->cognome = $array['cognome'];
        $this->suggerimento_password = $array['suggerimento_password'];
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
    public function getSuggerimentoPassword()
    {
        return $this->suggerimento_password;
    }
    
    public function save()
    {
        DBController::runQuery("INSERT INTO utente (username, email, password, suggerimento_password, nome, cognome) VALUES (?,?,?,?,?,?);", $this->username, $this->email, $this->password, $this->suggerimento_password, $this->nome, $this->cognome);
    }
}