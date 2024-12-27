<?php
$titolo = "Crea preventivo - EdilScavi";
$descrizione= "Crea un preventivo per i lavori di scavo ed edilizia con EdilScavi Srl.";
$keywords = "preventivo, scavi, edilizia, scavi brescia, lavori edilizi";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "crea_preventivo.html"));
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";