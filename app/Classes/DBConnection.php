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
        $config = require __DIR__ . '/../Core/config.php';
        $config = $config['database'];
        print_r($config);
        try {
            $this->conn = new PDO(
                $config['connection'].';dbname='.$config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "<p> Message: " . $e->getMessage() . "</p>";
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
    public static function getInstance(): self
    {
        if(!self::$instance)
        {
            self::$instance = new DBConnection();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
