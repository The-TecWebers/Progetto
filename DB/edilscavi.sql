CREATE TABLE Utente (
	id varchar(255) PRIMARY KEY,
	email varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	ruolo varchar(255) NOT NULL,
	CHECK (ruolo IN ('Admin', 'User'))
);

CREATE TABLE RichiestaAffitto (
	id varchar(255) PRIMARY KEY,
	inizio date NOT NULL,
	fine date NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES Utente(id)
);

CREATE TABLE RichiestaPreventivo (
	id int PRIMARY KEY,
	descrizione varchar(255) NOT NULL,
	data date NOT NULL,
	foto varchar(255) NOT NULL,
	luogo varchar(255) NOT NULL,
	TipoLavoro varchar(255) NOT NULL,
	utente varchar(255) NOT NULL,
	FOREIGN KEY (utente) REFERENCES Utente(id)
);

CREATE TABLE Lavoro (
	id varchar(255) PRIMARY KEY,
	utente varchar(255),
	DataInizio date NOT NULL,
	DataFine date NOT NULL,
	Descrizione varchar(255) NOT NULL,
	Svolto varchar(255) NOT NULL,
	CHECK (Svolto IN ('Sì', 'No'))
);

CREATE TABLE MezzoTrasporto (
	Targa varchar(255) PRIMARY KEY,
	TipoVeicolo varchar(255) NOT NULL,
	TipoPatenteNecessaria varchar(255) NOT NULL,
	PrezzoOrario float NOT NULL
);

CREATE TABLE Gestore (
	email varchar(255) PRIMARY KEY,
	foto varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	cognome varchar(255) NOT NULL,
	biografia varchar(255) NOT NULL
);
