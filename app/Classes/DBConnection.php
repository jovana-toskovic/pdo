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
    private $sql;
    private $condition;
    private $values = [];
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

    //set fetch mode

    public function fetchMode(object $stmt)
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
    private function prepareQuery(string $sql, array $array=null): object
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($array);
        return $stmt;
    }

    //set table
    // public function table($table)
    // {
    //     $this->table = $table;
    //     return $this;
    // }
    public function table(string $table): object
    {
        $this->table = $table;
        return $this;
    }
    
    //set condition
    // public function where($where)
    // {
    //     $queryCondition = "";
    //     $queryArray = [];
        
    //     $keys = array_keys($where);

    //     $operator = $where[$keys[1]];
    //     $queryCondition = $queryCondition . " " . $keys[0] . " " . $operator . " ?";
 
    //     array_push($queryArray, $where[$keys[0]]);


    //     $logicalOperator = array_key_exists(2, $keys) ? $where[$keys[2]] : '';
    //     $queryCondition = $queryCondition . " " . $logicalOperator;
       
    //     $this->condition = $this->condition . $queryCondition;
    //     $this->values = array_merge($this->values, $queryArray);
    //     return $this;
    // }

    //set condition
    public function where(array $where): object
    {
        $this->sql .= $where[0] . " " . $where[1] . "? ";
        array_push($this->values, $where[2]);
        return $this;
    }

    //stringify query parameters
    public function stringifyArray(array $array, string $bindString = ', '): string
    {
        return implode($bindString, $array);
    }

    //logical operators
    public function and(): object
    {
        $this->sql .= '&& ';
        return $this;
    }
    public function or(): object
    {
        $this->sql .= '|| ';
        return $this;
    }

    // select 
    public function select(array $parameters = ['*']): object 
    {
        $queryParameters = $this->stringifyArray($parameters);
        $this->sql = "SELECT $queryParameters FROM $this->table WHERE ";
        return $this;
    }

    //insert
    public function insert(array $columns = [], array $values = []): object 
    {
        $queryColumns = $this->stringifyArray($columns);
        $queryValues = $this->stringifyArray(array_fill(0, count($columns), '?'));
        $this->values = array_merge($this->values, $values);
        $this->sql = "INSERT INTO $this->table ($queryColumns) VALUES ($queryValues);";
        return $this;
    }

    //update
    public function update(array $columns = [], array $values = []): object
    {
        $queryColumns = $this->stringifyArray($columns, ' = ?, ') . " = ?";
        $this->values = array_merge($this->values, $values);
        $this->sql = "UPDATE $this->table SET $queryColumns WHERE ";
        return $this;
    }

    //delete
    public function delete(): object
    {
        $this->sql = "DELETE FROM $this->table WHERE ";
        return $this;
    }

    //set fetch mode
    public function fetch(string $mode, string $class=null): object
    {
        $this->mode = $mode;
        $this->class = $class;
        return $this;
    }

    //get all
    public function getAll(): array
    {
        $stmt = $this->prepareQuery($this->sql, $this->values);
        $this->values = [];
        echo $this->sql;
        $this->sql = "";
        $this->table = "";
        $this->fetchMode($stmt);
        return $stmt->fetchAll();
    }

    // public function get($table, $mode, $class=null)
    // {
    //     $sql = "SELECT * FROM $table;";
    //     $stmt = $this->prepareQuery($sql);
    //     $this->fetchMode($stmt);
    //     return $stmt->fetchAll();
    // }

    // public function runQuery($sql, $array)
    // {
    //     $this->prepareQuery($sql, $array);
    // }

    public function post()
    {
        echo $this->sql;
        $stmt = $this->prepareQuery($this->sql, $this->values);
        $this->values = [];
        $this->sql = "";
        $this->table = "";
    }


}
