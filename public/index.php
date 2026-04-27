<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Web\AuthController;

session_start();

/*
|------------------------
| CONTROLLER
|------------------------
*/
$auth = new AuthController();

/*
|------------------------
| ROUTING INPUT
|------------------------
*/
$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? null;

/*
|------------------------
| ACTIONS (POST LOGIC)
|------------------------
*/
if ($action === 'register') {
    $auth->register();
    exit;
}

if ($action === 'login') {
    $auth->login();
    exit;
}
if ($action === 'create-client') {
    $client = new \App\Controllers\Web\ClientController();
    $client->store();
    exit;
}
if ($action === 'delete-client') {
    $client = new \App\Controllers\Web\ClientController();
    $client->delete($_GET['id']);
    exit;
}

if ($action === 'update-client') {
    $client = new \App\Controllers\Web\ClientController();
    $client->update($_GET['id']);
    exit;
}


if ($action === 'logout') {
    $auth->logout();
    exit;
}
/*
|------------------------
| VIEWS ROUTING
|------------------------
*/
switch ($page) {

    case 'login':
        require_once __DIR__ . '/../views/auth/login.php';
        break;

    case 'register':
        require_once __DIR__ . '/../views/auth/register.php';
        break;

    case 'clients':
        require_once __DIR__ . '/../views/clients/index.php';
        break;

    case 'create-client':
        require_once __DIR__ . '/../views/clients/create.php';
        break;

    case 'edit-client':
        require_once __DIR__ . '/../views/clients/edit.php';
        break;
    default:
        echo "404 - Page not found";
}
