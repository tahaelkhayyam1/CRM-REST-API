<?php

namespace App\Controllers\Api;

use App\Middleware\AuthMiddleware;
use App\Validators\ProductValidator;
use App\Helpers\Response;
use App\Models\Product;

class ProductController
{

    public function index()
    {
        AuthMiddleware::requireRole(['admin', 'employee']);

        $search = $_GET['search'] ?? null;
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;

        $offset = ($page - 1) * $limit;

        $product = new Product();
        $data = $product->getAll($search, $limit, $offset);

        return Response::success("Products list", [
            "page" => (int)$page,
            "limit" => (int)$limit,
            "data" => $data
        ]);
    }

    public function store()
    {

        AuthMiddleware::requireRole(['admin', 'employee']);

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ProductValidator::validateCreate($data);
        if (!empty($errors)) {
            return Response::error($errors, 422);
        }

        $product = new Product();

        $product->create(
            $data['name'],
            $data['description'],
            $data['price']
        );

        return Response::success("Product created successfully");
    }


    public function delete($id)
    {
        AuthMiddleware::requireRole(['admin']);

        $product = new Product();

        if (!$product->findById($id)) {
            return Response::error("Product not found", 404);
        }

        $product->delete($id);

        return Response::success("Product deleted successfully");
    }



    public function update($id)
    {
        AuthMiddleware::requireRole(['admin', 'employee']);

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = ProductValidator::validateUpdate($data);
        if (!empty($errors)) {
            return Response::error($errors, 422);
        }

        $product = new Product();

        if (!$product->findById($id)) {
            return Response::error("Product not found", 404);
        }

        $product->update(
            $id,
            $data['name'],
            $data['description'],
            $data['price']
        );

        return Response::success("Product updated successfully");
    }
}
