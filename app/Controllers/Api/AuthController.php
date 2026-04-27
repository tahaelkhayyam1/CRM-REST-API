<?php

namespace App\Controllers\Api;

use App\Helpers\Response;
use App\Models\User;
use App\Services\AuthService;
use Firebase\JWT\JWT;

class AuthController
{
    public function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return Response::error("All fields are required", 422);
        }

        $authService = new AuthService();

        $result = $authService->register(
            $data['name'],
            $data['email'],
            $data['password']
        );

        if (!empty($result['error'])) {
            return Response::error($result['error'], 409);
        }

        return Response::success("User registered successfully");
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['email']) || empty($data['password'])) {
            return Response::error("Email and password are required", 422);
        }

        $authService = new AuthService();
        $user = $authService->login($data['email'], $data['password']);

        if (!$user) {
            return Response::error("Invalid credentials", 401);
        }

        $token = JWT::encode([
            "id" => $user['id'],
            "email" => $user['email'],
            "role" => $user['role'],
            "iat" => time(),
            "exp" => time() + 3600
        ], $_ENV['JWT_SECRET'], 'HS256');

        return Response::success("Login successful", [
            "token" => $token
        ]);
    }
}