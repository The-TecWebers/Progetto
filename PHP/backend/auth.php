<?php

require_once('php/backend/user_manager.php');

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

$tagPermessi ='<em><strong><ul><li>';

function pulisci_note($value){
    global $tagPermessi;  // Per poter vedere la variabile globale nello scope della funzione

    // elimina gli spazi
 	$value = trim($value);

 	// rimuove tag html, tranne i tag permessi 
  	$value = strip_tags($value, $tagPermessi);
    
  	return $value;
}

function login()
{
    if (empty($_POST) || !isset($_POST["username"]) || !isset($_POST["password"]))
        return "Completa tutti i campi";

    $user = pulisci_input($_POST["username"]);
    $pass = $_POST["password"];

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

function register()
{
    // Controlla che tutti i campi siano presenti
    if (empty($_POST) || 
        !isset($_POST["email"]) || 
        !isset($_POST["username"]) || 
        !isset($_POST["password1"]) || 
        !isset($_POST["password2"]) || 
        !isset($_POST["name"]) || 
        !isset($_POST["surname"]) || 
        !isset($_POST["hint"])) {
        return "Per favore, compila tutti i campi";
    }

    // Estrai i dati dal form
    $email = pulisci_input($_POST["email"]);
    $username = pulisci_input($_POST["username"]);
    $pass1 = $_POST["password1"];
    $pass2 = $_POST["password2"];
    $name = pulisci_input($_POST["name"]);
    $surname = pulisci_input($_POST["surname"]);
    $hint = pulisci_input($_POST["hint"]);

    // Validazioni dei campi
    if (is_mail($email) !== true) {
        return is_mail($email);
    }
    if (is_password($pass1) !== true) {
        return is_password($pass1);
    }
    if (is_username($username) !== true) {
        return is_username($username);
    }
    if (empty($name) || strlen($name) > 50) {
        return "Il nome deve essere lungo al massimo 50 caratteri";
    }
    if (empty($surname) || strlen($surname) > 50) {
        return "Il cognome deve essere lungo al massimo 50 caratteri";
    }

    if ($pass1 != $pass2) {
        return "Le <span lang=\"en\">password</span> non sono uguali";
    }

    // Sanitizza i dati
    // Serve inserire le funzioni di sanitizzazione della Gaggi ...................
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
    user_manager::add($username, $email, $pass, $name, $surname, $hint);
    return true;
}

function is_mail($mail)
{
    if (strlen($mail) > 256) {
        return "La <span lang=\"en\">mail</span> può essere lunga al massimo 256 caratteri";
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return "<span lang=\"en\">Mail</span> non valida";
    }
    return true;
}

function is_password($pass)
{
    $password_pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s])[\S]{8,256}$/';
    if (!preg_match($password_pattern, $pass)) {
        return "La <span lang=\"en\">password</span> deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, un carattere minuscolo, un numero e un carattere speciale";
    }
    return true;
}

function is_username($username)
{
    $username_pattern = '/^[\w]{1,40}$/';
    if (!preg_match($username_pattern, $username)) {
        return "<span lang=\"en\">Username</span> può contenere solo lettere, numeri e <span lang=\"en\">underscore</span> e deve essere lungo al massimo 40 caratteri";
    }
    return true;
}

?>
