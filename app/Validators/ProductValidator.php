<?php

namespace App\Validators;

class ProductValidator
{
    public static function validateCreate(array $data): array
    {
        $errors = [];

        // Name validation
        if (empty(trim($data['name'] ?? ''))) {
            $errors[] = "Name is required";
        }

        // Description validation
        if (empty(trim($data['description'] ?? ''))) {
            $errors[] = "Description is required";
        }

        // Price validation
        if (!isset($data['price']) || $data['price'] === '') {
            $errors[] = "Price is required";
        } elseif (!is_numeric($data['price'])) {
            $errors[] = "Price must be a number";
        } elseif ((float) $data['price'] < 0) {
            $errors[] = "Price must be greater than or equal to 0";
        }

        return $errors;
    }

    public static function validateUpdate(array $data): array
    {
        return self::validateCreate($data);
    }
}