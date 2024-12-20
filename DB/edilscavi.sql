DROP TABLE IF EXISTS richiesta_affitto, richiesta_preventivo, lavoro, mezzo_trasporto, tipo_veicolo, gestore, utente;
-- Form registrazione
CREATE TABLE utente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    suggerimento_password VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    cognome VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT 0
);

-- Form richiesta preventivo
CREATE TABLE richiesta_preventivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
	descrizione VARCHAR(255) NOT NULL,
	data DATE NOT NULL,
	foto VARCHAR(255) NOT NULL,
	luogo VARCHAR(255) NOT NULL,
	tipo_lavoro VARCHAR(255) NOT NULL,
	utente INT NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE
);

-- per il template PHP della pagina sui lavori svolti
CREATE TABLE lavoro (
    id INT AUTO_INCREMENT PRIMARY KEY,
	utente INT,
	data_inizio DATE NOT NULL,
	data_fine DATE NOT NULL,
	descrizione VARCHAR(255) NOT NULL,
	svolto BOOLEAN NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE
);

