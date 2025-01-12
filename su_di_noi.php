<?php
$titolo = "Su di noi - EdilScavi";
$descrizione= "Edil Scavi Srl Brescia: i nostri valori, la nostra squadra, i nostri presidenti";
$keywords = "su di noi, EdilScavi, Cotti Cottini, valori, squadra, presidenti";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "su_di_noi.html");
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
