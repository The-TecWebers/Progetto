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
<<<<<<< HEAD
        $this->name = $array['nome'];
        $this->surname = $array['cognome'];
=======
        $this->name = $array['username'];
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
        $this->suggerimento_password = $array['suggerimento_password'];
    }

    public function getEmail()
    {
        return $this->email;
    }
<<<<<<< HEAD
    public function getUsername()
    {
        return $this->username;
    }
=======
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
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
<<<<<<< HEAD
=======
    
>>>>>>> 7f5a842 (Aggiunto model User, aggiunto getter su controller, uniformato input come su database)
    public function save()
    {
        DBController::runQuery("INSERT INTO utente (username, email, password, suggerimento_password, nome, cognome) VALUES (?,?,?,?,?,?);", $this->username, $this->email, $this->password, $this->suggerimento_password, $this->name, $this->surname);
    }
}