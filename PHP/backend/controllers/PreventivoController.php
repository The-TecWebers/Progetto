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
        var_dump($preventivi);
        $table = "<table>
        <tr>
        <th>Descrizione</th>
        <th>Data</th>
        <th>Foto</th>
        <th>Luogo</th>
        <th>Operazioni</th>
        </tr>";
        foreach($preventivi as $preventivo)
        {
            $table = $table."<tr><td>".$preventivo['descrizione']."</td>"."<td>".$preventivo['data']."</td>"."<td>".$preventivo['foto']."</td>"."<td>".$preventivo['luogo']."</td><td></td></tr>";
        }

        $table = $table."</table>";
        return $table;
    }
}