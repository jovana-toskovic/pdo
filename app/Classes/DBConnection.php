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

    //query

    private $table;
    private $condition;
    private $values;
    private $mode;
    private $class;

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

    public function fetchMode($stmt)
    {
        switch (strtoupper($this->mode)) {
            case "CLASS":
                return $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
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

    public function prepareQuery($sql, $array=null)
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($array);
        return $stmt;
        
    }

    //set table
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }
    //set condition
    public function where($where)
    {
        $queryCondition = "";
        $queryArray = [];
        $operator = '';
        foreach($where as $condition){
            foreach($condition as $property=>$value){
           
                if ($property === 'operator'){
                    $operator = $value;
                }
                if ($property === 'logicalOperator'){
                    $queryCondition = $queryCondition . " $value";
                } 
                if ($property !== 'operator' && $property !== 'logicalOperator') {
                    $queryCondition = $queryCondition . " $property $operator ?";
                    array_push($queryArray, $value);
                }
            }
        }
        $this->condition = $queryCondition;
        $this->values = $queryArray;
        return $this;
    }
    //set fetch mode
    public function fetch($mode, $class=null)
    {
        $this->mode = $mode;
        $this->class = $class;
        return $this;

    }

    //get methods
    //instance->table("posts")->where( ["id'=>1, "logicalOperator"=>"||",  "author"=>"Anna"])->getAll();

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table WHERE $this->condition;";
        echo $sql;
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->fetchMode($stmt);
        return $stmt->fetchAll();
    }

    public function get($table, $mode, $class=null)
    {
        $sql = "SELECT * FROM $table;";
        $stmt = $this->prepareQuery($sql);
        $this->fetchMode($stmt);
        return $stmt->fetchAll();
    }

    public function runQuery($sql, $array)
    {
        $this->prepareQuery($sql, $array);
    }

    public function post($table, $fields, $values)
    {
        $tableFields = implode(', ', $fields);
        $sql = "INSERT INTO $table ($fields) VALUES ($values);";

    }
}
