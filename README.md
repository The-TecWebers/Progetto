<h1 align="center">Edil Scavi</h1>

Progetto di sviluppo di un sito web svolto per il corso di Tecnologie Web 2024/2025, Laurea Triennale in Informatica,
Università degli Studi di Padova.  
Per conoscere i dettagli tecnici e le avventure che hanno caratterizzato lo sviluppo, si faccia riferimento ai file _relazione.pdf_ e _relazione_concorso.pdf_, presenti nella root.

## Installazione del sito in locale

E' necessario  disporre di un web server funzionante, ad esempio Xampp (https://www.apachefriends.org/it/index.html).\
Per la guida all'utilizzo di Xampp, fare riferimento a https://security.polito.it/~lioy/01nbe/xampp.pdf.

In questo web server, occorre attivare l'estensione _gd_ di PHP, perchè funzioni il caricamento delle immagini dal proprio client verso il web server.\
In Xampp, seguire questi passaggi:
1) Recarsi nella cartella _C:\xampp\php_ (Windows) oppure _/opt/lampp/php_ (Linux).
2) Aprire il file _php.ini_.
3) Cercare all'interno del file la riga con su scritto _;extension=gd_.
4) Rimuovere il punto e virgola iniziale per attivare l'estensione (se già non è presente il punto e virgola, l'estensione è già attiva): _extension=gd_.

Nel caso NON si utilizzi Xampp come web server, c'è il rischio che il sito possa restituire un _500 internal server error_ a causa del comando ```Options -Indexes``` presente nel file _.htaccess_ che si trova nella root del sito. Quella riga serve per i server Apache, per evitare che mostrino l'indice delle cartelle quando nella barra degli indirizzi si tenta di accedere ad una cartella (es: _localhost/Progetto/uploads_, dove _uploads_ è una cartella del sito). Può darsi che alcuni server non permettano sovrascrizioni delle opzioni utilizzando _Options_ per ragioni di sicurezza, ad esempio il server del corso di Tecnologie Web non lo permette. Occorre dunque scrivere ai tecnici e chiedere che sistemino le seguenti impostazioni:
1) Deve essere abilitato il modulo _mod_dir_. Si controlla se lo è già con ```apachectl -M | grep dir```, e lo si può eventualmente attivare con ```a2enmod dir``` e poi riavvio del server.
2) Nella configurazione del virtual_host deve essere impostato:
```
<Directory /var/www/html> 
    AllowOverride All
</Directory>  
```
Oppure, se si vuole consentire gli override solo per il comando Options, si deve impostare:
```
<Directory /var/www/html>
    AllowOverride Options
</Directory>
```
E poi riavviare il server.

Detto ciò, usando Xampp come web server locale non si dovrebbe avere questo problema.

Poi, per il corretto reindirizzamento verso le pagine di errore _404.php_ e _500.php_, occorre modificare il file _.htaccess_ con le configurazioni adatte al proprio web server. La modifica deve avvenire dopo _url=_ e prima delle chiuse virgolette, poichè lì va indicato il percorso della pagina di errore nella struttura di cartelle del web server. Attualmente i percorsi inseriti sono _/404.php_ e _/500.php_, mentre per il server di Tecnologie Web è stato necessario inserire _/nome_login/404.php_ e _/nome_login/500.php_. In Xampp è probabile che sia necessario inserire _/Progetto/404.php_ e _/Progetto/500.php_, ma è variabile in base alla cartella dove è stato inserito il progetto dentro _htdocs_.\
Quando tale percorso è impostato correttamente, scrivendo un carattere a caso nella barra degli indirizzi _successivamente_ all'indirizzo corrente del sito, deve apparire a schermo la pagina 404 da noi sviluppata. Speriamo possa far fare una risata.

Ora, perchè la parte dinamica del sito funzioni, è fondamentale creare e caricare il database.  
Si seguano questi passaggi. Occorre:
1) Creare un database nel servizio di database fornito dal web server. Se si usa Xampp, si deve accedere a _localhost/phpmyadmin_. Il nome con cui creare il database non è importante, ma bisogna ricordarselo per il punto 3.
2) Aprire il file _PHP/backend/controllers/DBController.php_.
3) Modificare i 4 campi di connessione al database. E' sufficiente modificarli nei parametri della funzione _connect_, che tanto le prime operazioni compiute da quella funzione servono proprio a sovrascrivere gli attributi della classe _DBController_. Se si ha appena installato Xampp (e quindi sono attive le configurazioni di default), occorre piazzare _$password = ""_ (nessuna password), mentre come _$DbName_ si deve scrivere il nome del database creato al punto 1.
4) Recarsi usando il terminale nella cartella _PHP/db_.
5) Eseguire il comando ```php db_create.php``` per creare le tabelle. Se non è disponibile il comando _php_, occorre installare PHP nel proprio computer (https://www.php.net/manual/en/install.php), oppure, se è già installato, occorre configurare le variabili d'ambiente perchè l'apposito comando sia disponibile sulla shell.
6) Eseguire il comando ```php dump_utenti.php``` per popolare la tabella _utente_. Sono disponibili, tra gli altri, un account con username _user_ e password _user_ per prendere visione della pagina dei preventivi dell'utente semplice, e un account con username _admin_ e password _admin_ per prendere visione della pagina dei preventivi dell'amministratore.
7) Eseguire il comando ```php dump_preventivi.php``` per popolare la tabella _richiesta_preventivo_. L'output è verboso perchè viene segnalato ogni trasferimento di file immagine dalla cartella _Images/preventivi_samples_ verso la cartella _uploads_. Quest'ultima cartella conterrà inizialmente le immagini dei preventivi di esempio forniti, e, successivamente, conterrà anche le immagini di tutti i preventivi caricati dagli utenti.

Al termine di tutte queste operazioni, è ora possibile fruire e navigare il sito di _Edil Scavi_ dalla propria macchina locale.


## Link correlati

Il sito è visionabile sul web collegandosi a https://edilscavicotti.it/.

Il repository GitHub corrispondente è https://github.com/The-TecWebers/Progetto.
