<?php
namespace Api\Database;

use Exception;
use mysqli_stmt;

require_once __DIR__ . "/../tools/validateParams.php";


class Database
{
    protected $connection = null;
    protected $dbHost = getenv('DB_HOST');
    protected $dbUser = getenv('DB_USER');
    protected $dbPass = getenv('DB_PASSWORD');
    protected $dbName = getenv('DB_NAME');
    public function __construct()
    {
        try {
            $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param mixed $query
     * @param mixed $params
     * @throws \Exception
     * @return bool|mysqli_stmt
     */
    public function executeStatement($query = "", $params = [])
    {
        try {
            $this->verifyConnection();

            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to do prepared statement: " . $query);
            }

            if ($params) {
                $stmt->bind_param($params[0], $params[1]);
            }
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     * @return void
     */
    private function verifyConnection()
    {
        if ($this->connection->connect_errno) {
            throw new Exception("Database connection error: " . $this->connection->connect_error);
        }
    }

}