<?php
$titolo = "Home - EdilScavi";
$descrizione = "Esperti in movimento terra e urbanizzazione ad Artogne, Valle Camonica";
$keywords = "EdilScavi,costruzioni,edilizia,Artogne,movimento terra,impianti";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "HTML" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "home.html");
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";
