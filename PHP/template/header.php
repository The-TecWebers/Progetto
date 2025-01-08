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
$prefix = '<nav class="breadcrumb" aria-label="breadcrumb"><ul><li><a href="index.php" lang="en">Home</a></li><li>';
$suffix = '</li></ul></nav>';

switch ($current_page) {
    case "index.php":
        $header = str_replace('<li><a href="index.php">Home</a></li>', '<li class="current-link">Home</li>', $header);
        break;
    case "storia.php":
        $header = str_replace('<li><a href="storia.php">Storia</a></li>', '<li class="current-link">Storia</li>', $header);
        $header = str_replace($placeholder, $prefix . 'Storia' . $suffix, $header);
        break;
    case "mezzi.php":
        $header = str_replace('<li><a href="mezzi.php">Mezzi</a></li>', '<li class="current-link">Mezzi</li>', $header);
        $header = str_replace($placeholder, $prefix . 'Mezzi' . $suffix, $header);
        break;
    case "lavori_svolti.php":
        $header = str_replace('<li><a href="lavori_svolti.php">Lavori svolti</a></li>', '<li class="current-link">Lavori svolti</li>', $header);
        $header = str_replace($placeholder, $prefix . 'Lavori svolti' . $suffix, $header);
        break;
    case "lista_preventivi.php":
        $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link">Preventivi</li>', $header);
        $header = str_replace($placeholder, $prefix . 'Preventivi' . $suffix, $header);
        break;
    case "su_di_noi.php":
        $header = str_replace('<li><a href="su_di_noi.php">Su di noi</a></li>', '<li class="current-link">Su di noi</li>', $header);
        $header = str_replace($placeholder, $prefix . 'Su di noi' . $suffix, $header);
        break;
    case "registrati.php":
        $header = str_replace($placeholder, $prefix . 'Registrati' . $suffix, $header);
        if(isset($_GET['intended']) && $_GET['intended']=='lista_preventivi')
        {
            $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link">Preventivi</li>', $header);
        }else{
            $header = str_replace('<a id="btn-register" href="registrati.php">Registrati</a>', '<div id="btn-register" class="current-link">Registrati</div>', $header);
        }
        break;
    case "accedi.php":
        $header = str_replace($placeholder, $prefix . 'Accedi' . $suffix, $header);
        if(isset($_GET['intended']) && $_GET['intended']=='lista_preventivi')
        {
            $header = str_replace('<li><a href="lista_preventivi.php">Preventivi</a></li>', '<li class="current-link">Preventivi</li>', $header);
        }else{
            $header = str_replace('<a id="btn-login" href="accedi.php">Accedi</a>', '<div id="btn-login" class="current-link">Accedi</div>', $header);
        }
        break;
    case "area_privata.php":
        $header = str_replace('<a id="btn-private_area" href="area_privata.php" title="Vai all\'area privata">' . htmlspecialchars($_SESSION['nome']) . '</a>', '<div id="btn-private_area" class="current-link">' . htmlspecialchars($_SESSION['nome']) . '</div>', $header);
        $header = str_replace($placeholder, $prefix . 'Area privata' . $suffix, $header);
        break;
    case "crea_preventivo.php":
        $header = str_replace($placeholder, $prefix . '<a href="lista_preventivi.php">Lista preventivi</a></li>'
                  . '<li>Crea preventivo' . $suffix, $header);
        break;

    default:
        break;
}


echo $header;
