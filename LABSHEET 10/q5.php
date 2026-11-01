<?php

class Database {

    private static $instance = null;
    private $connection;

    private function __construct() {

        $host = "localhost";
        $dbname = "myproject_db";
        $username = "myproject_user";
        $password = "CHANGE_THIS_PASSWORD";

        try {

            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch(PDOException $e) {
            error_log($e->getMessage());
            die("Database connection failed");
        }
    }

    public static function getInstance() {

        if(self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>