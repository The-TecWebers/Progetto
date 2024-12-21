<?php

abstract class AbstractController
{
    abstract static public function create();
    abstract static public function read();
    abstract static public function update();
    abstract static public function delete();
}

?>