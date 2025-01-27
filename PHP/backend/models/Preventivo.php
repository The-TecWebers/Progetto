<?php

class Preventivo
{
    private $id;
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
        if($array['id']!==null)
        {
            $this->id=$array['id'];
        }
    }

    public function getDescrizione()
    {
        return $this->descrizione;
    }

    public function getTitolo()
    {
        return $this->titolo;
    }

    public function getId()
    {
        return $this->id;
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

    public function setFoto($foto)
    {
        $this->foto = $foto;

        DBController::runQuery("UPDATE richiesta_preventivo SET foto = ? WHERE id = ?;", $this->foto, $this->id);
    }

    public function save()
    {
        DBController::runQuery("INSERT INTO richiesta_preventivo (titolo, utente, data, luogo, foto, descrizione)
        VALUES (?,?,?,?,?,?);", $this->titolo, $this->utente, $this->data, $this->luogo, $this->foto, $this->descrizione);
    }

    public function update(array $array)
    {
        $this->titolo = $array['titolo'] ?? $this->titolo;
        $this->data = date("Y-m-d");
        $this->luogo = $array['luogo'] ?? $this->luogo;
        $this->foto = $array['foto'] ?? $this->foto;
        $this->descrizione = $array['descrizione'] ?? $this->descrizione;
        DBController::runQuery("UPDATE richiesta_preventivo SET titolo = ?, data = ?, luogo = ?, foto = ?, descrizione = ? WHERE id = ?;",
        $this->titolo, $this->data, $this->luogo, $this->foto, $this->descrizione, $this->id);
    }
}
