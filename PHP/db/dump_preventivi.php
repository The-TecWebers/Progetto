<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'backend'.
DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'DBController.php';

// Funzione per trovare l'id di uno user in base allo username
function findId($username) {
    $query = "SELECT id FROM utente WHERE username = ?";
    $result = DBController::runQuery($query, $username);

    if (empty($result)) {
        die("Errore: Lo username '{$username}' non esiste nel database.");
    }

    return $result['id'];
}

// Recupero gli ID degli utenti
$id_user = findId('user');
$id_pippo = findId('pippo');

// Parametri per la query
$parameters = [
    'example1', $id_user, '2025-01-13', 'example', 'uploads/example1/preventivi_sample_1.png', 'example',
    'example2', $id_pippo, '2025-01-13', 'example', 'uploads/example2/preventivi_sample_2.png', 'example',
];

// Calcolo dinamico dei segnaposto per la query
$numParameters = count($parameters);
if ($numParameters % 6 !== 0) {
    die("Errore: il numero di parametri deve essere un multiplo di 6.");
}

$numGroups = $numParameters / 6;
$placeholders = implode(", ", array_fill(0, $numGroups, "(?, ?, ?, ?, ?, ?)"));

// Query di inserimento dinamica
$query = "INSERT INTO richiesta_preventivo (titolo, utente, data, luogo, foto, descrizione) VALUES $placeholders";

// Esecuzione della query con i parametri
DBController::runQuery($query, ...$parameters);

// Funzione per trasferire le immagini nei percorsi corretti
function trasferisciImmagini($titolo, $nomeFoto) {
    $percorsoFoto = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Images' . DIRECTORY_SEPARATOR .
    'preventivi_samples' . DIRECTORY_SEPARATOR . $titolo . DIRECTORY_SEPARATOR . $nomeFoto;

    $target_dir = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR .
    $titolo . DIRECTORY_SEPARATOR;

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . $nomeFoto;
    if (!copy($percorsoFoto, $target_file)) {
        die("Errore: Impossibile trasferire l'immagine '{$percorsoFoto}' in '{$target_file}'.");
    }
}

// Trasferimento delle immagini di esempio
for ($i = 0; $i < count($parameters); $i += 6) {
    trasferisciImmagini($parameters[$i], basename($parameters[$i + 4]));
}

echo "Preventivi inseriti correttamente!";
