<?php
$titolo = "Storia - EdilScavi";
$descrizione= "Storia di Edil Scavi Srl: dagli inizi nel 1981 ad oggi, dal movimento terra ai servizi gas metano";
$keywords = "EdilScavi, Cotti Cottini, appalti, terra, gas metano, Rogno, Edolo";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "storia.html");
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";