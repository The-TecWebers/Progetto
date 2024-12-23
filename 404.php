<?php
$titolo = "404 - EdilScavi";
$descrizione= "La pagina che stai cercando non è stata trovata su EdilScavi Srl. Scopri di più sui nostri servizi.";
$keywords = "errore 404, pagina non trovata, edilizia, scavi brescia, servizi EdilScavi";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . '404.html'));
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";