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
        if ($input['foto'] == "uploads" . DIRECTORY_SEPARATOR) {
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

        if ($result === false) {
            return false;
        }

        if (count($result) > 0) {
            return new Preventivo($result);
        }
    }

    public static function authorizeFunction($preventivoId, $userId): bool
    {
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ? AND id = ?", $userId, $preventivoId);

        if (!$preventivi) {
            return false;
        } else {
            return true;
        }

    }

        public static function getListaPreventivi()
    {
        $utente = AuthController::getAuthUser();
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ?", $utente->getId());

        if (!$preventivi) {
            return "<p class='message-preventivo'>Non ci sono preventivi da mostrare</p>";
        }

        $div = "<div class'grid cols-1'>";
        
        foreach ($preventivi as $preventivo) {
            $div .= "
            <div class='preventivo'>
                
        <div class='img-preventivo'>
            <img src='".$preventivo['foto']."' alt='Foto del preventivo'>
        </div>
        <div class='content-preventivo'>
            <div class='header-preventivo'>
                <p>Preventivo - ".$preventivo['titolo']."</p>
            </div>

            <dl>
                <dt>Data:</dt>
                <dd><time datetime='".$preventivo['data']."'/time>".$preventivo['data']."</dd>

                <dt>Luogo:</dt>
                <dd>".$preventivo['luogo']."</dd>

                <dt>Descrizione:</dt>
                <dd>".$preventivo['descrizione']."</dd>
            </dl>
        </div>
             <div class='form-preventivo'>
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
    </div>";
    }
        $div .= "</div>";
        return $div;
    }
    public static function getTabellaPreventivi() {
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo");

        if (!$preventivi) {
            return "<p class='message-preventivo'>Non ci sono preventivi da mostrare</p>";
        }

        foreach ($preventivi as &$preventivo) { // Usa "&" per passare per riferimento
            $user = DBController::runQuery("SELECT username, email, telefono FROM utente WHERE id = ?", $preventivo['utente']);
            $preventivo['username'] = $user['username']; // Questo aggiorna direttamente l'array $preventivi
            $preventivo['email'] = $user['email'];
            $preventivo['telefono'] = $user['telefono'];
        }
        unset($preventivo); // Importante per evitare effetti collaterali

        $table = "<p id='desc-tabella'>Lista dei tuoi preventivi. Nelle righe sono elencati i preventivi,
        per ogni preventivo sono visualizzati l'id, la data, la descrizione, il luogo, il link alla foto ed il link
        per vederlo singolarmente.</p>";

        $table .= "<div id='table-filter' class='filter-container'>
        <div class='filter'>
            <label class='form-label' for='filter-titolo'>Filtra per titolo</label>
            <input class='form-input' type='text' id='filter-titolo' placeholder='Titolo' onkeyup='filterTable()'>
        </div>
        <div class='filter'>
            <label class='form-label' for='filter-richiedente'>Filtra per richiedente</label>
            <input class='form-input' type='text' id='filter-richiedente' placeholder='Richiedente' onkeyup='filterTable()'>
        </div>
        <div class='filter'>
            <label class='form-label' for='start-date'>Filtra dalla data</label>
            <input class='form-input' type='date' id='start-date' placeholder='Data inizio' onchange='filterTable()'>
        </div>
        <div class='filter'>
            <label class='form-label' for='end-date'>Alla data</label>
            <input class='form-input' type='date' id='end-date' placeholder='Data fine' onchange='filterTable()'>
        </div>
    </div>";

        $table .= "
        <table aria-describedby='desc-tabella'>
            <caption>I tuoi preventivi</caption>
            <thead>
                <tr>
                    <th scope='col'>Titolo</th>
                    <th scope='col'>Richiedente</th>
                    <th scope='col'><span lang='en'>Email</span></th>
                    <th scope='col' abbr='tel'>Telefono</th>
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
                <th scope='row'>" . $preventivo['titolo'] . "</th>
                <td data-title='Richiedente'>" . $preventivo['username'] . "</td>
                <td data-title='Email'>" . $preventivo['email'] . "</td>
                <td data-title='Telefono'>" . $preventivo['telefono'] . "</td>
                <td data-title='Data'><time datetime='" . $preventivo['data'] . "'>" . $preventivo['data'] . "</time></td>
                <td data-title='Luogo'>" . $preventivo['luogo'] . "</td>
                <td data-title='Foto'><a href='" . $preventivo['foto'] . "' target='_blank'>Foto del preventivo</a></td>
                <td data-title='Descrizione'>" . $preventivo['descrizione'] . "</td>
                <td data-title='Vista singola'><a href='singolo_preventivo.php?id=" . $preventivo['id'] . "'>Dettagli</a></td>
            </tr>";
        }
        return $table . "</tbody></table>";
    }

    public static function isTitleDuplicated($title)
    {
        $result=DBController::runQuery("SELECT * FROM richiesta_preventivo WHERE titolo = ?", $title);
        if ($result && count($result) > 0) {
            return true;
        }
        return false;
    }
    public static function getSingoloPreventivo()
    {

        $urlId = isset($_GET['id']) ? (int) $_GET['id'] : null;

        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo");

        if (!$preventivi) {
            return "<p class='message-preventivo'>Non ci sono preventivi da mostrare</p>";
        }

    $div = "<div class='grid cols-1'>";
    $found = false; 

    foreach ($preventivi as &$preventivo) {
        if ((int)$preventivo['id'] === $urlId) {
            $found = true; 
            $div .= "
            <div class='preventivo'>
                
        <div class='img-preventivo'>
            <img src='".$preventivo['foto']."' alt='Foto del preventivo'>
        </div>
        <div class='content-preventivo'>
            <div class='header-preventivo'>
                <p>Preventivo - ".$preventivo['titolo']."</p>
            </div>

            <dl>
                <dt>Data:</dt>
                <dd><time datetime='".$preventivo['data']."'/time>".$preventivo['data']."</dd>

                <dt>Luogo:</dt>
                <dd>".$preventivo['luogo']."</dd>

                <dt>Descrizione:</dt>
                <dd>".$preventivo['descrizione']."</dd>
            </dl>
        </div>
             <div class='form-preventivo'>
                  <form method='POST' action='preventivi.php?action=delete'>
                      <input type='hidden' id='id_preventivo' name='id_preventivo' value='".$preventivo['id']."'/>
                      <button type='submit'>
                          <img alt='Modifica preventivo' src='Images/icons/delete_white.svg' height=30 width=30>
                      </button>
                   </form>
              </div>
    </div>";
        }
    }
    if (!$found) {
        $div .= "<p class='message-preventivo'>Preventivo non trovato</p>";
    }

    return $div . "</div>";
}


}
