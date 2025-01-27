<?php

require_once 'UserController.php';

const ERROR_MESSAGES_WRAPPER = '<ul role="alert" aria-live="assertive" class="errorMessages">';
const ACCENTED_CHARACTERS = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';

class InputController
{
    /*
    ==================
    CHECK FORM FIELDS
    ==================
    */

    private static function isName($name): bool|string
    {
        $name_pattern = '/^[a-zA-Z' . ACCENTED_CHARACTERS . '\'\-\s]{2,40}$/';
        if (!preg_match($name_pattern, $name)) {
            return "<li>Il nome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
        }
        return true;
    }

    private static function isSurname($surname): bool|string
    {
        $surname_pattern = '/^[a-zA-Z' . ACCENTED_CHARACTERS . '\'\-\s]{2,40}$/';
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
        $username_pattern = '/^[\w' . ACCENTED_CHARACTERS . '\'\-]{1,40}$/';
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

    private static function isTitolo($titolo): bool|string
    {
        $titolo_pattern = '/^[a-zA-Z0-9' . ACCENTED_CHARACTERS . '\-\s]{2,40}$/';
        if (!preg_match($titolo_pattern, $titolo)) {
            return "<li>Il titolo può contenere solo lettere, numeri, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
        }

        return true;
    }

    private static function isLuogo($luogo): bool|string
    {
        $luogo_pattern = '/^[a-zA-Z0-9' . ACCENTED_CHARACTERS . '\'"\-\\s]{2,40}$/';
        if (!preg_match($luogo_pattern, $luogo)) {
            return "<li>Il luogo può contenere solo lettere, numeri, apostrofi, virgolette, trattini e spazi e deve essere lungo da 2 a 40 caratteri</li>";
        }
        return true;
    }


    private static function isDescrizione($descrizione): bool|string
    {
        $descrizione_pattern = '/^[a-zA-Z0-9' . ACCENTED_CHARACTERS . '\'"\-\\s]{2,255}$/';
        if (!preg_match($descrizione_pattern, $descrizione)) {
            return "<li>La descrizione può contenere solo lettere, numeri, apostrofi, virgolette, trattini e spazi e deve essere lunga da 2 a 255 caratteri</li>";
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
    ==============
    REGISTRAZIONE
    ==============
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

            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i campi</li></ul>";
        }

        return true;
    }

    public static function validateRegistration($array): bool|string
    {
        $errorMessages = ERROR_MESSAGES_WRAPPER;

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
        } else {
            // Controllo univocità della email
            if (UserController::isEmailDuplicate($email) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questa <span lang=\"en\">email</span></li>";
            }
        }
        if (self::isPhoneNumber($phoneNumber) !== true) {
            $errorMessages .= self::isPhoneNumber($phoneNumber);
        } else {
            $phoneNumber = InputController::formatPhoneNumber($phoneNumber);

            // Controllo univocità del numero di telefono
            if (UserController::isPhoneNumberDuplicate($phoneNumber) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo numero di telefono</li>";
            }
        }
        if (self::isUsername($username) !== true) {
            $errorMessages .= self::isUsername($username);
        } else {
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

        if ($errorMessages != ERROR_MESSAGES_WRAPPER . "</ul>") {
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
                $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)));
            }
        }

        $sanitized['email'] = filter_var($sanitized['email'], FILTER_SANITIZE_EMAIL);

        return $sanitized;
    }



    /*
    ======
    LOGIN
    ======
    */

    public static function loginFieldsNotEmpty($array): bool|string
    {
        if (
            empty($array) ||
            empty($array["username"]) ||
            empty($array["password"])
        ) {
            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i campi</li></ul>";
        }

        return true;
    }

    public static function sanitizeLogin($array): array
    {
        $sanitized = [];

        $sanitized['username'] = htmlspecialchars(strip_tags(trim($array['username'])));
        $sanitized['password'] = strip_tags($array['password']);

        return $sanitized;
    }

    public static function checkLogin($array): User|string
    {
        $username = $array['username'];
        $password = $array['password'];

        $user = UserController::getUserByUsername($username);

        if ($user == null) {
            return ERROR_MESSAGES_WRAPPER . "<li>Credenziali non valide</li></ul>";
        }

        $userPassword = $user->getPassword();

        if (!password_verify($password, $userPassword)) {
            return ERROR_MESSAGES_WRAPPER . "<li>Credenziali non valide</li></ul>";
        }

        return $user;
    }



    /*
    =============
    AREA PRIVATA
    =============
    */

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
            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i campi, se desideri anche cambiare la password</li></ul>";
        }
        if ($personal_data_error === true) {
            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i dati personali</li></ul>";
        }
        if ($change_password_error === true) {
            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i dati per il cambio password, se desideri cambiarla</li></ul>";
        }

        return true;
    }

    public static function validatePrivateArea($array): bool|string
    {
        $errorMessages = ERROR_MESSAGES_WRAPPER;

        $name = $array['nome'];
        $surname = $array['cognome'];
        $email = $array['email'];
        $phoneNumber = $array['telefono'];
        $username = $array['username'];
        $old_pass = $array['old_password'] ?? null;
        $new_pass = $array['new_password'] ?? null;
        $conf_pass = $array['repeated_password'] ?? null;

        if (self::isName($name) !== true) {
            $errorMessages .= self::isName($name);
        }
        if (self::isSurname($surname) !== true) {
            $errorMessages .= self::isSurname($surname);
        }
        if (self::isMail($email) !== true) {
            $errorMessages .= self::isMail($email);
        } else {
            if ($email != $_SESSION['email'] && UserController::isEmailDuplicate($email) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questa <span lang=\"en\">email</span></li>";
            }
        }
        if (self::isPhoneNumber($phoneNumber) !== true) {
            $errorMessages .= self::isPhoneNumber($phoneNumber);
        } else {
            $phoneNumber = InputController::formatPhoneNumber($phoneNumber);

            if ($phoneNumber != $_SESSION['telefono'] && UserController::isPhoneNumberDuplicate($phoneNumber) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo numero di telefono</li>";
            }
        }
        if (self::isUsername($username) !== true) {
            $errorMessages .= self::isUsername($username);
        } else {
            if ($username != $_SESSION['username'] && UserController::isUsernameDuplicate($username) === true) {
                $errorMessages .= "<li>Esiste già un utente registrato con questo <span lang=\"en\">username</span></li>";
            }
        }


        $errorMessages .= "</ul>";

        if ($errorMessages != ERROR_MESSAGES_WRAPPER . "</ul>") {
            return $errorMessages;
        }

        return true;
    }

    public static function sanitizePrivateArea($array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            if ($key != 'old_password' && $key != 'new_password' && $key != 'repeated_password') {
                $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)));
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



    /*
    ============
    PREVENTIVI
    ============
    */

    public static function preventivoFieldsNotEmpty($array)
    {
        if (
            empty($array) ||
            empty($array["titolo"]) ||
            empty($array["luogo"]) ||
            empty($array["descrizione"]) ||
            empty($array["foto"])
        ) {

            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i campi. Anche la foto!</li></ul>";
        }

        return true;
    }
    public static function preventivoEditFieldsNotEmpty($array)
    {
        if (
            empty($array) ||
            empty($array["titolo"]) ||
            empty($array["luogo"]) ||
            empty($array["descrizione"])
        ) {

            return ERROR_MESSAGES_WRAPPER . "<li>Per favore, compila tutti i campi. Puoi non scegliere un'altra foto se desideri mantenere quella attuale.</li></ul>";
        }

        return true;
    }

    public static function validatePreventivo($array): bool|string
    {
        $errorMessages = ERROR_MESSAGES_WRAPPER;

        $titolo = $array['titolo'];
        $luogo = $array['luogo'];
        $descrizione = $array['descrizione'];
        $foto = $array['foto'];

        if (self::isTitolo($titolo) !== true) {
            $errorMessages .= self::isTitolo($titolo);
        }
        if (self::isLuogo($luogo) !== true) {
            $errorMessages .= self::isLuogo($luogo);
        }
        if (self::isDescrizione($descrizione) !== true) {
            $errorMessages .= self::isDescrizione($descrizione);
        }
        if (self::validateFoto($foto) !== true) {
            $errorMessages .= self::validateFoto($foto);
        }

        $errorMessages .= "</ul>";

        if ($errorMessages != ERROR_MESSAGES_WRAPPER . "</ul>") {
            return $errorMessages;
        }

        return true;
    }

    public static function validatePreventivoEdit($array): bool|string
    {
        $errorMessages = ERROR_MESSAGES_WRAPPER;

        $titolo = $array['titolo'];
        $luogo = $array['luogo'];
        $descrizione = $array['descrizione'];
        $foto = $array['foto'];

        if (self::isTitolo($titolo) !== true) {
            $errorMessages .= self::isTitolo($titolo);
        }
        if (self::isLuogo($luogo) !== true) {
            $errorMessages .= self::isLuogo($luogo);
        }
        if (self::isDescrizione($descrizione) !== true) {
            $errorMessages .= self::isDescrizione($descrizione);
        }
        if (self::validateFoto($foto) !== true) {
            $errorMessages .= self::validateFotoEdit($foto);
        }

        $errorMessages .= "</ul>";

        if ($errorMessages != ERROR_MESSAGES_WRAPPER . "</ul>") {
            return $errorMessages;
        }

        return true;
    }

    public static function sanitizePreventivo($array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
        }

        return $sanitized;
    }

    public static function sanitizeAll($array): array
    {
        $sanitized = [];

        foreach ($array as $key => $value) {
            $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        return $sanitized;
    }



    /*
    =======
    IMAGES
    =======
    */

    public static function validateFotoEdit($foto): bool|string
    {
        if (isset($foto) && $foto['error'] == 0) {
            $maxFileSize = 5 * 1024 * 1024;
            $fileSize = $_FILES['foto']['size'];

            if ($fileSize > $maxFileSize) {
                $errorMessage = "<li>Il file non può essere più grande di 5MB.</li>";
            } else {
                return true;
            }
        } else {
            $errorMessage = "<li>Per favore caricare una immagine descrittiva.</li>";
        }

        return $errorMessage;

    }

    public static function validateFoto($foto): bool|string
    {
        if (isset($foto) && $foto['error'] == 0) {
            $maxFileSize = 5 * 1024 * 1024;
            $fileSize = $_FILES['foto']['size'];

            if ($fileSize > $maxFileSize) {
                $errorMessage = "<li>Il file non può essere più grande di 5MB.</li>";
            } else {
                return true;
            }
        } else {
            return true;
        }

        return $errorMessage;

    }

    public static function processImage($maxFileSize = 1 * 1024 * 1024, $targetDir = 'uploads/')
    {
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No valid image uploaded.");
        }
    
        $uploadedFile = $_FILES['foto']['tmp_name'];
        $imageInfo = getimagesize($uploadedFile);
    
        if ($imageInfo === false) {
            throw new Exception("Invalid image file.");
        }
    
        list($width, $height, $imageType) = $imageInfo;
        $mime = $imageInfo['mime'];
    
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($uploadedFile);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($uploadedFile);
                break;
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($uploadedFile);
                break;
            default:
                throw new Exception("Unsupported image type: $mime");
        }
    
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    
        $targetFile = $targetDir . uniqid('img_', true) . '.webp';
        $quality = filesize($uploadedFile) > $maxFileSize ? 50 : 100;
    
        if (!imagewebp($srcImage, $targetFile, $quality)) {
            throw new Exception("Failed to save the processed image.");
        }
    
        imagedestroy($srcImage);
    
        return $targetFile;
    }

    public static function processImageEdit($imagePath, $quality = 50) {
        $imageInfo = getimagesize($imagePath);
        $imageMime = $imageInfo['mime'];
        
        switch ($imageMime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            default:
                return false;
        }
    
        $webpImagePath = pathinfo($imagePath, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
    
        imagewebp($image, $webpImagePath, $quality);
    
        imagedestroy($image);
    
        return $webpImagePath;
    }
    
    
}
