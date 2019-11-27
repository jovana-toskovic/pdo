<?php

namespace App\Classes;

use PDO;
use PDOException;
use App\Contracts\ConnectionInterface;

class DBConnection implements ConnectionInterface
{
    private static $instance = false;
    private $conn;

    private $dbName = "pdo";
    private $dbUser = "root";
    private $dbPassword = "43>RDaW5";
    private $dbHost = "localhost";

    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->dbHost}; dbname={$this->dbName}", $this->dbUser, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    //make clone private
    private function __clone()
    {
    }
    //make clone wakeup
    private function __wakeup()
    {
    }

    //get only one instance
    public static function getInstance(): object
    {
        if(!self::$instance)
        {
            self::$instance = new DBConnection();
        }

        return self::$instance;
    }

    public function getConnection(): object
    {
        return $this->conn;
    }
}
