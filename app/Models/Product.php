<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Product
{
    private $conn;
    private $table = "products";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll($search = null, $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";

        if ($search) {
            $sql .= " AND (name LIKE :search OR description LIKE :search)";
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);

        if ($search) {
            $stmt->bindValue(':search', "%$search%");
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function create($name, $description, $price)
    {
        $sql = "INSERT INTO {$this->table}
                (name, description, price)
                VALUES
                (:name, :description, :price)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $name,
            ":description" => $description,
            ":price" => $price
        ]);
    }



    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":id" => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id" => $id
        ]);
    }

public function update($id, $name, $description, $price)
    {
        $sql = "UPDATE {$this->table} SET
                name = :name,
                description = :description,
                price = :price
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":name" => $name,
            ":description" => $description,
            ":price" => $price
        ]);
    }


}
