<?php
$titolo = "Lavori svolti - EdilScavi";
$descrizione= "Lavori svolti nel corso degli anni da EdilScavi Srl Brescia";
$keywords = "scavi, costruzioni, ristrutturazioni, gasdotti, fognature, EdilScavi, Brescia";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "lavori_svolti.html"));
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";