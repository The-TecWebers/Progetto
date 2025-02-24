<?php

class Preventivo
{
    private $id;
    private $titolo;
    private $utente;
    private $data;
    private $luogo;
    private $foto;
    private $didascalia;
    private $descrizione;

    public function __construct(array $array)
    {
        if($array['id']!==null)
        {
            $this->id=$array['id'];
        }
        $this->titolo = $array['titolo'];
        $this->utente = $array['utente'];
        $this->data = date("Y-m-d");
        $this->luogo = $array['luogo'];
        $this->foto = $array['foto'];
        $this->didascalia = $array['didascalia'];
        $this->descrizione = $array['descrizione'];
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitolo()
    {
        return $this->titolo;
    }
    public function getUtente()
    {
        return $this->utente;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getLuogo()
    {
        return $this->luogo;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function getDidascalia()
    {
        return $this->didascalia;
    }
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    public function save()
    {
        DBController::runQuery("INSERT INTO richiesta_preventivo (titolo, utente, data, luogo, foto, didascalia, descrizione)
        VALUES (?,?,?,?,?,?,?);", $this->titolo, $this->utente, $this->data, $this->luogo, $this->foto, $this->didascalia, $this->descrizione);
    }

    public function update(array $array)
    {
        $this->titolo = $array['titolo'] ?? $this->titolo;
        $this->data = date("Y-m-d");
        $this->luogo = $array['luogo'] ?? $this->luogo;
        $this->foto = $array['foto'] ?? $this->foto;
        $this->didascalia = $array['didascalia'] ?? $this->didascalia;
        $this->descrizione = $array['descrizione'] ?? $this->descrizione;
        
        DBController::runQuery("UPDATE richiesta_preventivo SET titolo = ?, data = ?, luogo = ?, foto = ?, didascalia = ?, descrizione = ? WHERE id = ?;",
        $this->titolo, $this->data, $this->luogo, $this->foto, $this->didascalia, $this->descrizione, $this->id);
    }
}
