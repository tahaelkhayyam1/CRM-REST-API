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
}