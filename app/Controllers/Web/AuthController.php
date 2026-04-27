<?php

namespace App\Controllers\Web;

use App\Models\User;

class AuthController
{
    public function register()
    {
        session_start();

        $data = $_POST;
        $userModel = new User();

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $_SESSION['error'] = "All fields are required";
            header("Location: /clientflow-api/public/index.php?page=register");
            exit;
        }

        if ($userModel->findByEmail($data['email'])) {
            $_SESSION['error'] = "Email already exists";
            header("Location: /clientflow-api/public/index.php?page=register");
            exit;
        }

        $userModel->create(
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        );

        header("Location: /clientflow-api/public/index.php?page=login");
        exit;
    }

    public function login()
    {
        session_start();

        $data = $_POST;
        $userModel = new User();

        $user = $userModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            $_SESSION['error'] = "Invalid credentials";
            header("Location: /clientflow-api/public/index.php?page=login");
            exit;
        }

        $_SESSION['user'] = $user;

        header("Location: /clientflow-api/public/index.php?page=clients");
        exit;
    }

    public function logout()
    {
        session_start();

        session_unset();
        session_destroy();

        header("Location: /clientflow-api/public/index.php?page=login");
        exit;
    }
}
