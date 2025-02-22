<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'backend'.
DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'DBController.php';

// Parametri per la query
$parameters = [
    'admin', 'admin', 'admin@admin.it', '+39 123 456 7890', 'admin', 'admin', 1,
    'user', 'user', 'user@user.it', '+39 123 456 7891', 'user', 'user', 0,
    'Singor_P', 'privato', 'pippo.privati@gmail.com', '+39 123 456 7892', 'Pippo', 'Privati', 0,
    'Methanos', 'metano', 'metano.metani@gmail.com', '+39 123 456 7893', 'Metano', 'Metani', 0,
    'Publici_Comune', 'publico', 'publico.comune@gmail.com', '+39 123 456 7894', 'Publici', 'Comune', 0,
    'Claudio_cc', '1953Claudio#', 'claudiocotticottini@gmail.com', '+39 335 773 3919', 'Claudio', 'Cotti Cottini', 1,
    'Oscar_cc', '1953Oscar@', 'oscarcotticottini@gmail.com', '+39 335 667 3373', 'Oscar', 'Cotti Cottini', 1,
    'Donato_Tb', '1953Donato$', 'donato.taboni@libero.com', '+39 338 864 6232', 'Donato', 'Taboni', 1,
];

// Calcolo dinamico dei segnaposto per la query
$numParameters = count($parameters);
if ($numParameters % 7 !== 0) {
    die("Errore: il numero di parametri deve essere un multiplo di 7.");
}

$numGroups = $numParameters / 7;
$placeholders = implode(", ", array_fill(0, $numGroups, "(?, ?, ?, ?, ?, ?, ?)"));

// Query di inserimento dinamica
$query = "INSERT INTO utente (username, password, email, telefono, nome, cognome, is_admin) VALUES $placeholders";

// Funzione per hashare tutte le password nel formato stabilito
$hashedParameters = $parameters;
for ($i = 1; $i < count($parameters); $i += 7) { // Supponendo che ogni password sia al secondo elemento di un gruppo di 7
    $hashedParameters[$i] = password_hash($parameters[$i], PASSWORD_BCRYPT);
}

// Esecuzione della query con i parametri hashati
DBController::runQuery($query, ...$hashedParameters);

echo "Utenti inseriti correttamente!";
