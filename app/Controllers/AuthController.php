<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController
{
    public function register()
    {
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        // Basic validation
        if (
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['password'])
        ) {
            echo json_encode([
                "status" => "error",
                "message" => "All fields are required"
            ]);
            return;
        }

        $userModel = new User();

        // Check if email exists
        if ($userModel->findByEmail($data['email'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Email already exists"
            ]);
            return;
        }

        // Hash password
        $hashedPassword = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        // Create user
        $userModel->create(
            $data['name'],
            $data['email'],
            $hashedPassword
        );

        echo json_encode([
            "status" => "success",
            "message" => "User registered successfully"
        ]);
    }


    public function login()
    {
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            empty($data['email']) ||
            empty($data['password'])
        ) {
            echo json_encode([
                "status" => "error",
                "message" => "Email and password are required"
            ]);
            return;
        }

        $userModel = new User();

        $user = $userModel->findByEmail($data['email']);

        if (!$user) {
            echo json_encode([
                "status" => "error",
                "message" => "User not found"
            ]);
            return;
        }

        if (!password_verify($data['password'], $user['password'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password"
            ]);
            return;
        }

        $payload = [
            "id" => $user['id'],
            "email" => $user['email'],
            "role" => $user['role'],
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $token = JWT::encode(
            $payload,
            $_ENV['JWT_SECRET'],
            'HS256'
        );

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "token" => $token
        ]);
    }

    public function profile()
    {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';

        $user = AuthMiddleware::verifyToken();

        echo json_encode([
            "status" => "success",
            "message" => "Protected route accessed",
            "user" => $user
        ]);
    }




    }
