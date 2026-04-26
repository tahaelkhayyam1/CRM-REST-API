<?php

require_once __DIR__ . '/../../config/Database.php';

class Client
{
    private $conn;
    private $table = "clients";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($name, $email, $phone, $company, $status)
    {
        $sql = "INSERT INTO {$this->table}
                (name, email, phone, company, status)
                VALUES
                (:name, :email, :phone, :company, :status)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":phone" => $phone,
            ":company" => $company,
            ":status" => $status
        ]);
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE email = :email";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":email" => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}
            ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $email, $phone, $company, $status)
    {
        $sql = "UPDATE {$this->table}
            SET name = :name,
                email = :email,
                phone = :phone,
                company = :company,
                status = :status
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":name" => $name,
            ":email" => $email,
            ":phone" => $phone,
            ":company" => $company,
            ":status" => $status
        ]);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id" => $id
        ]);
    }
}
