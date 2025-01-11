<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'backend'.
DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'DBController.php';

// Parametri per la query
$parameters = [
    'admin',
    'admin@admin.it',
    'admin', // **Attenzione:** password in chiaro!
    'admin',
    'admin',
    1,

    'user',
    'user@user.it',
    'user', // **Attenzione:** password in chiaro!
    'user',
    'user',
    0
];

// Calcolo dinamico dei segnaposto per la query
$numParameters = count($parameters);
if ($numParameters % 6 !== 0) {
    die("Errore: il numero di parametri deve essere un multiplo di 6.");
}

$numGroups = $numParameters / 6;
$placeholders = implode(", ", array_fill(0, $numGroups, "(?, ?, ?, ?, ?, ?)"));

// Query di inserimento dinamica
$query = "INSERT INTO utente (username, email, password, nome, cognome, is_admin) VALUES $placeholders";

// Funzione per hashare tutte le password nel formato stabilito
$hashedParameters = $parameters;
for ($i = 2; $i < count($parameters); $i += 6) { // Supponendo che ogni password sia al terzo elemento di un gruppo di 6
    $hashedParameters[$i] = password_hash($parameters[$i], PASSWORD_BCRYPT);
}

// Esecuzione della query con i parametri hashati
DBController::runQuery($query, ...$hashedParameters);

echo "Dati inseriti correttamente!";
