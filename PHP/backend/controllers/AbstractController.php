<?php

abstract class AbstractController
{
    abstract public static function create();
    abstract public static function read();
    abstract public static function update();
    abstract public static function delete();
}
