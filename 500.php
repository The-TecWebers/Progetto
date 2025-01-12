<?php
$titolo = "500 - EdilScavi";
$descrizione= "E' avvenuto un errore interno nel sito di EdilScavi Srl, scaveremo per capire perchè.";
$keywords = "errore 500, errore server, edilizia, scavi brescia, servizi EdilScavi";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . '500.html');
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
