<?php

require_once('UserController.php');

class InputController
{
    public static function registrationFieldsNotEmpty($array): bool|string
    {
        // Controlla che tutti i campi siano presenti
        if (empty($array) ||
            !isset($array["nome"]) ||
            !isset($array["cognome"]) ||
            !isset($array["email"]) ||
            !isset($array["username"]) ||
            !isset($array["password1"]) ||
            !isset($array["password2"]) ||
            !isset($array["suggerimento_password"])) {
            return "Per favore, compila tutti i campi";
        }

        return true;
    }

    public static function sanitizeRegistration($array): array
    {
        $sanitized = [];

        $sanitized['password'] = strip_tags($array['password']);

        $sanitized['password_confirmation'] = strip_tags($array['password_confirmation']);

        foreach ($array as $key => $value) {
            if ($key != 'password' && $key != 'password_confirmation') {
                $sanitized[$key] = htmlentities(strip_tags(trim($value)));
            }
        }

        $sanitized['email'] = filter_var($sanitized['email'], FILTER_SANITIZE_EMAIL);

        return $sanitized;
    }

    public static function validateRegistration($array): bool|string
    {
        // Validazioni dei campi
        // ...
        // Bisogna pensare proprio al sistema alla validazione, cioè a come vogliamo che i risultati siano restituiti all'utente!
        // Il ritornare una stringa è una soluzione per lo sviluppatore, non per l'utente finale
        // La Gaggi ha creato un tag <ul> mostrando i messaggi di errore in <li>. Questo è un esempio di come si può fare.
        // ...
        $name = $array['nome'];
        $surname = $array['cognome'];
        $email = $array['email'];
        $username = $array['username'];
        $pass1 = $array['password'];
        $pass2 = $array['password_confirmation'];

        if(self::isName($name) !== true){
            return self::isName($name);
        }
        if(self::isSurname($surname) !== true){
            return self::isSurname($surname);
        }
        if (self::isMail($email) !== true) {
            return self::isMail($email);
        }
        if (self::isUsername($username) !== true) {
            return self::isUsername($username);
        }
        if (self::isPassword($pass1) !== true) {
            return self::isPassword($pass1);
        }

        if ($pass1 != $pass2) {
            return "Le <span lang=\"en\">password</span> non sono uguali";
        }

        // Controllo univocità dello username
        if (UserController::getUserByUsername($username)) {
            return "Esiste già un utente registrato con questo <span lang=\"en\">username</span>";
        }

        // Controllo univocità della email
        if (UserController::getUserByEmail($email)) {
            return "Esiste già un utente registrato con questa <span lang=\"en\">email</span>";
        }

        return true;
    }

    private static function isName($name): bool|string
    {
        $name_pattern = '/^[a-zA-ZàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚçÇñÑ\-\s]{2,40}$/';
        if (!preg_match($name_pattern, $name)) {
            return "Il nome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
        }
        return true;
    }
    
    private static function isSurname($surname): bool|string
    {
        $surname_pattern = '/^[a-zA-ZàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚçÇñÑ\-\s]{2,40}$/';
        if (!preg_match($surname_pattern, $surname)) {
            return "Il cognome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
        }
        return true;
    }
    
    private static function isMail($mail): bool|string
    {
        if (strlen($mail) > 256) {
            return "La <span lang=\"en\">mail</span> può essere lunga al massimo 256 caratteri";
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return "<span lang=\"en\">Mail</span> non valida";
        }
        return true;
    }
    
    private static function isUsername($username): bool|string
    {
        $username_pattern = '/^[\wàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚçÇñÑ\-]{1,40}$/';
        if (!preg_match($username_pattern, $username)) {
            return "<span lang=\"en\">Username</span> può contenere solo lettere, numeri, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri";
        }
        return true;
    }
    
    private static function isPassword($pass): bool|string
    {
        $password_pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\s])[\S]{8,256}$/';
        if (!preg_match($password_pattern, $pass)) {
            return "La <span lang=\"en\">password</span> deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, un carattere minuscolo, un numero e un carattere speciale";
        }
        return true;
    }

    public static function hashPassword($password): string|null
    {
        if($password!=null)
        {
            return password_hash($password, PASSWORD_BCRYPT);
        }
        return null;
    }

    public static function loginFieldsNotEmpty($array): bool
    {
        if (empty($array) ||
            !isset($array["username"]) ||
            !isset($array["password"])) {
            return "Per favore, compila tutti i campi";
        }

        return true;
    }

    public static function sanitizeLogin($array): array
    {
        $sanitized = [];

        $sanitized['username'] = htmlentities(strip_tags(trim($array['username'])));
        $sanitized['password'] = strip_tags($array['password']);

        return $sanitized;
    }
}

?>