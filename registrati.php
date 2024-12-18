<?php
// STECCA
/*
$title = "Registrati - Onoranze Stecca";
$page = "registrati";
$description = "Registrati per poter accedere al tuo account e scrivere messaggi di cordoglio.";
$keywords = "registrati, Onoranze Stecca, account, registrazione";

$script = "validate";
require_once "php/backend/auth.php";

session_start();
try {
    if (is_logged()) {
        if (is_admin()) {
            header("Location: dashboard.php");
        } else {
            header("Location: account.php");
        }
    }
    $template = (file_get_contents('html/registrati.html'));

    $result = isset($_SESSION['error-reg']) ? $_SESSION['error-reg'] : null;

    session_abort();
    include "php/template/header.php";

    if (isset($_SESSION['error-reg'])) {
        $template = str_replace("<!-- errors -->", $result, $template);

    }
    echo $template;
} catch (Exception $e) {
    server_error();
}
include "php/template/footer.php";
*/


// ELENA
/*
<?php
session_start();

require_once "DBAccess.php"; 
require_once "funzioni.php"; 

$fileHTML = file_get_contents("signUp.html");

use DB\DBAccess;

$connessione = new DBAccess();
$connessione->openDBConnection();

if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) $fileHTML = str_replace("<navbar/>", '<a href="./login.php" class="nav__link">Area Riservata</a>', $fileHTML);
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$avvisi='';
$avvisi_p='';

//variabili per il form
$nome = '';
$cognome = '';
$email = '';
$data_nascita = '';

//al click di new_user
if(isset($_POST['new_user'])){
    $username = clearInput($_POST['username']);
    $nome = clearInput($_POST['name']);
    $cognome = clearInput($_POST['surname']);
    $email = clearInput($_POST['email']);
    $data_nascita = $_POST['birthday'];
    $np = clearInput($_POST['new_password']);
    $rnp = clearInput($_POST['rnew_password']);
    $dataOggi = date('Y-m-d');

    $check_email = $connessione->getDataArray("select id from user where email='$email'");

    if(!empty($username) && !empty($nome) && !empty($cognome) && !empty($email) && empty($check_email) && !empty($data_nascita) && $data_nascita<$dataOggi && !empty($np) && !empty($rnp) && $np==$rnp && !(strlen($np) < 8 || strlen($rnp) < 8)){
        $_SESSION['message']='<p class="message js-success-message" id="registrazione_avvenuta">Registrazione avvenuta con successo</p>';
        $connessione->addUser($username, $nome, $cognome, $email, $data_nascita, $np);
        $user = $connessione->getDataArray("select id from user where email='$email'")[0];
        $_SESSION['user'] = $user;
        $nome = '';
        $cognome = '';
        $email = '';
        $data_nascita = '';
        header("Location: index.php");
        exit();
    }
    else{
        if(empty($username)){
            $avvisi .='<p class="form__error" id="username_error">Inserire username</p>';
        }
        if(empty($nome)){
            $avvisi .='<p class="form__error" id="name_error">Inserire nome</p>';
        } 
        if(empty($cognome)){
            $avvisi .='<p class="form__error" id="surname_error">Inserire cognome</p>';
        } 
        if (!empty($check_email)) $avvisi .= '<p class="form__error" id="email_error">Mail già in utilizzo</p>';
        if(empty($email)){
            $avvisi .= '<p class="form__error" id="email_error">Inserire mail</p>';
        }
        if(empty($data_nascita)){
            $avvisi .='<p class="form__error" id="birthday_error">Inserire data di nascita</p>';
        } 
        if($data_nascita>=$dataOggi){
            $avvisi .='<p class="form__error" id="birthday_error">Errore: la data di nascita deve essere inferiore alla data odierna</p>';
        }
        if(empty($np)){
            $avvisi_p .='<p class="form__error" id="password_error">Inserire una password</p>';
        }
        if(empty($rnp)){
            $avvisi_p .='<p class="form__error" id="rpassword_error">Reinserire la password</p>';
        } 
        if(strlen($np) < 8 || strlen($rnp) < 8){
            $avvisi_p .='<p class="form__error" id="password_len_error">La password deve contenere almeno 8 caratteri</p>';
        }
        if($np!=$rnp){
            $avvisi_p .='<p class="form__error" id="different_password_error">Le password non corrispondono</p>';
        } 
    }
}
$fileHTML = str_replace("&lt;username/>", $username, $fileHTML);
$fileHTML = str_replace("&lt;nome/>", $nome, $fileHTML);
$fileHTML = str_replace("&lt;cognome/>", $cognome, $fileHTML);
$fileHTML = str_replace("&lt;email/>", $email, $fileHTML);
$fileHTML = str_replace("&lt;data_nascita/>", $data_nascita, $fileHTML);
$fileHTML = str_replace("<avvisi/>", $avvisi, $fileHTML);
$fileHTML = str_replace("<avvisi_p/>", $avvisi_p, $fileHTML);

$connessione->closeConnection();
echo $fileHTML;
?>
*/

$titolo = "Registrati - EdilScavi";
$descrizione= "Registrati ad EdilScavi per poter richiedere il tuo preventivo.";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/registrati.html'));
include "./PHP/template/footer.php";
?>