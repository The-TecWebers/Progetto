<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'InputController.php';

class User
{
    private $id;
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
        if($array['id']!==null)
        {
            $this->id=$array['id'];
        }
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

    public function getId()
    {
        return $this->id;
    }
    
    public function save()
    {
        DBController::runQuery("INSERT INTO utente (username, email, password, nome, cognome) VALUES (?,?,?,?,?);", $this->username,
            $this->email, $this->password, $this->nome, $this->cognome);
    }

    public function update($id, array $array)
    {
        $this->username = $array['username'] ?? $this->username;
        $this->password = $array['password'] ?? $this->password;
        $this->email = $array['email'] ?? $this->email;
        $this->nome = $array['nome'] ?? $this->nome;
        $this->cognome = $array['cognome'] ?? $this->cognome;

        DBController::runQuery("UPDATE utente SET username = ?, password = ?, email = ?, nome = ?, cognome = ? WHERE id = ?;",
            $this->username, $this->password, $this->email, $this->nome, $this->cognome, $id);
    }

    public function getIsAdmin()
    {
        $result = DBController::runQuery("SELECT * FROM utente WHERE email = ? AND is_admin = 1", $this->email);
        return $result !== false;
    }
}