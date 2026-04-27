<?php

namespace App\Requests\Client;

class UpdateClientRequest
{
    public static function validate($data)
    {
        $errors = [];

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        return $errors;
    }
}