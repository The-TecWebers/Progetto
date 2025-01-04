<?php

class Preventivo
{
    private $descrizione;
    private $data;
    private $foto;
    private $luogo;

    private $utente;

    function __construct(array $array)
    {
        $this->descrizione = $array['descrizione'];
        $this->data = date("Y-m-d");
        $this->foto = $array['foto'];
        $this->luogo = $array['luogo'];
        $this->utente = $array['utente'];
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
        DBController::runQuery("INSERT INTO richiesta_preventivo (descrizione, data, foto, luogo, utente) VALUES (?,?,?,?,?);", $this->descrizione, $this->data, $this->foto, $this->luogo, $this->utente);
    }
}