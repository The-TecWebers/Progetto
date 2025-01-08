<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'PreventivoController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;

    if($action == 'create')
    {
        $target_dir = 'uploads'.DIRECTORY_SEPARATOR;
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        $_POST['foto'] = $target_file;
        $utente = AuthController::getAuthUser();
        $_POST['utente'] = $utente->getId();
        $result = PreventivoController::create();
        if($result==true)
        {
            header("Location: lista_preventivi.php");
        }
    }
    else if($action == 'delete')
    {
        $user = AuthController::getAuthUser();
        $id = $user->getId();
        $sanitized = InputController::sanitizeAll($_POST);
        if(PreventivoController::authorizeFunction($sanitized['id_preventivo'], $id))
        {
            PreventivoController::delete($sanitized['id_preventivo']);
        }
        else
        {
            header("Location: 500.php");
        }
        $_SESSION['Messages'] = "<p class='info-label centered mb-0-6'>Preventivo cancellato correttamente!</p>";
        header("Location: lista_preventivi.php");
    }
}
