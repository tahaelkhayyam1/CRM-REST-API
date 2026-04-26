<?php

namespace App\Config;

use PDO;
use PDOException;
use Dotenv\Dotenv;

 

class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;

  public function __construct()
{
    $this->host = $_ENV['DB_HOST'] ?? 'localhost';
    $this->dbname = $_ENV['DB_NAME'] ?? 'clientflow_api';
    $this->username = $_ENV['DB_USER'] ?? 'root';
    $this->password = $_ENV['DB_PASS'] ?? '';
}

    public function connect()
    {
        try {
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );

            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $conn;

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}