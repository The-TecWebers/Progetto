<?php
$titolo = "Accedi - EdilScavi";
$descrizione= "Accedi al tuo account EdilScavi per creare un preventivo o visualizzare i preventivi già creati.";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/accedi.html'));
include "./PHP/template/footer.php";
?>
