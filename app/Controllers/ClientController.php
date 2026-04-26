<?php

require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Validators/ClientValidator.php';
require_once __DIR__ . '/../Helpers/Response.php';
require_once __DIR__ . '/../Core/Router.php';
class ClientController
{
    public function store()
    {
        header("Content-Type: application/json");

        // JWT protection
        AuthMiddleware::requireRole(['admin', 'employee']);
        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ClientValidator::validateCreate($data);

        if (!empty($errors)) {
            Response::error($errors);
        }
        $clientModel = new Client();

        if ($clientModel->findByEmail($data['email'])) {
            Response::error("Client email already exists");
        }

        $clientModel->create(
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['status'] ?? 'active'
        );

        Response::success("Client created successfully");
    }

    public function index()
    {
        header("Content-Type: application/json");

        AuthMiddleware::verifyToken();

        $search = $_GET['search'] ?? null;
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;

        $offset = ($page - 1) * $limit;

        $client = new Client();

        $data = $client->getAll($search, $limit, $offset);

        echo json_encode([
            "status" => "success",
            "page" => (int)$page,
            "limit" => (int)$limit,
            "data" => $data
        ]);
    }

    public function update($id)
    {
        header("Content-Type: application/json");

        AuthMiddleware::requireRole(['admin']);

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ClientValidator::validateUpdate($data);

        if (!empty($errors)) {
            Response::error($errors);
        }

        $client = new Client();

        $client->update(
            $id,
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['status'] ?? 'active'
        );

        Response::success("Client updated successfully");
    }



    public function delete($id)
    {
        AuthMiddleware::requireRole(['admin']);

        $client = new Client();
        $client->delete($id);

        Response::success("Client deleted successfully");
    }
}
