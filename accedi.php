<?php

$titolo = "Accedi - Edil Scavi";
$descrizione = "Accedi al tuo account Edil Scavi per creare un preventivo o visualizzare i preventivi già creati.";
$keywords = "accedi, Edil Scavi, login, account, informazioni personali, accesso";

require_once __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "backend" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AuthController.php";

session_start();

try {
    if (AuthController::isLogged()) {
        /*if (AuthController::isAdmin())
            header("Location: dashboard.php");
        else*/
            header("Location: area_privata.php");
    }
    $template = (file_get_contents('HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'accedi.html'));
    
    if(isset($_GET['intended']))
    {
        if($_GET['intended']=="lista_preventivi")
        {
            $template = str_replace("registrati.php", "registrati.php?intended=lista_preventivi", $template);
            $template = str_replace("auth.php?action=login", "auth.php?action=login&intended=lista_preventivi", $template);
            $msg = "<p class='info-label centered mb-0-6'>Accedi per vedere i tuoi preventivi.</p>";
            $template = str_replace("<!--intendedRedirectMessages-->", $msg, $template);

        }
        elseif($_GET['intended']=="crea_preventivo")
        {
            $template = str_replace("registrati.php", "registrati.php?intended=crea_preventivo", $template);
            $template = str_replace("auth.php?action=login", "auth.php?action=login&intended=lista_preventivi", $template);
            $msg = "<p class='info-label centered mb-0-6'>Accedi per creare un preventivo.</p>";
            $template = str_replace("<!--intendedRedirectMessages-->", $msg, $template);
        }
    }

    $err = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : null;
    if (isset($err)){
        $template = str_replace("<!-- errorMessages -->", $err, $template);
        
        $fields = array(
            'username' => 'Username',
            'password' => 'Password'
        );
        
        foreach ($fields as $field => $label) {
            $sessionKey = $field . '*';
            if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] !== "") {
                $template = str_replace("placeholder=\"{$label}\"", "placeholder=\"{$label}\" value=\"" . $_SESSION[$sessionKey] . "\"", $template);
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

include "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

echo $template;

include "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
