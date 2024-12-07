<?php

$path = realpath(__DIR__ . '/../../HTML/template/header.html');
$header = file_get_contents($path);

$header = str_replace('<title></title>', '<title>' . $titolo . '</title>', $header);
$header = str_replace('<meta name="description" content=""/>', '<meta name="description" content="' . $descrizione . '"/>', $header);
$header = str_replace('<meta name="keywords" content=""/>', '<meta name="keywords" content="' . $keywords . '" />', $header);
echo($header);


