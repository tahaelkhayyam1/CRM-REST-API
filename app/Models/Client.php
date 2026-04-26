<?php
namespace App\Models;
use App\Config\Database;
use PDO;
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
    public function getAll($search = null, $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";

        if ($search) {
            $sql .= " AND (name LIKE :search OR email LIKE :search OR company LIKE :search)";
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
