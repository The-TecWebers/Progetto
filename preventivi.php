<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'PreventivoController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
session_start();

const ERROR_MESSAGES_WRAPPER = '<ul role="alert" aria-live="assertive" class="errorMessages">';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;
    $raw = $_POST;
    if ($action == 'create') {
        $_SESSION['titolo*'] = $_POST['titolo'] ?? null;
        $_SESSION['luogo*'] = $_POST['luogo'] ?? null;
        $_SESSION['didascalia*'] = $_POST['didascalia'] ?? null;
        $_SESSION['descrizione*'] = $_POST['descrizione'] ?? null;
        $_POST = InputController::sanitizePreventivo($_POST);

        if (!PreventivoController::isTitleDuplicated($_POST['titolo'])) {
            $_POST['foto'] = $_FILES['foto'];
            $raw['foto'] = $_FILES['foto'];
            $errorMessages = InputController::preventivoFieldsNotEmpty($_POST);
            if ($errorMessages === true) {
                $errorMessages = InputController::validatePreventivo(array: $raw);

                if ($errorMessages === true) {
                    $titolo_formatted = strtolower(str_replace(' ', '_', $_POST['titolo'])); // Mette tutto in minuscolo e sostituisce tutti gli spazi con degli underscore
                    $targetDir = 'uploads' . DIRECTORY_SEPARATOR . $titolo_formatted . DIRECTORY_SEPARATOR;
                    $processedFile = InputController::processImage(maxFileSize: 1 * 1024 * 1024, targetDir: $targetDir);
                    if($processedFile === false) {
                        $errorMessages = ERROR_MESSAGES_WRAPPER . "<li>Errore durante il caricamento dell'immagine</li></ul>";
                        $_SESSION['error-preventivi'] = $errorMessages;
                        header('Location: crea_preventivo.php');
                    }
                    $_POST['foto'] = $processedFile;

                    $utente = AuthController::getAuthUser();
                    $_POST['utente'] = $utente->getId();
                    $result = PreventivoController::create();

                    if ($result === true) {
                        $_SESSION['titolo*'] = null;
                        $_SESSION['luogo*'] = null;
                        $_SESSION['didascalia*'] = null;
                        $_SESSION['descrizione*'] = null;
                        $_SESSION['error-preventivi'] = null;

                        header("Location: lista_preventivi.php");
                    }
                } else {
                    $_SESSION['error-preventivi'] = $errorMessages;
                    header('Location: crea_preventivo.php');
                }
            } else {
                $_SESSION['error-preventivi'] = $errorMessages;
                header('Location: crea_preventivo.php');
            }
        } else {
            $errorMessages = ERROR_MESSAGES_WRAPPER . "<li>Esiste già un preventivo registrato con questo titolo</li></ul>";
            $_SESSION['error-preventivi'] = $errorMessages;
            header('Location: crea_preventivo.php');
        }
    } elseif ($action == 'delete') {
        $user = AuthController::getAuthUser();
        $id = $user->getId();
        $sanitized = InputController::sanitizeAll($_POST);
        if (AuthController::isAdmin() || PreventivoController::authorizeFunction($sanitized['delete_preventivo_id'], $id)) {
            PreventivoController::delete($sanitized['delete_preventivo_id']);
        } else {
            header("Location: 500.php");
        }
        $_SESSION['Messages'] = "<p class='info-label centered mb-0-6' aria-live='polite' role='region'>Preventivo cancellato correttamente!</p>";
        header("Location: lista_preventivi.php");

    } elseif ($action == 'update') {
        $_SESSION['titolo*'] = $_POST['titolo'] ?? null;
        $_SESSION['luogo*'] = $_POST['luogo'] ?? null;
        $_SESSION['didascalia*'] = $_POST['didascalia'] ?? null;
        $_SESSION['descrizione*'] = $_POST['descrizione'] ?? null;
    
        $_POST = InputController::sanitizePreventivo($_POST);
        $target = PreventivoController::getPreventivoById($_POST['edit_preventivo_id']);
    
        if ($_POST['titolo'] == $target->getTitolo() || !PreventivoController::isTitleDuplicated($_POST['titolo'])) {
            $_POST['foto'] = $_FILES['foto'];
            $errorMessages = InputController::preventivoEditFieldsNotEmpty($_POST);
            if ($errorMessages === true) {
                $errorMessages = InputController::validatePreventivoEdit(array: $raw);
                if ($errorMessages === true) {
                    $utente = AuthController::getAuthUser();
                    if (PreventivoController::authorizeFunction($_POST['edit_preventivo_id'], $utente->getId())) {
                        $titolo_formatted = strtolower(str_replace(' ', '_', $_POST['titolo'])); // Mette tutto in minuscolo e sostituisce tutti gli spazi con degli underscore
                        $target_dir = 'uploads' . DIRECTORY_SEPARATOR . $titolo_formatted . DIRECTORY_SEPARATOR;
                        $raw_file_name = basename($_FILES["foto"]["name"]);
                        $file_name = strtolower(str_replace(' ', '_', $raw_file_name)); // Mette tutto in minuscolo e sostituisce tutti gli spazi con degli underscore
                        $old_dir = dirname($target->getFoto());
                        $old_file_name = basename($target->getFoto());
    
                        // Se è stato cambiato il titolo
                        if (!file_exists($target_dir)) {
                            mkdir($target_dir, 0775, true);
    
                            // Se foto è stata cambiata con una di nome diverso
                            if ($file_name != "" && $file_name != $old_file_name) {
                                $target_file = $target_dir . $file_name;
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    
                                $compressedImage = compressImage($target_file);
                                if ($target_file !== $compressedImage) { // Se l'estensione non era già webp
                                    unlink($target_file);
                                }
                            } else {
                                $target_file = $target_dir . $old_file_name;
    
                                // Se la foto è stata cambiata con una di nome uguale
                                if ($file_name != "") {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

                                    $compressedImage = compressImage($target_file);
                                }
                                // Se foto non è stata cambiata
                                else {
                                    copy($target->getFoto(), $target_file);
                                    $compressedImage = $target_file;
                                }
                            }
    
                            // Elimina la vecchia cartella perchè il titolo è stato modificato
                            if (is_dir($old_dir)) {
                                array_map('unlink', glob("$old_dir/*.*"));
                                rmdir($old_dir);
                            }
                        }
                        // Abbiamo già controllato che il titolo non sia duplicato, quindi se la cartella target_dir esiste vuol dire che il titolo con cui è nominata è il titolo del preventivo target
                        // Se foto è stata cambiata
                        elseif ($file_name != "" && $file_name != $old_file_name) { // Supponendo che immagini diverse abbiano nomi diversi. Non c'è modo di distinguerle altrimenti
                            // Pulisce la cartella esistente perchè è stata scelta un'altra immagine per il preventivo
                            $files = glob($target_dir . '*');
                            foreach ($files as $file) {
                                if (is_file($file)) {
                                    unlink($file);
                                }
                            }
                            $target_file = $target_dir . $file_name;
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    
                            $compressedImage = compressImage($target_file);
                            if ($target_file !== $compressedImage) { // Se l'estensione non era già webp
                                unlink($target_file);
                            }
                        } else {
                            $target_file = $target->getFoto();
    
                            // Se la foto è stata cambiata con una di nome uguale
                            if ($file_name != "") {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

                                $compressedImage = compressImage($target_file);
                            }
                            // Se foto non è stata cambiata
                            else {
                                $compressedImage = $target_file;
                            }
                        }
    
                        $_POST['foto'] = $compressedImage;
                        $_POST['utente'] = $utente->getId();
                        $result = PreventivoController::update($_POST['edit_preventivo_id']);
                        if ($result === true) {
                            $_SESSION['error-preventivi'] = null;
                            header("Location: lista_preventivi.php");
                        } else {
                            header("Location: 500.php");
                        }
                    } else {
                        header("Location: 500.php");
                    }
                } else {
                    $_SESSION['error-preventivi'] = $errorMessages;
                    header(header: "Location: modifica_preventivo.php?id=" . $_POST['edit_preventivo_id']);
                }
    
            } else {
                $_SESSION['error-preventivi'] = $errorMessages;
                header(header: "Location: modifica_preventivo.php?id=" . $_POST['edit_preventivo_id']);
            }
    
        } else {
            $errorMessages = ERROR_MESSAGES_WRAPPER . "<li>Esiste già un preventivo registrato con questo titolo</li></ul>";
            $_SESSION['error-preventivi'] = $errorMessages;
            header(header: "Location: modifica_preventivo.php?id=" . $_POST['edit_preventivo_id']);
        }
    
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'edit') {
    $_GET = InputController::sanitizeAll($_GET);
    if (PreventivoController::authorizeFunction($_GET['edit_preventivo_id'], (AuthController::getAuthUser())->getId())) {
        header(header: "Location: modifica_preventivo.php?id=" . $_GET['edit_preventivo_id']);
    } else {
        header("Location: 500.php");
    }
}

function compressImage($target_file) {
    // Se l'immagine è più grande di 1 MB, viene compressa in WebP con qualità 50
    if (filesize($target_file) > 1 * 1024 * 1024) {
        $webpFile = InputController::processImageEdit($target_file, 50);
        if($webpFile === false) {
            $errorMessages = ERROR_MESSAGES_WRAPPER . "<li>Errore durante il caricamento dell'immagine</li></ul>";
            $_SESSION['error-preventivi'] = $errorMessages;
            header('Location: modifica_preventivo.php');
        }
    } else {
        // Se l'immagine è più piccola di 1 MB, viene compressa in WebP con qualità 100
        $webpFile = InputController::processImageEdit($target_file, 100);
        if($webpFile === false) {
            $errorMessages = ERROR_MESSAGES_WRAPPER . "<li>Errore durante il caricamento dell'immagine</li></ul>";
            $_SESSION['error-preventivi'] = $errorMessages;
            header('Location: modifica_preventivo.php');
        }
    }

    return $webpFile;
}
