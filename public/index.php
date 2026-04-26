<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/ClientController.php';


$auth = new AuthController();
$client = new ClientController();
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


$clientId = null;

// Detect /clients/{id}
if (preg_match('#^/clients/(\d+)$#', $route, $matches)) {
    $clientId = $matches[1];
    $route = '/clients/{id}';
}

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
    case '/clients':

        if ($method === 'POST') {
            $client->store();
            exit;
        }

        if ($method === 'GET') {
            $client->index();
            exit;
        }

        break;


    case '/clients/{id}':

        if ($method === 'PUT') {
            $client->update($clientId);
            exit;
        }

        if ($method === 'DELETE') {
            $client->delete($clientId);
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
