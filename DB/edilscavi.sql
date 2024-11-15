DROP TABLE IF EXISTS utente, richiesta_affitto, richiesta_affitto, lavoro, mezzo_trasporto, gestore


CREATE TABLE utente (
	id varchar(255) PRIMARY KEY,
	email varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	ruolo varchar(255) NOT NULL,
	CHECK (ruolo IN ('Admin', 'User'))
);

CREATE TABLE richiesta_affitto (
	id varchar(255) PRIMARY KEY,
	inizio date NOT NULL,
	fine date NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES Utente(id)
);

CREATE TABLE richiesta_preventivo (
	id int PRIMARY KEY,
	descrizione varchar(255) NOT NULL,
	data date NOT NULL,
	foto varchar(255) NOT NULL,
	luogo varchar(255) NOT NULL,
	TipoLavoro varchar(255) NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES Utente(id)
);

CREATE TABLE lavoro (
	id varchar(255) PRIMARY KEY,
	utente varchar(255),
	DataInizio date NOT NULL,
	DataFine date NOT NULL,
	Descrizione varchar(255) NOT NULL,
	Svolto varchar(255) NOT NULL,
	CHECK (Svolto IN ('Sì', 'No'))
);

CREATE TABLE mezzo_trasporto (
	Targa varchar(255) PRIMARY KEY,
	TipoVeicolo varchar(255) NOT NULL,
	TipoPatenteNecessaria varchar(255) NOT NULL,
	PrezzoOrario float NOT NULL
);

CREATE TABLE gestore (
	email varchar(255) PRIMARY KEY,
	foto varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	biografia varchar(255) NOT NULL
);
