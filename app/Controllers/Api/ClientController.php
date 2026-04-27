<?php

namespace App\Controllers\Api;

use App\Helpers\Response;
use App\Models\Client;
use App\Middleware\AuthMiddleware;
use App\Validators\ClientValidator;

class ClientController
{
    public function index()
    {
        AuthMiddleware::verifyToken();

        $search = $_GET['search'] ?? null;
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;

        $offset = ($page - 1) * $limit;

        $client = new Client();
        $data = $client->getAll($search, $limit, $offset);

        return Response::success("Clients list", [
            "page" => (int)$page,
            "limit" => (int)$limit,
            "data" => $data
        ]);
    }

    public function store()
    {
        AuthMiddleware::requireRole(['admin', 'employee']);

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ClientValidator::validateCreate($data);
        if (!empty($errors)) {
            return Response::error($errors, 422);
        }

        $client = new Client();

        if ($client->findByEmail($data['email'])) {
            return Response::error("Client email already exists", 409);
        }

        $client->create(
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['status'] ?? 'active'
        );

        return Response::success("Client created successfully");
    }

    public function update($id)
    {
        AuthMiddleware::requireRole(['admin']);

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ClientValidator::validateUpdate($data);
        if (!empty($errors)) {
            return Response::error($errors, 422);
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

        return Response::success("Client updated successfully");
    }

    public function delete($id)
    {
        AuthMiddleware::requireRole(['admin']);

        $client = new Client();
        $client->delete($id);

        return Response::success("Client deleted successfully");
    }
}