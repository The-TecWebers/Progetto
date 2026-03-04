<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'InputController.php';

class User
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $telefono;
    private $nome;
    private $cognome;

    public function __construct(array $array)
    {
        if($array['id']!==null)
        {
            $this->id=$array['id'];
        }
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->email = $array['email'];
        $this->telefono = $array['telefono'];
        $this->nome = $array['nome'];
        $this->cognome = $array['cognome'];
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getCognome()
    {
        return $this->cognome;
    }
    
    public function save()
    {
        DBController::runQuery("INSERT INTO utente (username, password, email, telefono, nome, cognome) VALUES (?,?,?,?,?,?);", $this->username,
        $this->password, $this->email, $this->telefono, $this->nome, $this->cognome);
    }

    public function update($id, array $array)
    {
        $this->username = $array['username'] ?? $this->username;
        $this->password = $array['password'] ?? $this->password;
        $this->email = $array['email'] ?? $this->email;
        $this->telefono = $array['telefono'] ?? $this->telefono;
        $this->nome = $array['nome'] ?? $this->nome;
        $this->cognome = $array['cognome'] ?? $this->cognome;

        DBController::runQuery("UPDATE utente SET username = ?, password = ?, email = ?, telefono = ?, nome = ?, cognome = ? WHERE id = ?;",
            $this->username, $this->password, $this->email, $this->telefono, $this->nome, $this->cognome, $id);
    }

    public function getIsAdmin()
    {
        $result = DBController::runQuery("SELECT * FROM utente WHERE email = ? AND is_admin = 1", $this->email);
        return $result !== false;
    }
}
