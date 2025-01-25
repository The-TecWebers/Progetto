<?php

$path = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'header.html');
$header = file_get_contents($path);

session_start();

if (isset($_SESSION['nome'])) {
    $header = preg_replace(
        '/<div class="sign-buttons">\s*.*\s*<\/div>/s',
        '<div class="sign-buttons">
            <a id="btn-private_area" href="area_privata.php" title="Vai all\'area privata">' . htmlspecialchars($_SESSION['nome']) . '</a>
            <a id="btn-logout" href="logout.php">Esci</a>
        </div>
        </div>',
        $header
    );
}



$header = str_replace('<title></title>', '<title>' . $titolo . '</title>', $header);
$header = str_replace('<meta name="description" content="">', '<meta name="description" content="' . $descrizione . '">', $header);
$header = str_replace('<meta name="keywords" content="">', '<meta name="keywords" content="' . $keywords . '" >', $header);

$current_page = basename($_SERVER['PHP_SELF']);

$placeholder = '<!-- <breadcrumb-to-replace> -->';
$prefix = '<nav class="breadcrumb" aria-label="Percorso nel sito"><ul><li><a href="index.php" lang="en">Home</a></li>';
$current = '<li><span aria-current="page">';
$suffix = '</span></li></ul></nav>';

switch ($current_page) {
    case "index.php":
        $header = str_replace('<li><a href="index.php" lang="en">Home</a></li>', '<li class="current-link" aria-current="page" lang="en">Home</li>', $header);
        break;
    case "storia.php":
        $header = str_replace('<li><a href="storia.php">Storia</a></li>', '<li class="current-link" aria-current="page">Storia</li>', $header);
        $header = str_replace($placeholder, $prefix . $current . 'Storia' . $suffix, $header);
        break;
    case "mezzi.php":
        $header = str_replace('<li><a href="mezzi.php">Mezzi</a></li>', '<li class="current-link" aria-current="page">Mezzi</li>', $header);
        $header = str_replace($placeholder, $prefix . $current . 'Mezzi' . $suffix, $header);
        break;
    case "lavori_svolti.php":
        $header = str_replace('<li><a href="lavori_svolti.php">Lavori svolti</a></li>', '<li class="current-link" aria-current="page">Lavori svolti</li>', $header);
        $header = str_replace($placeholder, $prefix . $current . 'Lavori svolti' . $suffix, $header);
        break;
    case "lista_preventivi.php":
        $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link" aria-current="page">Preventivi</li>', $header);
        $header = str_replace($placeholder, $prefix . $current . 'Preventivi' . $suffix, $header);
        break;
    case "su_di_noi.php":
        $header = str_replace('<li><a href="su_di_noi.php">Su di noi</a></li>', '<li class="current-link" aria-current="page">Su di noi</li>', $header);
        $header = str_replace($placeholder, $prefix . $current . 'Su di noi' . $suffix, $header);
        break;
    case "registrati.php":
        if(isset($_GET['intended']) && $_GET['intended']=='lista_preventivi')
        {
            $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link" aria-current="page">Preventivi</li>', $header);
        }elseif(isset($_GET['intended']) && $_GET['intended']=='crea_preventivo'){
            // Nothing to do
        }else{
            $header = str_replace('<a id="btn-register" href="registrati.php">Registrati</a>', '<div id="btn-register" class="current-link" aria-current="page">Registrati</div>', $header);
        }
        $header = str_replace($placeholder, $prefix . $current . 'Registrati' . $suffix, $header);
        break;
    case "accedi.php":
        if(isset($_GET['intended']) && $_GET['intended']=='lista_preventivi'){
            $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link" aria-current="page">Preventivi</li>', $header);
        }elseif(isset($_GET['intended']) && $_GET['intended']=='crea_preventivo'){
            // Nothing to do
        }else{
            $header = str_replace('<a id="btn-login" href="accedi.php">Accedi</a>', '<div id="btn-login" class="current-link" aria-current="page">Accedi</div>', $header);
        }
        $header = str_replace($placeholder, $prefix . $current . 'Accedi' . $suffix, $header);
        break;
    case "area_privata.php":
        $header = str_replace('<a id="btn-private_area" href="area_privata.php" title="Vai all\'area privata">' . htmlspecialchars($_SESSION['nome']) . 
        '</a>', '<div id="btn-private_area" class="current-link" aria-current="page">' . htmlspecialchars($_SESSION['nome']) . '</div>', $header);
        $header = str_replace($placeholder, $prefix . $current . 'Area privata' . $suffix, $header);
        break;
    case "crea_preventivo.php":
        $header = str_replace($placeholder, $prefix . '<li><a href="lista_preventivi.php">Preventivi</a></li>'
                  . $current . 'Crea preventivo' . $suffix, $header);
        break;
    case "singolo_preventivo.php":
        $header = str_replace($placeholder, $prefix . '<li><a href="lista_preventivi.php">Preventivi</a></li>'
                  . $current . 'Preventivo Utente' . $suffix, $header);
        break;
    case "modifica_preventivo.php":
        $header = str_replace($placeholder, $prefix . '<li><a href="lista_preventivi.php">Preventivi</a></li>'
                  . $current . 'Modifica preventivo' . $suffix, $header);
        break;

    default:
        break;
}


echo $header;
