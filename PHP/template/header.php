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
    case "preventivi.php":
        $header = str_replace('<li><a href="preventivi.php">Preventivi</a></li>', '<li class="current-link">Preventivi</li>', $header);
        $header = str_replace('<script></script>', '<script src="JS\jquery.js" defer></script> <script src="JS\preventivi.js" defer></script>', $header);
        break;
    default:
        break;
}
echo($header);


