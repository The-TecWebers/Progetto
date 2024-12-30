<?php

require_once 'UserController.php';

class InputController
{
    public static function registrationFieldsNotEmpty($array): bool|string
    {
        // Controlla che tutti i campi siano presenti
        if (empty($array) ||
            empty($array["nome"]) ||
            empty($array["cognome"]) ||
            empty($array["email"]) ||
            empty($array["username"]) ||
            empty($array["password"]) ||
            empty($array["password_confirmation"])) {

            return "<ul class=\"errorMessages\"><li>Per favore, compila tutti i campi</li></ul>";
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
        $errorMessages = "<ul class=\"errorMessages\">";

        $name = $array['nome'];
        $surname = $array['cognome'];
        $email = $array['email'];
        $username = $array['username'];
        $pass1 = $array['password'];
        $pass2 = $array['password_confirmation'];

        if(self::isName($name) !== true){
            $errorMessages .= self::isName($name);
        }
        if(self::isSurname($surname) !== true){
            $errorMessages .= self::isSurname($surname);
        }
        if (self::isMail($email) !== true) {
            $errorMessages .= self::isMail($email);
        }
        if (self::isUsername($username) !== true) {
            $errorMessages .= self::isUsername($username);
        }
        if (self::isPassword($pass1) !== true) {
            $errorMessages .= self::isPassword($pass1);
        }

        if ($pass1 != $pass2) {
            $errorMessages .= "<li>Le <span lang=\"en\">password</span> non sono uguali</li>";
        }

        // Controllo univocità dello username
        if (UserController::isUsernameDuplicate($username) === true) {
            $errorMessages .= "<li>Esiste già un utente registrato con questo <span lang=\"en\">username</span></li>";
        }

        // Controllo univocità della email
        if (UserController::isEmailDuplicate($email) === true) {
            $errorMessages .= "<li>Esiste già un utente registrato con questa <span lang=\"en\">email</span></li>";
        }

        $errorMessages .= "</ul>";

        if ($errorMessages != "<ul class=\"errorMessages\"></ul>") {
            return $errorMessages;
        }

        return true;
    }

    private static function isName($name): bool|string
    {
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $name_pattern = '/^[a-zA-Z' . $accentedCharacters . '\-\s]{2,40}$/';
        if (!preg_match($name_pattern, $name)) {
            return "<li>Il nome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
        }
        return true;
    }
    
    private static function isSurname($surname): bool|string
    {
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $surname_pattern = '/^[a-zA-Z' . $accentedCharacters . '\-\s]{2,40}$/';
        if (!preg_match($surname_pattern, $surname)) {
            return "<li>Il cognome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
        }
        return true;
    }
    
    private static function isMail($mail): bool|string
    {
        if (strlen($mail) > 256) {
            return "<li>La <span lang=\"en\">mail</span> può essere lunga al massimo 256 caratteri</li>";
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return "<li><span lang=\"en\">Mail</span> non valida</li>";
        }
        return true;
    }
    
    private static function isUsername($username): bool|string
    {
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $username_pattern = '/^[\w' . $accentedCharacters . '\-]{1,40}$/';
        if (!preg_match($username_pattern, $username)) {
            return "<li>Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri</li>";
        }
        return true;
    }
    
    private static function isPassword($pass): bool|string
    {
        $password_pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\s])[\S]{8,256}$/';
        if (!preg_match($password_pattern, $pass)) {
            return "<li>La <span lang=\"en\">password</span> deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, un carattere minuscolo, un numero e un carattere speciale</li>";
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

    public static function loginFieldsNotEmpty($array): bool|string
    {
        if (empty($array) ||
            !isset($array["username"]) ||
            !isset($array["password"])) {
            return "<ul class=\"errorMessages\"><li>Per favore, compila tutti i campi</li></ul>";
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