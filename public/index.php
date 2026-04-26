<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\ClientController;





 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// THEN router
 
$auth = new AuthController();
$client = new ClientController();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/clientflow-api/public';

$route = str_replace($base, '', $uri);

/*
|----------------------------------
| AUTH ROUTES
|----------------------------------
*/
Router::post('/register', [$auth, 'register']);
Router::post('/login', [$auth, 'login']);
Router::get('/profile', [$auth, 'profile']);

/*
|----------------------------------
| CLIENT ROUTES
|----------------------------------
*/
Router::get('/clients', [$client, 'index']);
Router::post('/clients', [$client, 'store']);
Router::put('/clients/{id}', [$client, 'update']);
Router::delete('/clients/{id}', [$client, 'delete']);

/*
|----------------------------------
| RUN ROUTER
|----------------------------------
*/
Router::resolve($route, $_SERVER['REQUEST_METHOD']);