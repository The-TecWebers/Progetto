<?php
$titolo = "Lista preventivi - EdilScavi";
$descrizione = "Lista dei tuoi preventivi per i lavori di scavi e edilizia con EdilScavi";
$keywords = "preventivi, scavi, edilizia, scavi brescia, lavori edilizi";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "lista_preventivi.html"));
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";