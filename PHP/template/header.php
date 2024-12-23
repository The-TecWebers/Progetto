<?php

$path = realpath(__DIR__ . '/../../HTML/template/header.html');
$header = file_get_contents($path);

$header = str_replace('<title></title>', '<title>' . $titolo . '</title>', $header);
$header = str_replace('<meta name="description" content=""/>', '<meta name="description" content="' . $descrizione . '"/>', $header);
$header = str_replace('<meta name="keywords" content=""/>', '<meta name="keywords" content="' . $keywords . '" />', $header);

$current_page = basename($_SERVER['PHP_SELF']);

switch ($current_page) {
    case "index.php":
        $header = str_replace('<li><a href="index.php">Home</a></li>', '<li class="current-link">Home</li>', $header);
        break;
    case "storia.php":
        $header = str_replace('<li><a href="storia.php">Storia</a></li>', '<li class="current-link">Storia</li>', $header);
        break;
    case "mezzi.php":
        $header = str_replace('<li><a href="mezzi.php">Mezzi</a></li>', '<li class="current-link">Mezzi</li>', $header);
        break;
    case "lavori_svolti.php":
        $header = str_replace('<li><a href="lavori_svolti.php">Lavori svolti</a></li>', '<li class="current-link">Lavori svolti</li>', $header);
        break;
    case "lista_preventivi.php":
        $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link">Preventivi</li>', $header);
        break;
    case "su_di_noi.php":
        $header = str_replace('<li><a href="su_di_noi.php">Su di noi</a></li>', '<li class="current-link">Su di noi</li>', $header);
        break;
    default:
        break;
}


session_start();

if (isset($_SESSION['nome'])) {
    $header = str_replace(
        '<div class="sign-buttons">
            <a id="btn-register" href="registrati.php">Registrati</a>
            <a id="btn-login" href="accedi.php">Accedi</a>
         </div>',
        '<div class="sign-buttons">
            <a id="btn-private_area" href="area_privata.php" title="Vai all\'area privata">' . htmlspecialchars($_SESSION['nome']) . '</a>
            <a id="btn-logout" href="logout.php">Esci</a>
         </div>',
        $header
    );
}

session_abort();


echo($header);