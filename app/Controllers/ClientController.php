<?php

require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Validators/ClientValidator.php';
class ClientController
{
    public function store()
    {
        header("Content-Type: application/json");

        // JWT protection
        AuthMiddleware::verifyToken();

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ClientValidator::validateCreate($data);

        if (!empty($errors)) {
            echo json_encode([
                "status" => "error",
                "errors" => $errors
            ]);
            return;
        }
        $clientModel = new Client();

        if ($clientModel->findByEmail($data['email'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Client email already exists"
            ]);
            return;
        }

        $clientModel->create(
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['status'] ?? 'active'
        );

        echo json_encode([
            "status" => "success",
            "message" => "Client created successfully"
        ]);
    }

    public function index()
    {
        header("Content-Type: application/json");

        // Protected route
        AuthMiddleware::verifyToken();

        $clientModel = new Client();

        $clients = $clientModel->getAll();

        echo json_encode([
            "status" => "success",
            "data" => $clients
        ]);
    }

    public function update($id)
    {
        header("Content-Type: application/json");

        AuthMiddleware::verifyToken();

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ClientValidator::validateUpdate($data);

        if (!empty($errors)) {
            echo json_encode([
                "status" => "error",
                "errors" => $errors
            ]);
            return;
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

        echo json_encode([
            "status" => "success",
            "message" => "Client updated successfully"
        ]);
    }



    public function delete($id)
    {
        header("Content-Type: application/json");

        AuthMiddleware::verifyToken();

        $client = new Client();
        $client->delete($id);

        echo json_encode([
            "status" => "success",
            "message" => "Client deleted successfully"
        ]);
    }
}
