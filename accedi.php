<?php

$title = "Accedi - EdilScavi";
$page = "accedi";
$description = "Accedi al tuo account EdilScavi per creare un preventivo o visualizzare i preventivi già creati.";
$keywords = "accedi, Edil Scavi, login, account, informazioni personali, accesso";

require_once "auth.php";
require_once "PHP/backend/controllers/AuthController.php";


session_start();
if (AuthController::isLogged()) {
    /*if (AuthController::isAdmin())
        header("Location: dashboard.php");
    else*/
        header("Location: area_privata.php");
}
$template = (file_get_contents('HTML/pages/accedi.html'));

$err = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : null;

session_write_close();
session_abort();

include "PHP/template/header.php";
try {
    if (isset($err))
        $template = str_replace("<!-- errorMessages -->", $err, $template);

    echo $template;
} catch (Exception $e) {
    server_error();
}
include "PHP/template/footer.php";

?>