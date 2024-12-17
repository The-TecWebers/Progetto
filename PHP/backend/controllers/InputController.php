<?php

class InputController
{
    public static function SanitizeInput($input): string
    {
        $sanitized = htmlentities(strip_tags(trim($input)));
        return $sanitized;
    }
}