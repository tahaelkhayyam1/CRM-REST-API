<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register($name, $email, $password)
    {
        if ($this->userModel->findByEmail($email)) {
            return [
                "error" => "Email already exists"
            ];
        }

        $this->userModel->create(
            $name,
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        );

        return [
            "success" => true
        ];
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }
}