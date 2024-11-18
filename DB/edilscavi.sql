DROP TABLE IF EXISTS richiesta_affitto, richiesta_preventivo, lavoro, mezzo_trasporto, tipo_veicolo, gestore, utente;


-- Form registrazione
CREATE TABLE utente (
	id varchar(255) PRIMARY KEY,
	username varchar(255) NOT NULL UNIQUE,
	email varchar(255) NOT NULL UNIQUE,
	password varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	is_admin BOOLEAN NOT NULL DEFAULT 0
);

-- Form richiesta affitto
CREATE TABLE richiesta_affitto (
	id varchar(255) PRIMARY KEY,
	inizio date NOT NULL,
	fine date NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE,
	CONSTRAINT chk_data_fine CHECK (fine > inizio)
);

-- Form richiesta preventivo
CREATE TABLE richiesta_preventivo (
	id int PRIMARY KEY,
	descrizione varchar(255) NOT NULL,
	data date NOT NULL,
	foto varchar(255) NOT NULL,
	luogo varchar(255) NOT NULL,
	tipo_lavoro varchar(255) NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE
);

-- per il template PHP della pagina sui lavori
CREATE TABLE lavoro (
	id varchar(255) PRIMARY KEY,
	utente varchar(255),
	data_inizio date NOT NULL,
	data_fine date NOT NULL,
	descrizione varchar(255) NOT NULL,
	svolto boolean NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(id) ON DELETE CASCADE
);

-- tabella di supporto per evitare la dipendenza funzionale tra veicolo e patente
CREATE TABLE tipo_veicolo (
    tipo_veicolo varchar(255) PRIMARY KEY,
    tipo_patente varchar(255) NOT NULL
);

-- per il template PHP della pagina sui mezzi di trasporto
CREATE TABLE mezzo_trasporto (
	targa varchar(255) PRIMARY KEY,
        tipo_veicolo varchar(255) NOT NULL,
        prezzo_orario float NOT NULL,
        FOREIGN KEY (tipo_veicolo) REFERENCES tipo_veicolo(tipo_veicolo) ON DELETE CASCADE
);
