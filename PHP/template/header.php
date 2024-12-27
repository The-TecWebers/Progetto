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
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Storia</li></ul>', $header);
        break;
    case "mezzi.php":
        $header = str_replace('<li><a href="mezzi.php">Mezzi</a></li>', '<li class="current-link">Mezzi</li>', $header);
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Mezzi</li></ul>', $header);
        break;
    case "lavori_svolti.php":
        $header = str_replace('<li><a href="lavori_svolti.php">Lavori svolti</a></li>', '<li class="current-link">Lavori svolti</li>', $header);
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Lavori svolti</li></ul>', $header);
        break;
    case "lista_preventivi.php":
        $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link">Preventivi</li>', $header);
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Preventivi</li></ul>', $header);
        break;
    case "su_di_noi.php":
        $header = str_replace('<li><a href="su_di_noi.php">Su di noi</a></li>', '<li class="current-link">Su di noi</li>', $header);
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Su di noi</li></ul>', $header);
        break;
    case "registrati.php":
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Registrati</li></ul>', $header);
        break;
    case "accedi.php":
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Accedi</li></ul>', $header);
        break;
    case "area_privata.php":
        $header = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php" lang="en">Home</a></li><li>Area privata</li></ul>', $header);
        break;

    default:
        break;
}
echo($header);



