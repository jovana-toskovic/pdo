<?php

namespace App\Classes;

use PDO;

class DBConnection
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
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new DBConnection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    //set fetch mode

    public function fetchMode($mode, $class, $stmt)
    {
        switch (strtoupper($mode)) {
            case "CLASS":
                return $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
            case "ASSOC":
                return $stmt->setFetchMode(PDO::FETCH_ASSOC);
            case "BOTH":
                return $stmt->setFetchMode(PDO::FETCH_BOTH);
            case "NUM":
                return $stmt->setFetchMode(PDO::FETCH_NUM);
                
            default:
                return $stmt->setFetchMode(PDO::FETCH_ASSOC);
        }
    }

    //prepare query

    public function prepareQuery($sql, $class, $array, $mode)
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($array);
        $this->fetchMode($mode, $class, $stmt);
        return $stmt;
    }

    //get methods

    public function get($sql, $mode, $class=null, $array=null)
    {
       return $this->prepareQuery($sql, $class, $array, $mode)->fetch();

    }

    public function getAll($sql, $mode, $class=null, $array=null)
    {
       return $this->prepareQuery($sql, $class, $array, $mode)->fetchAll();
    }





    public function runQuery($sql, $array)
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($array);
        return $stmt;
    }

}
