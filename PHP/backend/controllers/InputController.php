<?php

class InputController
{
    public static function SanitizeInput($array): array
    {
        $sanitized = [];
        if (array_key_exists('password', $array)) {
            $sanitized['password'] = htmlentities($array['password']);
        }

        if (array_key_exists('password_confirmation', $array)) {
            $sanitized['password_confirmation'] = htmlentities($array['password_confirmation']);
        }

        foreach ($array as $key => $value) {
            if ($key != 'password' && $key != 'password_confirmation') {
                $sanitized[$key] = htmlentities(strip_tags(trim($value)));
            }
        }
        return $sanitized;
    }

    public static function HashPassword($password): string|null
    {
        if($password!=null)
        {
            return password_hash($password, PASSWORD_BCRYPT);
        }
        return null;
    }
}