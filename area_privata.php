<?php
$titolo = "Area privata - EdilScavi";
$descrizione= "EdilScavi SRL Brescia";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/area_privata.html'));
include "./PHP/template/footer.php";
?>