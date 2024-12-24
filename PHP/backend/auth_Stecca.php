<?php

require_once('php' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'user_manager.php');

function is_logged(){
    return isset($_SESSION["username"]);
}

function is_admin(){
    if (!is_logged())
        return false;
    $result = user_manager::get_admin($_SESSION["username"]);
    if ($result == false || count($result) == 0)
        return false;
    return true;
}

function server_error(){
    http_response_code(500);
    $relative_path = dirname(__FILE__) . '/../../html/500.html';
    echo file_get_contents($relative_path);
    die();
}

function pulisci_input($value){
    // elimina gli spazi
    $value = trim($value);

    // rimuove tag html
    $value = strip_tags($value);

     // converte i caratteri speciali in entità html (ex. &lt;)
    $value = htmlentities($value);

    return $value;
}

function pulisci_password($value){
    // rimuove tag html
    $value = strip_tags($value);

    return $value;
}

$tagPermessi ='<em><strong><ul><li>';

function pulisci_note($value){
    global $tagPermessi;  // Per poter vedere la variabile globale nello scope della funzione

    // elimina gli spazi
 	$value = trim($value);

 	// rimuove tag html, tranne i tag permessi 
  	$value = strip_tags($value, $tagPermessi);
    
  	return $value;
}

function login(){
    if (empty($_POST) || !isset($_POST["username"]) || !isset($_POST["password"]))
        return "Completa tutti i campi";

    $user = pulisci_input($_POST["username"]);
    $pass = pulisci_password($_POST["password"]);

    if (is_username($user) !== True)
        return is_username($user);
    if (is_password($pass) !== True)
        return is_password($pass);

    $pass = hash("sha256", $_POST["password"]);
    $db_mail = user_manager::get_password($user);
    if (empty($db_mail))
        return "Utente non registrato";

    if ($pass === $db_mail[0]["password"]) {
        $_SESSION["username"] = $user;
        return True;
    }
    return "Errore nell'accesso";
}

function register(){
    // Controlla che tutti i campi siano presenti
    if (empty($_POST) || 
        !isset($_POST["name"]) || 
        !isset($_POST["surname"]) || 
        !isset($_POST["email"]) || 
        !isset($_POST["username"]) || 
        !isset($_POST["password1"]) || 
        !isset($_POST["password2"]) || 
        !isset($_POST["suggerimento_password"])) {
        return "Per favore, compila tutti i campi";
    }

    // Estrai i dati dal form
    $name = pulisci_input($_POST["name"]);
    $surname = pulisci_input($_POST["surname"]);
    $email = pulisci_input($_POST["email"]);
    $username = pulisci_input($_POST["username"]);
    $pass1 = pulisci_password($_POST["password1"]);
    $pass2 = pulisci_password($_POST["password2"]);
    $suggerimento_password = pulisci_input($_POST["suggerimento_password"]);

    // Validazioni dei campi
    // ...
    // Bisogna pensare proprio al sistema alla validazione, cioè a come vogliamo che i risultati siano restituiti all'utente!
    // Il ritornare una stringa è una soluzione per lo sviluppatore, non per l'utente finale
    // La Gaggi ha creato un tag <ul> mostrando i messaggi di errore in <li>. Questo è un esempio di come si può fare.
    // ...
    if(is_name($name) !== true){
        return is_name($name);
    }
    if(is_surname($surname) !== true){
        return is_surname($surname);
    }
    if (is_mail($email) !== true) {
        return is_mail($email);
    }
    if (is_username($username) !== true) {
        return is_username($username);
    }
    if (is_password($pass1) !== true) {
        return is_password($pass1);
    }

    if ($pass1 != $pass2) {
        return "Le <span lang=\"en\">password</span> non sono uguali";
    }

    // Sanitizza i dati
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $pass = hash("sha256", $pass1);

    // Controllo univocità di username e email
    $result = user_manager::get_by_username($username);
    if ($result && count($result) > 0) {
        return "Esiste già un utente registrato con questo <span lang=\"en\">username</span>";
    }

    $chkmail = user_manager::get_by_mail($email);
    if ($chkmail && count($chkmail) > 0) {
        return "Esiste già un utente registrato con questa <span lang=\"en\">mail</span>";
    }

    // Aggiungi l'utente
    user_manager::add($username, $email, $pass, $name, $surname, $suggerimento_password);
    return true;
}

function is_name($name){
    $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
    $name_pattern = '/^[a-zA-Z' . $accentedCharacters . '\-\s]{2,40}$/';
    if (!preg_match($name_pattern, $name)) {
        return "Il nome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    }
    return true;
}

function is_surname($surname){
    $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
    $surname_pattern = '/^[a-zA-Z' . $accentedCharacters . '\-\s]{2,40}$/';
    if (!preg_match($surname_pattern, $surname)) {
        return "Il cognome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    }
    return true;
}

function is_mail($mail){
    if (strlen($mail) > 256) {
        return "La <span lang=\"en\">mail</span> può essere lunga al massimo 256 caratteri";
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return "<span lang=\"en\">Mail</span> non valida";
    }
    return true;
}

function is_username($username){
    $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
    $username_pattern = '/^[\w' . $accentedCharacters . '\-]{1,40}$/';
    if (!preg_match($username_pattern, $username)) {
        return "<span lang=\"en\">Username</span> può contenere solo lettere, numeri, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri";
    }
    return true;
}

function is_password($pass){
    $password_pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\s])[\S]{8,256}$/';
    if (!preg_match($password_pattern, $pass)) {
        return "La <span lang=\"en\">password</span> deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, un carattere minuscolo, un numero e un carattere speciale";
    }
    return true;
}