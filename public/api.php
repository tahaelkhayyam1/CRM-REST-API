<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\Api\AuthController as ApiAuthController;
use App\Controllers\Api\ClientController as ApiClientController;
use App\Controllers\Api\ProductController as ApiProductController;
use Dotenv\Dotenv;

/*
|----------------------------------
| ENV LOAD
|----------------------------------
*/
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/*
|----------------------------------
| CONTROLLERS
|----------------------------------
*/
$auth = new ApiAuthController();
$client = new ApiClientController();
$product = new ApiProductController();

/*
|----------------------------------
| ROUTE PARSING
|----------------------------------
*/
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = str_replace('/clientflow-api/public/api.php', '', $uri);

/*
|----------------------------------
| AUTH ROUTES (API)
|----------------------------------
*/
Router::post('/register', [$auth, 'register']);
Router::post('/login', [$auth, 'login']);
Router::get('/profile', [$auth, 'profile']);

/*
|----------------------------------
| CLIENT ROUTES (API)
|----------------------------------
*/
Router::get('/clients', [$client, 'index']);
Router::post('/clients', [$client, 'store']);
Router::put('/clients/{id}', [$client, 'update']);
Router::delete('/clients/{id}', [$client, 'delete']);


/*
|----------------------------------
| PRODUCT ROUTES (API)
|----------------------------------
*/
Router::get('/products', [$product, 'index']);
Router::post('/products', [$product, 'store']);
Router::delete('/products/{id}', [$product, 'delete']);
Router::put('/products/{id}', [$product, 'update']);
















/*
|----------------------------------
| EXECUTE ROUTER
|----------------------------------
*/
Router::resolve($route, $_SERVER['REQUEST_METHOD']);