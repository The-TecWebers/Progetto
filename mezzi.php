<?php
$titolo = "Mezzi - EdilScavi";
$descrizione= "EdilScavi SRL Brescia";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/mezzi.html'));
include "./PHP/template/footer.php";
?>