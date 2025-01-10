<?php
$titolo = "Registrati - EdilScavi";
$descrizione = "Registrati ad EdilScavi! Accedi ai nostri servizi e richiedi un preventivo!";
$keywords = "registrati, account, dati personali, registrazione, Edil Scavi";

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

session_start();

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
             header("Location: dashboard.php");
         else */
        header("Location: area_privata.php");
    }
    $template = (file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'registrati.html'));

    if (isset($_GET['intended'])) {
        if ($_GET['intended'] == "lista_preventivi") {
            $template = str_replace("auth.php?action=register", "auth.php?action=register&intended=lista_preventivi", $template);
            $template = str_replace("accedi.php", "accedi.php?intended=lista_preventivi", $template);
            $msg = "<p class='info-label centered width50 m-auto mb-0-6'>Registrati per vedere i tuoi preventivi.</p>";
            $template = str_replace("<!--intendedRedirectMessages-->", $msg, $template);

        } elseif ($_GET['intended'] == "crea_preventivo") {
            $template = str_replace("auth.php?action=register", "auth.php?action=register&intended=crea_preventivo", $template);
            $template = str_replace("accedi.php", "accedi.php?intended=crea_preventivo", $template);
            $msg = "<p class='info-label centered width50 m-auto mb-0-6'>Registrati per creare un preventivo.</p>";
            $template = str_replace("<!--intendedRedirectMessages-->", $msg, $template);
        }
    }

    $err = isset($_SESSION['error-reg']) ? $_SESSION['error-reg'] : null;
    if (isset($err)) {
        $template = str_replace("<!-- errorMessages -->", $err, $template);
        
        $fields = array(
            'nome' => 'Es.: Mario',
            'cognome' => 'Es.: Rossi',
            'email' => 'Es: mario.rossi@example.com',
            'username' => 'Es.: MRossi33',
            'password' => 'Es.: 44Gatti__$',
            'password_confirmation' => 'Conferma password'
        );
        
        foreach ($fields as $field => $label) {
            $sessionKey = $field . '*';
            if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] !== "") {
                $template = str_replace("placeholder=\"{$label}\"", "value=\"" . $_SESSION[$sessionKey] . "\"", $template);
            } else {
                $template = preg_replace('/name="' . $field . '" value=".*"/', 'placeholder="' . $label . '"', $template);
            }
        }
    }

    session_reset();
    session_write_close();
} catch (Exception $e) {
    AuthController::serverError();
}

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

echo $template;

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
