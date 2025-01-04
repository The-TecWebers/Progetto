<?php
$titolo = "Area privata - EdilScavi";
$descrizione = "Area privata di Edil Scavi, qui puoi visualizzare e/o modificare i tuoi dati personali e di accesso.";
$keywords = "area privata, account, Edil Scavi, dati personali, dati di accesso";

require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'UserController.php';

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

    $template = file_get_contents('HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'area_privata.html');

    $err = isset($_SESSION['error-priv-area']) ? $_SESSION['error-priv-area'] : null;
    if (isset($err)) {
        $template = str_replace("<!-- errorMessages -->", $err, $template);

        $fields = array(
            'nome' => 'Es: Mario',
            'cognome' => 'Es.: Rossi',
            'email' => 'Es: mario.rossi@example.com',
            'username' => 'Es.: MRossi33',
            'old_password' => 'Password attuale',
            'new_password' => 'Es.: 44Gatti__$',
            'repeated_password' => 'Conferma Password'
        );
        
        foreach ($fields as $field => $label) {
            $sessionKey = $field . '*';
            if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] !== "") {
                $template = str_replace("placeholder=\"{$label}\"", "value=\"" . $_SESSION[$sessionKey] . "\"", $template);
            }
        }
    }
    else{
        $userData = UserController::read();

        if($userData !== false){
            $fields = array(
                'nome' => 'Es: Mario',
                'cognome' => 'Es.: Rossi',
                'email' => 'Es: mario.rossi@example.com',
                'username' => 'Es.: MRossi33'
            );

            foreach ($fields as $field => $label) {
                if (isset($userData[$field]) && $userData[$field] !== "") {
                    $template = str_replace("placeholder=\"{$label}\"", "value=\"" . $userData[$field] . "\"", $template);
                }
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