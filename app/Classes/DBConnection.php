<?php

namespace App\Classes;

use PDO;
use PDOException;
use App\Contracts\ConnectionInterface;


class DBConnection implements ConnectionInterface
{
    private static $instance = false;
    private $conn;

    private function __construct()
    {
        $config = require_once (dirname(__DIR__).'/../config.php');
        try {
            $this->conn = new PDO("mysql:host={$config['host']}; dbname={$config['database']}", $config['username'], $config['pass']);
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
