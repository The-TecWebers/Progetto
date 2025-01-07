<?php
require_once 'AbstractController.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Preventivo.php';
require_once 'DBController.php';
class PreventivoController extends AbstractController
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
    static public function update()
    {

    }
    static public function delete()
    {

    }

    public static function getListaPreventivi()
    {
        $utente = AuthController::getAuthUser();
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ?", $utente->getId());

        if(!$preventivi) {
            return "<p>Non ci sono preventivi da mostrare</p>";
        }

        $dl = "<div class='grid cols-3'>";

        foreach ($preventivi as $preventivo) {
            $dl .= "<div class='figure-paragraph-container'>
                <figure>
                    <img src='".$preventivo['foto']."' alt='Foto del preventivo'>
                    <figcaption>Foto del preventivo</figcaption>
                </figure>
                <div>
                    <dl>
                        <dt>Data</dt>
                        <dd><time datetime='".$preventivo['data']."'>".$preventivo['data']."</time></dd>
                        <dt>Descrizione</dt>
                        <dd>
                            <p>".$preventivo['descrizione']."</p>
                        </dd>
                        <dt>Luogo</dt>
                        <dd>
                            <p>".$preventivo['luogo']."</p>
                        </dd>
                    </dl>
                </div>
            </div>";
        }
        return $dl."</div>";
    }

    public static function getTabellaPreventivi() {
        $utente = AuthController::getAuthUser();
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ?", $utente->getId());

        if(!$preventivi) {
            return "<p>Non ci sono preventivi da mostrare</p>";
        }

        $table = "<p id='desc-tabella'>Lista dei tuoi preventivi. Nelle righe sono elencati i preventivi,
        per ogni preventivo sono visualizzati l'id, la data, la descrizione, il luogo, il link alla foto ed il link
        per vedere i dettagli.</p>
        
        <table aria-describedby='desc-tabella'>
            <caption>I tuoi preventivi</caption>
            <thead>
                <tr>
                    <th scope='col'>Id</th>
                    <th scope='col'>Data</th>
                    <th scope='col' abbr='desc'>Descrizione</th>
                    <th scope='col'>Luogo</th>
                    <th scope='col'>Foto</th>
                    <th scope='col' abbr='det'>Dettagli</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($preventivi as $preventivo) {
            $table .= "<tr>
                <th scope='row'>".$preventivo['id']."</th>
                <td><time datetime='".$preventivo['data']."'>".$preventivo['data']."</time></td>
                <td>".$preventivo['descrizione']."</td>
                <td>".$preventivo['luogo']."</td>
                <td><a href='".$preventivo['foto']."' target='_blank'>Foto del preventivo</a></td>
                <td><a href='singolo_preventivo.php?id=".$preventivo['id']."'>Dettagli</a></td>
            </tr>";
        }
        return $table."</tbody></table>";
    }
    
}
