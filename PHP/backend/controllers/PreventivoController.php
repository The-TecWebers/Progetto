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
}