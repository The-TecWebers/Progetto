<?php

$footer = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'HTML' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'footer.html');

$current_page = basename($_SERVER['PHP_SELF']);
$placeholder = '<!-- <photographer-contact> -->';

switch ($current_page) {
    case "mezzi.php":
        $photographer_contact = '<p class="contacts">Fotografia Mezzi</p>
                <ul >
                   <li>Email: <a href="mailto:anna.antonioli01@gmail.com">anna.antonioli01@gmail.com</a></li>
                </ul>';
        $footer = str_replace($placeholder, $photographer_contact, $footer);
        break;
    default:
        $footer = str_replace($placeholder, '', $footer);
        break;
}

echo $footer;
