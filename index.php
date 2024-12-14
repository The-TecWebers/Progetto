<?php
$titolo = "Home - EdilScavi";
$descrizione= "Home Page di Edil Scavi Srl:";
$keywords = "Scavi, edilizia, scavi brescia, lavori edilizi";
include "./PHP/template/header.php";
echo(file_get_contents('./index.html'));
include "./PHP/template/footer.php";
?>