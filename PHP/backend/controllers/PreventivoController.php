<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Preventivo.php';
require_once 'DBController.php';
class PreventivoController
{
    static public function create()
    {
        $input = InputController::sanitizePreventivo($_POST);
        $preventivo = new Preventivo($input);
        $preventivo->save();
        return true;
    }
    static public function read()
    {

    }
    static public function update($id)
    {
        $input = InputController::sanitizePreventivo($_POST);
        $target = self::getPreventivoById($id);
        if($input['foto']=="uploads/")
        {
            $input['foto'] = $target->getFoto();
        }
        $target->update(array: $input);
        return true;
    }
    static public function delete($id)
    {
        DBController::runQuery("DELETE FROM richiesta_preventivo WHERE id = ?", $id);
    }

    public static function getPreventivoById($id)
    {
        $result = DBController::runQuery("SELECT * FROM richiesta_preventivo WHERE id = ?", $id);

        if($result === false)
        {
            return false;
        }

        if(count($result)>0)
        {
            return new Preventivo($result);
        }
    }

    public static function authorizeFunction($preventivoId, $userId): bool
    {
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ? AND id = ?", $userId, $preventivoId);

        if(!$preventivi) {
            return false;
        }
        else
        {
            return true;
        }

    }

    public static function getListaPreventivi()
    {
        $utente = AuthController::getAuthUser();
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ?", $utente->getId());

        if(!$preventivi) {
            return "<p  class="">Non ci sono preventivi da mostrare</p>";
        }

        $dl = "<div class='preventivi-container'>";

        foreach ($preventivi as $preventivo) {
            $dl .= "<dl>
            <dt>".$preventivo['titolo']."</dt>
            <dd class='preventivo'>
                <figure>
                    <img src='".$preventivo['foto']."' alt='Foto del preventivo'>
                    <figcaption>Foto del preventivo</figcaption>
                </figure>
                <div>
                    <dl>
                        <dt>Data:</dt>
                        <dd><time datetime='".$preventivo['data']."'>".$preventivo['data']."</time></dd>
                        <dt>Luogo:</dt>
                        <dd>
                            <p>".$preventivo['luogo']."</p>
                        </dd>
                        <dt>Descrizione:</dt>
                        <dd>
                            <p>".$preventivo['descrizione']."</p>
                        </dd>
                    </dl>
                    <div class='container'>
                        <form method='GET' action='preventivi.php'>
                            <input type='hidden' name='action' value='edit'/>
                            <input type='hidden' id='id_preventivo' name='id_preventivo' value='".$preventivo['id']."'/>
                            <button type='submit'><img alt='Modifica preventivo' src='Images/icons/edit_white.svg' height=30 width=30></button>
                        </form>
                        <form method='POST' action='preventivi.php?action=delete'>
                            <input type='hidden' id='id_preventivo' name='id_preventivo' value='".$preventivo['id']."'/>
                            <button type='submit'><img alt='Modifica preventivo' src='Images/icons/delete_white.svg' height=30 width=30></button>
                        </form>
                    </div>
                </div>
            </dd>
            </dl>";
        }
        return $dl."</div>";
    }

    public static function getTabellaPreventivi() {
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo");

        if(!$preventivi) {
            return "<p class="">Non ci sono preventivi da mostrare</p>";
        }

        foreach ($preventivi as &$preventivo) { // Usa "&" per passare per riferimento
            $username = DBController::runQuery("SELECT username FROM utente WHERE id = ?", $preventivo['utente']);
            $preventivo['username'] = $username['username']; // Questo aggiorna direttamente l'array $preventivi
        }
        unset($preventivo); // Importante per evitare effetti collaterali

        $table = "<p id='desc-tabella'>Lista dei tuoi preventivi. Nelle righe sono elencati i preventivi,
        per ogni preventivo sono visualizzati l'id, la data, la descrizione, il luogo, il link alla foto ed il link
        per vederlo singolarmente.</p>
        
        <table aria-describedby='desc-tabella'>
            <caption>I tuoi preventivi</caption>
            <thead>
                <tr>
                    <th scope='col'>Titolo</th>
                    <th scope='col'>Richiedente</th>
                    <th scope='col'>Data</th>
                    <th scope='col'>Luogo</th>
                    <th scope='col'>Foto</th>
                    <th scope='col' abbr='desc'>Descrizione</th>
                    <th scope='col' abbr='singolo'>Vista singola</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($preventivi as $preventivo) {
            $table .= "<tr>
                <th scope='row'>".$preventivo['titolo']."</th>
                <td data-title='Richiedente'>".$preventivo['username']."</td>
                <td data-title='Data'><time datetime='".$preventivo['data']."'>".$preventivo['data']."</time></td>
                <td data-title='Luogo'>".$preventivo['luogo']."</td>
                <td data-title='Foto'><a href='".$preventivo['foto']."' target='_blank'>Foto del preventivo</a></td>
                <td data-title='Descrizione'>".$preventivo['descrizione']."</td>
                <td data-title='Vista singola'><a href='singolo_preventivo.php?id=".$preventivo['id']."'>Dettagli</a></td>
            </tr>";
        }
        return $table."</tbody></table>";
    }
    public static function getSingoloPreventivo(){

    $urlId = isset($_GET['id']) ? (int)$_GET['id'] : null;

    $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo");

    if (!$preventivi) {
        return "<p class="">Non ci sono preventivi da mostrare</p>";
    }

    $dl = "<div class='preventivi-container'>";
    $found = false; 

    foreach ($preventivi as &$preventivo) {
        if ((int)$preventivo['id'] === $urlId) {
            $found = true; 
            $dl .= "<dl>
                    <dt>".$preventivo['titolo']."</dt>
                    <dd class='preventivo'>
                        <figure>
                            <img src='".$preventivo['foto']."' alt='Foto del preventivo'>
                            <figcaption>Foto del preventivo</figcaption>
                        </figure>
                        <div>
                            <dl>
                                <dt>Data:</dt>
                                <dd><time datetime='".$preventivo['data']."'>".$preventivo['data']."</time></dd>
                                <dt>Luogo:</dt>
                                <dd><p>".$preventivo['luogo']."</p></dd>
                                <dt>Descrizione:</dt>
                                <dd><p>".$preventivo['descrizione']."</p></dd>
                            </dl>
                            <div class='container'>
                                <form method='GET' action='preventivi.php'>
                                    <input type='hidden' name='action' value='edit'/>
                                    <input type='hidden' id='id_preventivo' name='id_preventivo' value='".$preventivo['id']."'/>
                                    <button type='submit'>
                                        <img alt='Modifica preventivo' src='Images/icons/edit_white.svg' height=30 width=30>
                                    </button>
                                </form>
                                <form method='POST' action='preventivi.php?action=delete'>
                                    <input type='hidden' id='id_preventivo' name='id_preventivo' value='".$preventivo['id']."'/>
                                    <button type='submit'>
                                        <img alt='Modifica preventivo' src='Images/icons/delete_white.svg' height=30 width=30>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </dd>
                    </dl>";
        }
    }
    if (!$found) {
        $dl .= "<p>Preventivo non trovato.</p>";
    }

    return $dl . "</div>";
}

    

}
