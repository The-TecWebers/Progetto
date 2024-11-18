DROP TABLE IF EXISTS richiesta_affitto, richiesta_preventivo, lavoro, mezzo_trasporto, gestore, utente;


-- Form registrazione --
CREATE TABLE utente (
	username varchar(255) PRIMARY KEY,
	email varchar(255) NOT NULL UNIQUE,
	password varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	isadmin BOOLEAN NOT NULL DEFAULT 0
);

-- Form richiesta affitto --
CREATE TABLE richiesta_affitto (
	id varchar(255) PRIMARY KEY,
	inizio date NOT NULL,
	fine date NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(username) ON DELETE CASCADE
);

-- Form richiesta preventivo --
CREATE TABLE richiesta_preventivo (
	id int PRIMARY KEY,
	descrizione varchar(255) NOT NULL,
	data date NOT NULL,
	foto varchar(255) NOT NULL,
	luogo varchar(255) NOT NULL,
	tipolavoro varchar(255) NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(username) ON DELETE CASCADE
);

-- per il template PHP della pagina sui lavori --
CREATE TABLE lavoro (
	id varchar(255) PRIMARY KEY,
	utente varchar(255),
	datainizio date NOT NULL,
	datafine date NOT NULL,
	descrizione varchar(255) NOT NULL,
	svolto boolean NOT NULL,
	FOREIGN KEY (utente) REFERENCES utente(username) ON DELETE CASCADE
);

-- per il template PHP della pagina sui mezzi di trasporto --
CREATE TABLE mezzo_trasporto (
	targa varchar(255) PRIMARY KEY,
	tipoveicolo varchar(255) NOT NULL,
	tipopatentenecessaria varchar(255) NOT NULL,
	prezzoorario float NOT NULL
);

-- per il template PHP della pagina sui gestori --
CREATE TABLE gestore (
	email varchar(255) PRIMARY KEY,
	foto LONGBLOB NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	biografia varchar(255) NOT NULL
);
