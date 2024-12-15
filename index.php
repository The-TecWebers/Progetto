<?php
$titolo = "Home - EdilScavi";
$descrizione = "EdilScavi SRL: professionalità e servizi per scavi e opere edilizie.";
$keywords = "EdilScavi, scavi, opere edilizie, sottoservizi, servizi professionali";
include "./PHP/template/header.php";
echo(file_get_contents('./index.html'));
include "./PHP/template/footer.php";
?>