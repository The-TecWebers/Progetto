<?php
$titolo = "505 - EdilScavi";
$descrizione= "La pagina che stai cercando non è stata trovata su EdilScavi Srl. Scopri di più sui nostri servizi.";
$keywords = "errore 505, pagina non trovata, edilizia, scavi brescia, servizi EdilScavi";

include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/505.html'));
include "./PHP/template/footer.php";
?>