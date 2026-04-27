<?php

namespace App\Requests\Auth;

class LoginRequest
{
    public static function validate($data)
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors[] = "Email is required";
        }

        if (empty($data['password'])) {
            $errors[] = "Password is required";
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        return $errors;
    }
}