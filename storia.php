<?php
$titolo = "Storia - EdilScavi";
$descrizione= "Storia e lavori di Edil Scavi Srl: dagli inizi nel 1981 per movimento terra ai servizi gas metano";
$keywords = "EdilScavi, Cotti Cottini, appalti, terra, gas metano, Rogno, Edolo";
include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/storia.html'));
include "./PHP/template/footer.php";
?>