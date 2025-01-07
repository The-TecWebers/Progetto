<?php

class Preventivo
{
    private $titolo;
    private $utente;
    private $data;
    private $luogo;
    private $foto;
    private $descrizione;

    function __construct(array $array)
    {
        $this->titolo = $array['titolo'];
        $this->utente = $array['utente'];
        $this->data = date("Y-m-d");
        $this->luogo = $array['luogo'];
        $this->foto = $array['foto'];
        $this->descrizione = $array['descrizione'];
    }

    public function getDescrizione()
    {
        return $this->descrizione;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getLuogo()
    {
        return $this->luogo;
    }

    public function getUtente()
    {
        return $this->utente;
    }

    public function save()
    {
        DBController::runQuery("INSERT INTO richiesta_preventivo (titolo, utente, data, luogo, foto, descrizione)
        VALUES (?,?,?,?,?,?);", $this->titolo, $this->utente, $this->data, $this->luogo, $this->foto, $this->descrizione);
    }
}
