<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'backend'.
DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'DBController.php';

// Parametri per la query
$parameters = [
    'admin', 'admin', 'admin@admin.it', '+39 123 456 7890', 'admin', 'admin', 1,
    'user', 'user', 'user@user.it', '+39 123 456 7891', 'user', 'user', 0,
    'pippo', 'pippo', 'pippo@pippo.it', '+39 123 456 7892', 'pippo', 'pippo', 0,
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
