<?php
$titolo = "EdilScavi";
$descrizione= "EdilScavi SRL Brescia";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/crea_preventivo.html'));
include "./PHP/template/footer.php";
?>