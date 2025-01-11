<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'PreventivoController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;

    if ($action == 'create') {
        $_POST = InputController::sanitizePreventivo($_POST);

        $target_dir = 'uploads' . DIRECTORY_SEPARATOR;
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        $_POST['foto'] = $target_file;

        $utente = AuthController::getAuthUser();
        $_POST['utente'] = $utente->getId();
        $result = PreventivoController::create();

        if ($result == true) {
            header("Location: lista_preventivi.php");
        }
    } elseif ($action == 'delete') {
        $user = AuthController::getAuthUser();
        $id = $user->getId();
        $sanitized = InputController::sanitizeAll($_POST);
        if (AuthController::isAdmin() || PreventivoController::authorizeFunction($sanitized['id_preventivo'], $id)) {
            PreventivoController::delete($sanitized['id_preventivo']);
        } else {
            header("Location: 500.php");
        }
        $_SESSION['Messages'] = "<p class='info-label centered mb-0-6'>Preventivo cancellato correttamente!</p>";
        header("Location: lista_preventivi.php");
    } elseif ($action == 'update') {
        $_POST = InputController::sanitizePreventivo($_POST);
        $utente = AuthController::getAuthUser();
        if (PreventivoController::authorizeFunction($_POST['id_preventivo'], $utente->getId())) {
            $target_dir = 'uploads' . DIRECTORY_SEPARATOR;
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
            $_POST['foto'] = $target_file;
            $_POST['utente'] = $utente->getId();
            $result = PreventivoController::update($_POST['id_preventivo']);
            if ($result == true) {
                header("Location: lista_preventivi.php");
            } else {
                header("Location: 500.php");
            }
        } else {
            header("Location: 500.php");
        }

    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'edit') {
    $_GET = InputController::sanitizeAll($_GET);
    if (PreventivoController::authorizeFunction($_GET['id_preventivo'], (AuthController::getAuthUser())->getId())) {
        header("Location: modifica_preventivo.php?id=" . $_GET['id_preventivo']);
    }
    else {
        header("Location: 500.php");
    }
}
