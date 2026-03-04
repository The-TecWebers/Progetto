<?php
$titolo = "500 - Edil Scavi";
$descrizione= "E' avvenuto un errore interno nel sito di Edil Scavi Srl, scaveremo per capire perchè.";
$keywords = "errore 500, errore server, edilizia, scavi brescia, servizi Edil Scavi";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . '500.html');
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
