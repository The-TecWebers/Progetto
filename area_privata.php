<?php
$titolo = "Area privata - EdilScavi";
$descrizione = "EdilScavi Srl Brescia...........";
$keywords = "area privata, account, Edil Scavi, dati personali, dati di accesso";

require_once "php/backend/controllers/AuthController.php";

session_start();

try {
    if (!AuthController::isLogged()) {
        header("Location: accedi.php");
    } /*elseif (is_admin()) {
        $is_ad = true;
        if (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], 'account.php'))
            header("Location: dashboard.php");
    }*/

    /*
    if (isset($_POST['delete-account'])) {
        $user = $_SESSION['username'];
        user_manager::delete($user);
        session_destroy();
        session_abort();
        header("Location: index.php");
        exit();
    }
    */

    if (isset($_POST['logout'])) {
        AuthController::logout();
    }

    /*
    if (isset($_POST['change-username'])) {
        $username_pattern = '/^[\wàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚçÇñÑ\-]{1,40}$/';
        if (isset($_POST['username']) && !empty($_POST['username'])){
            if (preg_match($username_pattern, $_POST['username'])){
                $olduser = $_SESSION['username'];
                $username = $_POST['username'];
                $result = user_manager::change_username($olduser, $username);
                if ($result)
                    $_SESSION['username'] = $username;
                header("Location: account.php");
                exit();
            }
        }
    }
    */
} catch (Exception $e) {
    AuthController::serverError();
}

$template = file_get_contents('html/pages/area_privata.html');

if(isset($_SESSION['nome']) && isset($_SESSION['cognome']) && isset($_SESSION['email']) && isset($_SESSION['username'])){
    $template = str_replace("[Nome]", $_SESSION['nome'], $template);
    $template = str_replace("[Cognome]", $_SESSION['cognome'], $template);
    $template = str_replace("[Email]", $_SESSION['email'], $template);
    $template = str_replace("[Username]", $_SESSION['username'], $template);
}

session_write_close();
session_abort();

include "PHP/template/header.php";

echo ($template);

include "PHP/template/footer.php";