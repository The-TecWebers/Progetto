<?php
$titolo = "Lavori svolti - EdilScavi";
$descrizione= "Lavori svolti nel corso degli anni da EdilScavi Srl Brescia";
$keywords = "EdilScavi, lavori edilizi, ............................................[serve conoscere il contenuto della pagina]";

include "./PHP/template/header.php";
echo(file_get_contents('./HTML/pages/lavori_svolti.html'));
include "./PHP/template/footer.php";