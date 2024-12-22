<?php
$titolo = "Registrati - EdilScavi";
$descrizione = "Registrati ad EdilScavi per poter richiedere il tuo preventivo.";
$keywords = "registrati, Edil Scavi, account, Dati personali, Dati di accesso, registrazione";

require_once "auth.php";
require_once "PHP/backend/controllers/AuthController.php";

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
            header("Location: dashboard.php");
        else */
            header("Location: area_privata.php");
    }
    $template = (file_get_contents('HTML/pages/registrati.html'));

    $result = isset($_SESSION['error-reg']) ? $_SESSION['error-reg'] : null;

    session_abort();
    include "./PHP/template/header.php";

    if (isset($_SESSION['error-reg'])) {
        $template = str_replace("<!-- errorMessages -->", $result, $template);

    }
    echo $template;
} catch (Exception $e) {
    server_error();
}
include "./PHP/template/footer.php";
?>