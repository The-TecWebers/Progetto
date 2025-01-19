<?php
$titolo = "Mezzi - Edil Scavi";
$descrizione= "Scopri i mezzi e i macchinari di Edil Scavi! Per scavi e lavori edilizi a Brescia e provincia!";
$keywords = "parco macchine, mezzi, camion, furgone, gru, escavatori, Edil Scavi";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "mezzi.html");
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
