<?php
$titolo = "Area privata - EdilScavi";
$descrizione = "EdilScavi Srl Brescia...........";
$keywords = "area privata, account, Edil Scavi, dati personali, dati di accesso";

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php');

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
        $accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';
        $username_pattern = '/^[\w' . $accentedCharacters . '\-]{1,40}$/';
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

$template = file_get_contents('HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'area_privata.html');

if(isset($_SESSION['nome']) && isset($_SESSION['cognome']) && isset($_SESSION['email']) && isset($_SESSION['username'])){
    $template = str_replace("[Nome]", $_SESSION['nome'], $template);
    $template = str_replace("[Cognome]", $_SESSION['cognome'], $template);
    $template = str_replace("[Email]", $_SESSION['email'], $template);
    $template = str_replace("[Username]", $_SESSION['username'], $template);
}

session_write_close();
session_abort();

include "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";

echo ($template);

include "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";