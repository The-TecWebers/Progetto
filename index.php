<?php
$titolo = "Home - EdilScavi";
$descrizione = "EdilScavi SRL: professionalità e servizi per scavi e opere edilizie.";
$keywords = "EdilScavi, scavi, opere edilizie, sottoservizi, servizi professionali";

include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "header.php";
echo(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "index.html"));
include __DIR__ . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "template" . DIRECTORY_SEPARATOR . "footer.php";