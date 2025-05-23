<?php
namespace Api\Database;

use Exception;
use mysqli;
use mysqli_stmt;

class Database
{
    protected $connection = null;
    protected $dbHost;
    protected $dbUser;
    protected $dbPass;
    protected $dbName;

    protected $dbPort;

    public function __construct()
    {
        // if (getenv('DB_HOST') === false) {
        //     throw new Exception("Database environment variables not set.");
        // }
        // if (getenv('DB_USER') === false) {
        //     throw new Exception("Database environment variables not set.");
        // }
        // if (getenv('DB_PASSWORD') === false) {
        //     throw new Exception("Database environment variables not set.");
        // }
        // if (getenv('DB_NAME') === false) {
        //     throw new Exception("Database environment variables not set.");
        // }
        $this->dbHost = 'localhost';
        $this->dbUser = 'root';
        $this->dbPass = null;
        $this->dbName = 'test';
        $this->dbPort = 3306;

        try {
            error_reporting(0);
            mysqli_report(MYSQLI_REPORT_OFF);

            $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName, $this->dbPort);

            if (mysqli_connect_errno()) {
                die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
            }


            $this->connection->set_charset("utf8mb4");
        } catch (Exception $e) {
            echo $e->getMessage();
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function executeStatement(string $query = "", array $params = []): mysqli_stmt
    {
        $this->verifyConnection();

        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // default to string type
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        return $stmt;
    }

    private function verifyConnection(): void
    {
        if ($this->connection->connect_errno) {
            throw new Exception("Database connection lost: " . $this->connection->connect_error);
        }
    }
}