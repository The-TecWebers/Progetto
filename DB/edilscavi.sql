DROP TABLE IF EXISTS richiesta_affitto, richiesta_preventivo, lavoro, mezzo_trasporto, tipo_veicolo, gestore, utente;

-- Form registrazione
CREATE TABLE utente (
	id VARCHAR(255) PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	nome VARCHAR(255) NOT NULL,
	cognome VARCHAR(255) NOT NULL,
	is_admin BOOLEAN NOT NULL DEFAULT 0
);

-- Form richiesta affitto
CREATE TABLE richiesta_affitto (
	id VARCHAR(255) PRIMARY KEY,
	inizio DATE NOT NULL,
	fine DATE NOT NULL,
	utente VARCHAR(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE,
	CONSTRAINT chk_data_fine CHECK (fine > inizio)
);

-- Form richiesta preventivo
CREATE TABLE richiesta_preventivo (
	id INT PRIMARY KEY,
	descrizione VARCHAR(255) NOT NULL,
	data DATE NOT NULL,
	foto VARCHAR(255) NOT NULL,
	luogo VARCHAR(255) NOT NULL,
	tipo_lavoro VARCHAR(255) NOT NULL,
	utente VARCHAR(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE
);

-- per il template PHP della pagina sui lavori
CREATE TABLE lavoro (
	id VARCHAR(255) PRIMARY KEY,
	utente VARCHAR(255),
	data_inizio DATE NOT NULL,
	data_fine DATE NOT NULL,
	descrizione VARCHAR(255) NOT NULL,
	svolto BOOLEAN NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE
);

-- tabella di supporto per evitare la dipendenza funzionale tra veicolo e patente
CREATE TABLE tipo_veicolo (
    tipo_veicolo VARCHAR(255) PRIMARY KEY,
    tipo_patente VARCHAR(255) NOT NULL
);

-- per il template PHP della pagina sui mezzi di trasporto
CREATE TABLE mezzo_trasporto (
	targa VARCHAR(255) PRIMARY KEY,
    tipo_veicolo VARCHAR(255) NOT NULL,
    prezzo_orario FLOAT NOT NULL,
    FOREIGN KEY (tipo_veicolo) REFERENCES tipo_veicolo(tipo_veicolo) ON DELETE CASCADE
);

