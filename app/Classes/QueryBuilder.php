<?php

namespace App\Classes;

use PDO;
use App\Contracts\ConnectionInterface;
use App\Classes\Post;
use App\Classes\DBConnection;

class QueryBuilder
{
    private $connection;

    //query
    private $table;
    private $model;
    private $sql;
    private $condition;
    private $values = [];
    private $mode;
    private $class;

    private $numberOfWhere;


    public function __construct()
    {
        $this->connection = DBConnection::getInstance()->getConnection();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    //set fetch mode
    public function fetchMode(object $stmt, $mode)
    {
        switch (strtoupper($mode)) {
            case "CLASS":
                return $stmt->setFetchMode(PDO::FETCH_CLASS,  get_class($this->model));
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

    // set table
    public function table($model): self
    {
        $this->model = $model;
        $this->table = $model->getTableName();
        return $this;
    }

    //set condition
    public function where(array $where, $logicalOperator='&&'): object
    {
        $this->numberOfWhere += 1;
        $queryOperator = $this->numberOfWhere > 1 ? $logicalOperator : '';
        $this->sql .= "$queryOperator " . $where[0] . " " . $where[1] . " ? ";
        array_push($this->values, $where[2]);
        return $this;
    }

    public function orWhere(array $where): self
    {
        return $this->where($where, "||");
    }

    //prepare query
    private function prepareQuery(string $sql, array $array=null): object
    {
        echo $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($array);
        return $stmt;
    }

     //select all
    public function getAll(): array
    {
        $sql = "SELECT * FROM $this->table;";
        $stmt = $this->prepareQuery($sql);
        $this->fetchMode($stmt, 'CLASS');
        return $stmt->fetchAll();
    }

    //select
    public function get(): array
    {
        $sql = "SELECT * FROM $this->table WHERE $this->sql;";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->fetchMode($stmt, 'CLASS');
        return $stmt->fetchAll();
    }

    //set table
    // public function table($table)
    // {
    //     $this->table = $table;
    //     return $this;
    // }
   
    
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

   

    // //stringify query parameters
    // public function stringifyArray(array $array, string $bindString = ', '): string
    // {
    //     return implode($bindString, $array);
    // }

    // //logical operators
    // public function and(): object
    // {
    //     $this->sql .= '&& ';
    //     return $this;
    // }
    // public function or(): object
    // {
    //     $this->sql .= '|| ';
    //     return $this;
    // }

    // // select 
    // public function select(array $parameters = ['*']): object 
    // {
    //     $queryParameters = $this->stringifyArray($parameters);
    //     $this->sql = "SELECT $queryParameters FROM $this->table WHERE ";
    //     return $this;
    // }

    // //insert
    // public function insert(array $columns = [], array $values = []): object 
    // {
    //     $queryColumns = $this->stringifyArray($columns);
    //     $queryValues = $this->stringifyArray(array_fill(0, count($columns), '?'));
    //     $this->values = array_merge($this->values, $values);
    //     $this->sql = "INSERT INTO $this->table ($queryColumns) VALUES ($queryValues);";
    //     return $this;
    // }

    //update
    // public function update(array $columns = [], array $values = []): object
    // {
    //     $queryColumns = $this->stringifyArray($columns, ' = ?, ') . " = ?";
    //     $this->values = array_merge($this->values, $values);
    //     $this->sql = "UPDATE $this->table SET $queryColumns WHERE ";
    //     return $this;
    // }

    //delete
    // public function delete(): object
    // {
    //     $this->sql = "DELETE FROM $this->table WHERE ";
    //     return $this;
    // }

    //set fetch mode
    // public function fetch(string $mode): object
    // {
    //     $this->mode = $mode;
    //     return $this;
    // }

    //get all
    // public function getAll(): array
    // {
    //     $stmt = $this->prepareQuery($this->sql, $this->values);
    //     $this->values = [];
    //     echo $this->sql;
    //     $this->sql = "";
    //     $this->table = "";
    //     $this->fetchMode($stmt);
    //     return $stmt->fetchAll();
    // }

    

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

    // public function post(): void
    // {
    //     echo $this->sql;
    //     $stmt = $this->prepareQuery($this->sql, $this->values);
    //     $this->values = [];
    //     $this->sql = "";
    //     $this->table = "";
    // }
}
