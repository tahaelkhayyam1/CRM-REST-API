<?php

require_once __DIR__ . '/../Models/User.php';

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

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "user" => [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role']
            ]
        ]);
    }
}