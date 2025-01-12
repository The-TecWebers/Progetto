<?php

require_once 'UserController.php';

class InputController
{
    /*
    ==================
    CHECK FORM FIELDS
    ==================
    */

    private static function isName($name): bool|string
    {
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $name_pattern = '/^[a-zA-Z' . $accentedCharacters . '\'\-\s]{2,40}$/';
        if (!preg_match($name_pattern, $name)) {
            return "<li>Il nome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
        }
        return true;
    }

    private static function isSurname($surname): bool|string
    {
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $surname_pattern = '/^[a-zA-Z' . $accentedCharacters . '\'\-\s]{2,40}$/';
        if (!preg_match($surname_pattern, $surname)) {
            return "<li>Il cognome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
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

    private static function isPhoneNumber($phoneNumber): bool|string
    {
        // Remove any existing spaces
        $phoneNumber = str_replace(' ', '', $phoneNumber);

        $phoneNumber_pattern = '/^(\+\d{2})?(\d{9,10})$/';

        if (!preg_match($phoneNumber_pattern, $phoneNumber)) {
            return "<li>Il numero di telefono deve essere valido!</li>";
        }

        return true;
    }

    private static function isUsername($username): bool|string
    {
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $username_pattern = '/^[\w' . $accentedCharacters . '\'\-]{1,40}$/';
        if (!preg_match($username_pattern, $username)) {
            return "<li>Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, apostrofi, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri</li>";
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



    /*
    ==================
    FORMAT FORM FIELDS
    ==================
    */

    public static function hashPassword($password): string|null
    {
        if ($password != null) {
            return password_hash($password, PASSWORD_BCRYPT);
        }
        return null;
    }

    public static function formatPhoneNumber($phoneNumber): string
    {
        // Remove any existing spaces
        $phoneNumber = str_replace(' ', '', $phoneNumber);

        // Check if the phone number starts with a '+'
        if (strpos($phoneNumber, '+') === 0) {
            // Format the phone number with spaces
            $phoneNumber = preg_replace('/(\+\d{2})(\d{3})(\d{3})(\d{3,4})/', '$1 $2 $3 $4', $phoneNumber);
        } else {
            // Add the '+39 ' prefix and format the phone number with spaces
            $phoneNumber = preg_replace('/(\d{3})(\d{3})(\d{3,4})/', '+39 $1 $2 $3', $phoneNumber);
        }

        return $phoneNumber;
    }



    /*
    ============
    CHECK FORMS
    ============
    */

    public static function registrationFieldsNotEmpty($array): bool|string
    {
        // Controlla che tutti i campi siano presenti
        if (
            empty($array) ||
            empty($array["nome"]) ||
            empty($array["cognome"]) ||
            empty($array["email"]) ||
            empty($array["telefono"]) ||
            empty($array["username"]) ||
            empty($array["password"]) ||
            empty($array["password_confirmation"])
        ) {

            return "<ul class=\"errorMessages\"><li>Per favore, compila tutti i campi</li></ul>";
        }

        return true;
    }

    public static function validateRegistration($array): bool|string
    {
        $errorMessages = "<ul class=\"errorMessages\">";

        $name = $array['nome'];
        $surname = $array['cognome'];
        $email = $array['email'];
        $phoneNumber = $array['telefono'];
        $username = $array['username'];
        $pass1 = $array['password'];
        $pass2 = $array['password_confirmation'];

        if (self::isName($name) !== true) {
            $errorMessages .= self::isName($name);
        }
        if (self::isSurname($surname) !== true) {
            $errorMessages .= self::isSurname($surname);
        }
        if (self::isMail($email) !== true) {
            $errorMessages .= self::isMail($email);
        }
        else {
            // Controllo univocità della email
            if (UserController::isEmailDuplicate($email) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questa <span lang=\"en\">email</span></li>";
        }
        }
        if (self::isPhoneNumber($phoneNumber) !== true) {
            $errorMessages .= self::isPhoneNumber($phoneNumber);
        }
        else {
            $phoneNumber = InputController::formatPhoneNumber($phoneNumber);

            // Controllo univocità del numero di telefono
            if (UserController::isPhoneNumberDuplicate($phoneNumber) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo numero di telefono</li>";
        }
        }
        if (self::isUsername($username) !== true) {
            $errorMessages .= self::isUsername($username);
        }
        else {
            // Controllo univocità dello username
            if (UserController::isUsernameDuplicate($username) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo <span lang=\"en\">username</span></li>";
        }
        }
        if (self::isPassword($pass1) !== true) {
            $errorMessages .= self::isPassword($pass1);
        }

        if ($pass1 != $pass2) {
            $errorMessages .= "<li>Le <span lang=\"en\">password</span> non sono uguali</li>";
        }

        $errorMessages .= "</ul>";

        if ($errorMessages != "<ul class=\"errorMessages\"></ul>") {
            return $errorMessages;
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

    public static function loginFieldsNotEmpty($array): bool|string
    {
        if (
            empty($array) ||
            empty($array["username"]) ||
            empty($array["password"])
        ) {
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

    public static function checkLogin($array): User|string
    {
        $username = $array['username'];
        $password = $array['password'];

        $user = UserController::getUserByUsername($username);

        if ($user == null) {
            return "<ul class=\"errorMessages\"><li>Credenziali non valide</li></ul>";
        }

        $userPassword = $user->getPassword();

        if (!password_verify($password, $userPassword)) {
            return "<ul class=\"errorMessages\"><li>Credenziali non valide</li></ul>";
        }

        return $user;
    }

    public static function privateAreaFieldsNotEmpty($array): bool|string
    {
        $personal_data_error = false;
        $change_password_error = false;

        // Check Dati personali
        if (
            empty($array) ||
            empty($array["nome"]) ||
            empty($array["cognome"]) ||
            empty($array["email"]) ||
            empty($array["telefono"]) ||
            empty($array["username"])
        ) {
            $personal_data_error = true;
        }

        // Check cambio password
        if (
            (empty($array['old_password']) || empty($array['new_password']) || empty($array['repeated_password'])) &&
            (!empty($array['old_password']) || !empty($array['new_password']) || !empty($array['repeated_password']))
        ) {
            $change_password_error = true;
        }

        // Restituzione congiunta
        if ($personal_data_error === true && $change_password_error === true) {
            return "<ul class=\"errorMessages\"><li>Per favore, compila tutti i campi, se desideri anche cambiare la password</li></ul>";
        }
        if ($personal_data_error === true) {
            return "<ul class=\"errorMessages\"><li>Per favore, compila tutti i dati personali</li></ul>";
        }
        if ($change_password_error === true) {
            return "<ul class=\"errorMessages\"><li>Per favore, compila tutti i dati per il cambio password, se desideri cambiarla</li></ul>";
        }

        return true;
    }

    public static function validatePrivateArea($array): bool|string
    {
        $errorMessages = "<ul class=\"errorMessages\">";

        $name = $array['nome'];
        $surname = $array['cognome'];
        $email = $array['email'];
        $phoneNumber = $array['telefono'];
        $username = $array['username'];
        $old_pass = $array['old_password'] ?? null;
        $new_pass = $array['new_password'] ?? null;
        $conf_pass = $array['repeated_password'] ?? null;

        // Validazione dati personali
        if (self::isName($name) !== true) {
            $errorMessages .= self::isName($name);
        }
        if (self::isSurname($surname) !== true) {
            $errorMessages .= self::isSurname($surname);
        }
        if (self::isMail($email) !== true) {
            $errorMessages .= self::isMail($email);
        }
        else {
            // Se la email è cambiata, controllo univocità della email
            if ($email != $_SESSION['email']  &&  UserController::isEmailDuplicate($email) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questa <span lang=\"en\">email</span></li>";
            }
        }
        if (self::isPhoneNumber($phoneNumber) !== true) {
            $errorMessages .= self::isPhoneNumber($phoneNumber);
        }
        else {
            $phoneNumber = InputController::formatPhoneNumber($phoneNumber);

            // Se il numero di telefono è cambiato, controllo univocità del numero di telefono
            if ($phoneNumber != $_SESSION['telefono']  &&  UserController::isPhoneNumberDuplicate($phoneNumber) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo numero di telefono</li>";
            }
        }
        if (self::isUsername($username) !== true) {
            $errorMessages .= self::isUsername($username);
        }
        else {
            // Se lo username è cambiato, controllo univocità dello username
            if ($username != $_SESSION['username']  &&  UserController::isUsernameDuplicate($username) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo <span lang=\"en\">username</span></li>";
            }
        }

        // Validazione cambio password
        if (!empty($old_pass) && !empty($new_pass) && !empty($conf_pass)) {
            $username = $_SESSION['username'];
            $user = UserController::getUserByUsername($username);
            $userPassword = $user->getPassword();

            if (!password_verify($old_pass, $userPassword)) {
                $errorMessages .= "<li>La <span lang=\"en\">password</span> attuale non è corretta</li>";
            }

            if (self::isPassword($new_pass) !== true) {
                $errorMessages .= self::isPassword($new_pass);
            }

            if ($new_pass != $conf_pass) {
                $errorMessages .= "<li>La <span lang=\"en\">password</span> ripetuta non è uguale alla nuova <span lang=\"en\">password</span></li>";
            }
        }

        $errorMessages .= "</ul>";

        if ($errorMessages != "<ul class=\"errorMessages\"></ul>") {
            return $errorMessages;
        }

        return true;
    }

    public static function sanitizePrivateArea($array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            if ($key != 'old_password' && $key != 'new_password' && $key != 'repeated_password') {
                $sanitized[$key] = htmlentities(strip_tags(trim($value)));
            }
        }

        $sanitized['email'] = filter_var($sanitized['email'], FILTER_SANITIZE_EMAIL);

        if (!empty($array['old_password']) && !empty($array['new_password']) && !empty($array['repeated_password'])) {
            $sanitized['old_password'] = strip_tags($array['old_password']);
            $sanitized['new_password'] = strip_tags($array['new_password']);
            $sanitized['repeated_password'] = strip_tags($array['repeated_password']);
        }

        return $sanitized;
    }

    public static function sanitizePreventivo($array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        return $sanitized;
    }

    public static function sanitizeAll($array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            $sanitized[$key] = htmlentities(strip_tags(trim($value)));
        }

        return $sanitized;
    }

    public static function cropImage($file, $maxDimension)
    {
        $fileTmpPath = $_FILES["foto"]["tmp_name"];
        $fileName = $_FILES["foto"]["name"];
        $fileSize = $_FILES["foto"]["size"];
        $fileType = $_FILES["foto"]["type"];

        $imageInfo = getimagesize($fileTmpPath);
        if ($fileSize > $maxDimension) {
            $image = null;

            switch ($imageInfo['mime']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg(($fileTmpPath));
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($fileTmpPath);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($fileTmpPath);
                    break;
                default:
                    header(header: "Location: 500.php");
            }

            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;

            if ($fileSize > $maxDimension) {
                $aspectRatio = $originalWidth / $originalHeight;
    
                $newWidth = 1024;
                $newHeight = $newWidth / $aspectRatio;
            }

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            $target_dir = 'uploads' . DIRECTORY_SEPARATOR;
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            imagejpeg($resizedImage, $target_file, 85);
            imagedestroy($image);
            imagedestroy($resizedImage);

        }
        else
        {
            $target_dir = 'uploads' . DIRECTORY_SEPARATOR;
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        }
        return $target_file;
    }
}
