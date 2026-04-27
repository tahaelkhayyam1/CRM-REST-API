<?php

namespace App\Controllers\Web;

use App\Models\Client;

class ClientController
{
    public function index()
    {
        session_start();

        $client = new Client();
        $data = $client->getAll(null, 100, 0);

        require_once __DIR__ . '/../../../views/clients/index.php';
    }

    public function create()
    {
        session_start();
        require_once __DIR__ . '/../../../views/clients/create.php';
    }

    public function store()
    {
        session_start();

        $data = $_POST;
        $client = new Client();

        if (empty($data['name']) || empty($data['email'])) {
            $_SESSION['error'] = "Name and email required";
            header("Location: /clientflow-api/public/index.php?page=create-client");
            exit;
        }

        if ($client->findByEmail($data['email'])) {
            $_SESSION['error'] = "Client already exists";
            header("Location: /clientflow-api/public/index.php?page=create-client");
            exit;
        }

        $client->create(
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            'active'
        );

        header("Location: /clientflow-api/public/index.php?page=clients");
        exit;
    }

    public function delete($id)
    {
        $client = new Client();
        $client->delete($id);

        header("Location: /clientflow-api/public/index.php?page=clients");
        exit;
    }


    public function update($id)
    {
        session_start();

        $data = $_POST;

        if (empty($data['name']) || empty($data['email'])) {
            $_SESSION['error'] = "Name and email are required";
            header("Location: /clientflow-api/public/index.php?page=edit-client&id=$id");
            exit;
        }

        $client = new \App\Models\Client();

        $client->update(
            $id,
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            'active'
        );

        header("Location: /clientflow-api/public/index.php?page=clients");
        exit;
    }
}
