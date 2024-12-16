<?php
// STECCA
/*
$title = "Accedi - Onoranze Stecca";
$page = "accedi";
$description = "Accedi al tuo account per scrivere messaggi di cordoglio e gestire le tue informazioni personali.";
$keywords = "accedi, Onoranze Stecca, login, account, messaggi, informazioni personali, accesso";

$script = "validate";
require "php/backend/auth.php";


session_start();
if (is_logged()) {
    if (is_admin())
        header("Location: dashboard.php");
    else
        header("Location: account.php");

}
$template = (file_get_contents('html/pages/accedi.html'));

$err = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : null;

session_write_close();
session_abort();

include "php/template/header.php";
try {
    if (isset($err))
        $template = str_replace("<!-- errors -->", $err, $template);

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

require_once "funzioni.php";
require_once "DBAccess.php";

$fileHTML = file_get_contents("login.html");

use DB\DBAccess;

$connection = new DBAccess();
$connection->openDBConnection();

if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) $fileHTML = str_replace("<navbar/>", '<span class="nav__link">Area Riservata</span>', $fileHTML);
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}

$warnings = "";
$user_name = "";
$password = "";

if (isset($_POST['submit'])) {
  $user_name = clearInput($_POST['user_name']);
  $password = clearInput($_POST['new_password']);

  if (empty($user_name) || empty($password)) {
      $warnings = '<p class="form__error" id="login_error">Inserisci user_name e password</p>';
  }
  else {
    if ($connection->checkLogin($user_name, $password)) {
      $_SESSION['user'] = $connection->getDataArray("select id from user where user_name = '$user_name'")[0];
      $connection->closeConnection();
      header("Location: userpage.php");
      exit();
    } 
    else if ($connection->checkLoginAdmin($user_name, $password)) {
      $_SESSION['admin'] = $connection->getDataArray("select id from admin where email = '$user_name'")[0];
      $connection->closeConnection();
      header("Location: adminpage.php");
      exit();
    }
    else $warnings = '<p class="form__error" id="login_error">Username o password errati</p>';
  }
}

$fileHTML = str_replace("<warnings/>", $warnings, $fileHTML);
$fileHTML = str_replace("<user_name/>", $user_name, $fileHTML);
echo $fileHTML;
?>
*/

$titolo = "Accedi - EdilScavi";
$descrizione= "Accedi al tuo account EdilScavi per creare un preventivo o visualizzare i preventivi già creati.";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/accedi.html'));
include "./PHP/template/footer.php";

?>
