<?php

namespace App\Classes;

use PDO;
use PDOException;
use App\Contracts\ConnectionInterface;

class DBConnection implements ConnectionInterface
{
    private static $instance = false;
    private $conn;

    private function __construct($config=[])
    {
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
    //make private wakeup
    private function __wakeup()
    {
    }

    //get only one instance
    public static function getInstance($config=[]): self
    {
        if(!self::$instance)
        {
            self::$instance = new DBConnection($config);
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
