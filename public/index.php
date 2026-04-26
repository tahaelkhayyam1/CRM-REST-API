<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth = new AuthController();

/**
 * Get clean route
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/**
 * Remove project base path
 */
$basePath = '/clientflow-api/public';
$route = str_replace($basePath, '', $uri);

$method = $_SERVER['REQUEST_METHOD'];

switch ($route) {

    case '/register':
        if ($method === 'POST') {
            $auth->register();
            exit;
        }
        break;

    case '/login':
        if ($method === 'POST') {
            $auth->login();
            exit;
        }
        break;
    case '/profile':
        if ($method === 'GET') {
            $auth->profile();
            exit;
        }
        break;
    default:
        echo json_encode([
            "status" => "error",
            "message" => "Route not found",
            "route" => $route
        ]);
        exit;
}
