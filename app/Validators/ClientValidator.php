<?php
namespace App\Validators;
class ClientValidator
{
    public static function validateCreate($data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = "Name is required";
        }

        if (empty($data['email'])) {
            $errors[] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is invalid";
        }

        return $errors;
    }

    public static function validateUpdate($data)
    {
        return self::validateCreate($data);
    }
}