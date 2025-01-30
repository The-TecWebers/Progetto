<?php


require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Preventivo.php';
require_once 'DBController.php';
class PreventivoController
{
    public static function create()
    {
        $input = $_POST;
        $preventivo = new Preventivo($input);
        $preventivo->save();
        return true;
    }
    public static function update($id)
    {
        $input = $_POST;
        $target = self::getPreventivoById($id);
        if ($input['foto'] == "uploads" . DIRECTORY_SEPARATOR) {
            $input['foto'] = $target->getFoto();
        }
        $target->update(array: $input);
        return true;
    }
    public static function delete($id)
    {
        $preventivo = self::getPreventivoById($id);
        $fotoPath = $preventivo->getFoto();
        $directoryPath = dirname($fotoPath);
        if ($fotoPath && file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        if (is_dir($directoryPath)) {
            if (count(scandir($directoryPath)) == 2) {
                rmdir($directoryPath);
            } else {
                echo "Directory is not empty.";
            }
        }

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

        // Ordina per id decrescente
        usort($preventivi, function ($a, $b) {
            return $b['id'] - $a['id'];
        });

        $div = "<ul class='grid cols-1'>";

        for ($i = 0; $i < count($preventivi); $i++) {
            $preventivo = $preventivi[$i];
            $preventivo['descrizione'] = nl2br($preventivo['descrizione']);

            // Verifica se esiste un preventivo successivo
            $linkPreventivoSuccessivo = isset($preventivi[$i + 1])
                ? "<a class='link-intestazione' href='#preventivo_" . $preventivi[$i + 1]['id'] . "'>Vai al prossimo preventivo</a>"
                : "";

            $div .=
                $linkPreventivoSuccessivo .
                "<li id='preventivo_" . $preventivo['id'] . "' class='preventivo'>

            <div class='img-preventivo'>
                <img src='" . $preventivo['foto'] . "' alt='Foto del preventivo'>
            </div>
            <div class='content-preventivo'>
                <div class='header-preventivo'>
                    <p>Preventivo - " . $preventivo['titolo'] . "</p>
                </div>

                <dl>
                    <dt>Data:</dt>
                    <dd><time datetime='" . $preventivo['data'] . "'>" . $preventivo['data'] . "</time></dd>

                    <dt>Luogo:</dt>
                    <dd>" . $preventivo['luogo'] . "</dd>

                    <dt>Descrizione:</dt>
                    <dd>" . $preventivo['descrizione'] . "</dd>
                </dl>
            </div>
            <div class='form-preventivo'>
                <form method='GET' action='preventivi.php'>
                    <input type='hidden' name='action' value='edit'/>
                    <input type='hidden' name='edit_preventivo_id' value='" . $preventivo['id'] . "'/>
                    <button type='submit' aria-label='Modifica preventivo'>
                        <img alt='' src='Images/icons/edit_white.svg' height=30 width=30>
                    </button>
                </form>
                <form method='POST' action='preventivi.php?action=delete'>
                      <input type='hidden' name='delete_preventivo_id' value='" . $preventivo['id'] . "'/>
                    <button type='submit' aria-label='Elimina preventivo'>
                        <img alt='' src='Images/icons/delete_white.svg' height=30 width=30>
                    </button>
                </form>
            </div>
        </li>";
        }

        $div .= "</ul>";
        return $div;
    }
    public static function getTabellaPreventivi()
    {
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo");

        if (!$preventivi) {
            return "<p class='message-preventivo'>Non ci sono preventivi da mostrare</p>";
        }

        // Ordina per id decrescente
        usort($preventivi, function ($a, $b) {
            return $b['id'] - $a['id'];
        });

        foreach ($preventivi as &$preventivo) { // Usa "&" per passare per riferimento
            $user = DBController::runQuery("SELECT username, email, telefono FROM utente WHERE id = ?", $preventivo['utente']);
            $preventivo['username'] = $user['username']; // Questo aggiorna direttamente l'array $preventivi
            $preventivo['email'] = $user['email'];
            $preventivo['telefono'] = $user['telefono'];

            // Sostituisce gli '\n' con dei '<br>', così da mantenere gli 'a capo' anche in HTML
            $preventivo['descrizione'] = nl2br($preventivo['descrizione']);
        }
        unset($preventivo); // Importante per evitare effetti collaterali

        $table = "<p id='desc-tabella'>Lista dei preventivi ricevuti da <strong>Edil Scavi</strong>. Nelle righe sono elencati i
        preventivi; per ogni preventivo sono visualizzati il titolo, il richiedente, l'<span lang='en'>email</span> ed il numero
        di telefono del richiedente, la data della richiesta, il luogo, il <span lang='en'>link</span> alla foto, la descrizione
        ed il <span lang='en'>link</span> per vederlo singolarmente.</p>";

        $table .= "<div id='table-filter' class='filter-container'>
        <div class='filter'>
            <label class='form-label' for='filter-titolo'>Filtra per titolo</label>
            <input class='form-input' type='text' id='filter-titolo' placeholder='Es.: Saldatura Acquedotto' onkeyup='filterTable()'>
        </div>
        <div class='filter'>
            <label class='form-label' for='filter-richiedente'>Filtra per richiedente</label>
            <input class='form-input' type='text' id='filter-richiedente' placeholder='Es.: Publici_Comune' onkeyup='filterTable()'>
        </div>
        <div class='filter'>
            <label class='form-label' for='start-date'>Filtra da questa data in poi</label>
            <input class='form-input' type='date' id='start-date' onchange='filterTable()'>
        </div>
        <div class='filter'>
            <label class='form-label' for='end-date'>Filtra fino a questa data</label>
            <input class='form-input' type='date' id='end-date' onchange='filterTable()'>
        </div>
    </div>";

        $table .= "
        <table id='table-preventivi' aria-describedby='desc-tabella'>
            <caption>I tuoi preventivi</caption>
            <thead>
                <tr>
                    <th scope='col'>Titolo</th>
                    <th scope='col'>Richiedente</th>
                    <th scope='col' lang='en'>Email</th>
                    <th scope='col' abbr='tel'>Telefono</th>
                    <th scope='col'>Data</th>
                    <th scope='col'>Luogo</th>
                    <th scope='col'>Foto</th>
                    <th scope='col'>Descrizione</th>
                    <th scope='col' abbr='singolo'>Vista singola</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($preventivi as $preventivo) {
            $table .= "<tr>
                <th scope='row'>" . $preventivo['titolo'] . "</th>
                <td data-title='Richiedente'>" . $preventivo['username']. "</td>
                <td data-title='Email'>" . $preventivo['email']. "</td>
                <td data-title='Telefono'>" . $preventivo['telefono']. "</td>
                <td data-title='Data'><time datetime='" . $preventivo['data'] . "'>" . $preventivo['data'] . "</time></td>
                <td data-title='Luogo'>" . $preventivo['luogo']. "</td>
                <td data-title='Foto'><a href='" . $preventivo['foto'] . "' target='_blank'>Foto del preventivo</a></td>
                <td data-title='Descrizione'>" . $preventivo['descrizione']. "</td>
                <td data-title='Vista singola'><a href='singolo_preventivo.php?id=" . $preventivo['id'] . "' title='Visualizza il singolo preventivo'>Dettagli</a></td>
            </tr>";
        }
        return $table . "</tbody></table>";
    }

    public static function isTitleDuplicated($title)
    {
        $result = DBController::runQuery("SELECT * FROM richiesta_preventivo WHERE titolo = ?", $title);
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
            if ((int) $preventivo['id'] === $urlId) {
                $found = true;

                // Sostituisce gli '\n' con dei '<br>', così da mantenere gli 'a capo' anche in HTML
                $preventivo['descrizione'] = nl2br($preventivo['descrizione']);

                $div .= "
            <div class='preventivo'>
                
        <div class='img-preventivo'>
            <img src='" . $preventivo['foto'] . "' alt='Foto del preventivo'>
        </div>
        <div class='content-preventivo'>
            <div class='header-preventivo'>
                <p>Preventivo - " . $preventivo['titolo']. "</p>
            </div>

            <dl>
                <dt>Data:</dt>
                <dd><time datetime='" . $preventivo['data'] . "'>" . $preventivo['data'] . "</time></dd>

                <dt>Luogo:</dt>
                <dd>" . $preventivo['luogo']. "</dd>

                <dt>Descrizione:</dt>
                <dd>" . $preventivo['descrizione'] . "</dd>
            </dl>
        </div>
             <div class='form-preventivo'>
                  <form method='POST' action='preventivi.php?action=delete'>
                      <input type='hidden' name='delete_preventivo_id' value='" . $preventivo['id'] . "'/>
                      <button type='submit' aria-label='Elimina preventivo'>
                          <img alt='' src='Images/icons/delete_white.svg' height=30 width=30>
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
