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
$id_pippoprivati = findId('Singor_P');
$id_metanometani = findId('Methanos');
$id_publicocomune = findId('Publici_Comune');

// Parametri per la query saldatura_acquedotto_schiesone
$parameters = [
    'Saldatura Acquedotto Schiesone', $id_publicocomune, '2023-03-08', 'Prata Camportaccio', 'uploads/saldatura_acquedotto_schiesone/saldatura_acquedotto.webp', 'Valvola a farfalla flangiata in ghisa con attuatore manuale', 'Richiesta di intervento per la saldatura dell’acquedotto nel territorio di Prata Camportaccio. Operazione necessaria per completare il sistema di derivazione idroelettrica del torrente Schiesone',
    'Riparazione perdita acquedotto Artogne', $id_user, '2016-04-27', 'Artogne, Via Fornaci', 'uploads/riparazione_perdita_acquedotto_artogne/acquedotto_Artogne_via_fornaci_2016.webp', 'Perdita d\'acqua da tubo sotterraneo con valvola di spurgo', 'Richiesta di pronto intervento per la riparazione di una perdita nell’acquedotto in via Fornaci, Artogne. Necessario intervento immediato per evitare disagi ai residenti',
    'Rimozione massi Piazze di Artogne', $id_pippoprivati, '2015-07-19', 'Piazze, Artogne', 'uploads/rimozione_massi_piazze_di_artogne/sasso_cinto_piazze_2015.webp', 'Escavatore su prato con grande roccia e sentiero sterrato', 'Richiesta di rimozione urgente di massi pericolanti in località Piazze di Artogne.',
    'Lavori acquedotto Gianico', $id_publicocomune, '2015-10-04', 'Gianico', 'uploads/lavori_acquedotto_gianico/acquedotto_gianico_2015.webp', 'Tubi industriali con valvole e manometri in una stanza di controllo', 'Richiesta preventivo per la posa di circa 1 km di tubazioni in un’area boschiva ad alta pendenza a Gianico. Il progetto è destinato a fornire acqua a una centralina idroelettrica e al centro abitato',
    'Rimozione alberi Montecampione', $id_publicocomune, '2015-09-12', 'Montecampione', 'uploads/rimozione_alberi_montecampione/bosco_montecampione_2015.webp', 'Albero sradicato con radici esposte in una foresta con sentiero', 'Richiesta di intervento per la rimozione di alberi pericolanti in località Montecampione. Operazione necessaria per mettere in sicurezza la zona boschiva e prevenire danni',
    'Smantellamento antenna Mediaset', $id_publicocomune, '2014-05-20', 'Albere, Piazze, Artogne', 'uploads/smantellamento_antenna_mediaset/Smantellamento_Antenna_2014.webp', 'Torre di telecomunicazioni in acciaio con ripetitori e traliccio', 'Richiesta preventivo per lo smantellamento di una vecchia antenna Mediaset in località Albere, Piazze, e la costruzione di un nuovo basamento per la futura installazione',
    'Trasporto turbina idroelettrica Oglio', $id_user, '2010-08-16', 'Fiume Oglio', 'uploads/trasporto_turbina_idroelettrica_oglio/Trasporto_Turbina_Fiume_2010.webp', 'Gru che movimenta una turbina idraulica verde su un camion', 'Richiesta di trasporto speciale per una turbina destinata a un impianto idroelettrico lungo il fiume Oglio. Necessario l’uso di mezzi idonei per movimentazione sicura',
    'Rimozione pali innevati Montecampione', $id_publicocomune, '2012-02-14', 'Montecampione', 'uploads/rimozione_pali_innevati_montecampione/Rimozione_Pali_Montecampione_2012.webp', 'Tubi di acciaio usati accatastati sulla neve', 'Richiesta di rimozione urgente di pali pericolanti in località Montecampione. Intervento richiesto per la sicurezza stradale in condizioni di neve e ghiaccio, con utilizzo di mezzi speciali per il trasporto',
    'Richiesta di manutenzione giunti dielettrici', $id_metanometani, '2023-06-15', 'Braone', 'uploads/richiesta_di_manutenzione_giunti_dielettrici/Braone_intervento_giunti.webp', 'Scavo con mini escavatore e tubi per lavori di costruzione', 'Richiesta di installazione di giunti dielettrici sul metanodotto in località Braone per prevenire fenomeni di corrosione. Necessaria ispezione preliminare e utilizzo di materiali certificati',
    'Rifacimento allaccio metano Bienno', $id_metanometani, '2022-11-05', 'Bienno, Via di Mezzo', 'uploads/rifacimento_allaccio_metano_bienno/Rifacimento_allaccio_metano.webp', 'Vicolo con arco in pietra, muro di contenimento e tombino aperto', 'Richiesta di intervento per il rifacimento dell’allaccio metano in località Bienno, Via di Mezzo. Operazione volta al miglioramento della rete di distribuzione',
    'Emergenza fuga di gas Bienno', $id_user, '2023-01-12', 'Bienno', 'uploads/emergenza_fuga_di_gas_bienno/fuga_gas_bienno.webp', 'Scavo con tubo di scarico', 'Richiesta di pronto intervento per fuga di gas in località Bienno. Operazione urgente con personale specializzato e attrezzature adeguate per garantire la sicurezza',
    'Emergenza fuga di gas Artogne', $id_metanometani, '2023-02-18', 'Artogne, Via Bassi', 'uploads/emergenza_fuga_di_gas_artogne/fuga_gas.webp', 'Tubo di scarico arrugginito che perde in uno scavo di cemento', 'Richiesta di intervento immediato per una fuga di gas in località Artogne, Via Bassi. Necessario l’utilizzo di dispositivi di rilevamento e squadre di pronto intervento',
    'Isolamento metanodotto Esine', $id_metanometani, '2023-05-22', 'Esine', 'uploads/isolamento_metanodotto_esine/Isolamento_metanodotto.webp', 'Tubo di cemento in uno scavo di terra con un manicotto di riparazione', 'Richiesta di isolamento del metanodotto in località Esine mediante utilizzo di tecnologia Stop System. Lavoro necessario per manutenzione programmata e prevenzione di perdite',
    'Revisione esalatori metanodotto', $id_metanometani, '2023-07-14', 'Artogne, pista ciclabile', 'uploads/revisione_esalatori_metanodotto/esalatori.webp', 'Tubo di scarico in campo con erba alta e sfondo montuoso', 'Richiesta di manutenzione e revisione degli esalatori sul metanodotto situato lungo la pista ciclabile di Artogne. Operazioni necessarie per garantire il corretto funzionamento del sistema',
    'Depressurizzazione gas Esine', $id_metanometani, '2023-09-09', 'Esine', 'uploads/depressurizzazione_gas_esine/Intervento_Valvola_MP.webp', 'Lavori in corso con fiamma ossidrica, scavo e segnali di pericolo', 'Richiesta di intervento urgente per la depressurizzazione di una tubazione gas in località Esine. Operazione effettuata tramite valvola MP e bruciatura gas in eccesso per prevenire il rischio di esplosioni',
    'Pronto intervento fuga gas Piancamuno', $id_user, '2023-10-30', 'Piancamuno, pista ciclabile', 'uploads/pronto_intervento_fuga_gas_piancamuno/Pronto_Intervento_pista_ciclabile.webp', 'Tubo di scarico danneggiato con perdita e ruggine visibile', 'Richiesta di pronto intervento per una fuga di gas lungo la pista ciclabile di Piancamuno. Operazione urgente con personale e attrezzatura specifica per la messa in sicurezza',
    'Manutenzione cabina metano Cividate', $id_metanometani, '2023-08-20', 'Cividate', 'uploads/manutenzione_cabina_metano_cividate/Metano_Cabina_cividate.webp', 'Tubi, valvole e manometri in una centrale di pompaggio industriale', 'Richiesta di intervento per la manutenzione della cabina metano in località Cividate. Operazione necessaria per la saldatura di tubature e isolamento con Stop System, garantendo la sicurezza del sistema',
    'Manutenzione stradale frana Piazze', $id_publicocomune, '2023-11-05', 'Piazze di Artogne', 'uploads/manutenzione_stradale_frana_piazze/Frana_piazze.webp', 'Barriera di contenimento in cemento armato che ferma alcuni detriti', 'Richiesta di manutenzione stradale a causa di una frana in località Piazze di Artogne. Intervento urgente per il ripristino del manto stradale e il consolidamento del terreno',
    'Manutenzione stradale neve Artogne', $id_user, '2023-12-12', 'Artogne e frazioni', 'uploads/manutenzione_stradale_neve_artogne/Neve_salatura.webp', 'Spazzaneve al lavoro su strada innevata', 'Richiesta di intervento per la manutenzione stradale a seguito di nevicate abbondanti nel Comune di Artogne e frazioni. Operazione di salatura e sgombero neve per garantire la viabilità sicura',
    'Rifacimento pozzetto Caserma Carabinieri', $id_pippoprivati, '2023-09-30', 'Artogne', 'uploads/rifacimento_pozzetto_caserma_carabinieri/Rifacimento_Pozzetto_Carabinieri.webp', 'Scavo per un pozzetto e detriti di costruzione', 'Richiesta di rifacimento del pozzetto presso la Caserma dei Carabinieri di Artogne. Intervento tecnico volto al miglioramento della rete idraulica e alla sicurezza strutturale',
    'Rifacimento fogna Artogne', $id_pippoprivati, '2023-07-01', 'Artogne', 'uploads/rifacimento_fogna_artogne/crollo_fogna_Signor_P.webp', 'Scavo con tubo di scarico rotto, detriti e fango', 'Richiesta di intervento per il rifacimento della fogna crollata in località Artogne. Operazione necessaria per ripristinare il corretto funzionamento del sistema fognario e prevenire ulteriori danni',
    'Saldatura acquedotto Civo', $id_user, '2023-04-15', 'Civo', 'uploads/saldatura_acquedotto_civo/saldatura_acquedotto_civo.webp', 'Sala macchine industriale con due turbine idrauliche', 'Richiesta di saldatura dell’acquedotto in località Civo. Operazione necessaria per la derivazione di acqua a uso idroelettrico dal torrente Cavrucco, nei comuni di Civo e Valmasino',
    'Rifacimento marciapiede Artogne', $id_pippoprivati, '2016-06-10', 'Artogne', 'uploads/rifacimento_marciapiede_artogne/Rifacimento_marciapiede_Pagani_2016.webp', 'Lavori stradali con scavo su un marciapiede e barriere di sicurezza', 'Richiesta di rifacimento del marciapiede in località Artogne per la Macelleria Pagani Carni. Intervento necessario per migliorare l’accessibilità e la sicurezza pedonale',
];

// Calcolo dinamico dei segnaposto per la query
$numParameters = count($parameters);
if ($numParameters % 7 !== 0) {
    die("Errore: il numero di parametri deve essere un multiplo di 7.");
}

$numGroups = $numParameters / 7;
$placeholders = implode(", ", array_fill(0, $numGroups, "(?, ?, ?, ?, ?, ?, ?)"));

// Query di inserimento dinamica
$query = "INSERT INTO richiesta_preventivo (titolo, utente, data, luogo, foto, didascalia, descrizione) VALUES $placeholders";

// Esecuzione della query con i parametri
DBController::runQuery($query, ...$parameters);

function formatTitolo($titolo) {
    return strtolower(str_replace(' ', '_', $titolo));
}

// Funzione per trasferire le immagini nei percorsi corretti
function trasferisciImmagini($titolo, $nomeFoto) {
    $titoloFormattato = formatTitolo($titolo);
    $percorsoFoto = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Images' . DIRECTORY_SEPARATOR .
    'preventivi_samples' . DIRECTORY_SEPARATOR . $titoloFormattato . DIRECTORY_SEPARATOR . $nomeFoto;

    $target_dir = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR .
    $titoloFormattato . DIRECTORY_SEPARATOR;

    if (!file_exists($target_dir) && !mkdir($target_dir, 0777, true)) {
        die("Errore: Impossibile creare la directory '{$target_dir}'.");
    }

    $target_file = $target_dir . $nomeFoto;
    if (!file_exists($percorsoFoto)) {
        die("Errore: Immagine sorgente non trovata '{$percorsoFoto}'.");
    }

    if (!copy($percorsoFoto, $target_file)) {
        die("Errore: Impossibile trasferire l'immagine '{$percorsoFoto}' in '{$target_file}'.");
    }
    echo "Immagine trasferita correttamente: $target_file<br>";
}


// Trasferimento delle immagini di esempio
for ($i = 0; $i < count($parameters); $i += 7) {
    trasferisciImmagini($parameters[$i], basename($parameters[$i + 4]));
}

echo "<br>Preventivi inseriti correttamente!";
