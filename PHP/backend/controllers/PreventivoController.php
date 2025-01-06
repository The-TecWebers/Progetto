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

    static public function getTabellaPreventivi()
    {
        $utente = AuthController::getAuthUser();
        $preventivi = DBController::getPreventivi("SELECT * FROM richiesta_preventivo WHERE utente = ?", $utente->getId());
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
                        <dd>".$preventivo['data']."</dd>
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
    
}
