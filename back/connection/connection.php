<?php

class Database {
    private $host = "localhost";
    private $dbname = "football_db";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->dbname
            );

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }

            $this->conn->set_charset("utf8mb4");

        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }

        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}


define('DB_HOST', 'localhost');
define('DB_NAME', 'football_db');
define('DB_USER', 'root');
define('DB_PASS', '');
?>