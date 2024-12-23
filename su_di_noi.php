<?php
$titolo = "Su di noi - EdilScavi";
$descrizione= "EdilScavi SRL Brescia: la nostra storia, i nostri valori, la nostra squadra";
$keywords = "EdilScavi, Brescia, lavori edili, squadra, valori, storia, esperienza";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "su_di_noi.html"));
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";