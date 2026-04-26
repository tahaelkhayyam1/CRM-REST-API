<?php
namespace App\Middleware;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public static function verifyToken()
    {
        header("Content-Type: application/json");

        $headers = getallheaders();

        if (
            !isset($headers['Authorization'])
        ) {
            echo json_encode([
                "status" => "error",
                "message" => "Authorization token required"
            ]);
            exit;
        }

        $authHeader = $headers['Authorization'];

        $token = str_replace(
            'Bearer ',
            '',
            $authHeader
        );

        try {
            $decoded = JWT::decode(
                $token,
                new Key($_ENV['JWT_SECRET'], 'HS256')
            );

            return $decoded;

        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid or expired token"
            ]);
            exit;
        }
    }

    public static function requireRole($allowedRoles)
{
    $user = self::verifyToken();

    if (!in_array($user->role, $allowedRoles)) {
        echo json_encode([
            "status" => "error",
            "message" => "Access denied"
        ]);
        exit;
    }

    return $user;
}
}