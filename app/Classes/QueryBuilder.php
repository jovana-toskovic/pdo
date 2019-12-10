<?php

namespace App\Classes;

use PDO;
use PDOStatement;
use Exception;
use App\Contracts\ModelInterface;

class QueryBuilder
{
    private $connection;

    private $validator;

    //query
    private $table;
    private $model;
    private $sql;
    private $values = [];
    private $errorMessages = [];
    private $error = false;

    private $numberOfWhere;

    public function __construct($connection, $validator)
    {
        $this->connection = $connection;
        $this->validator = $validator;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function isAssoc(array $array): bool
    {
        foreach($array as $key=>$value)
        {
            if (!is_string($key)){
                return false;
            }
        }
        return true;
    }

    private function annul()
    {
        $this->table = "";
        $this->sql = "";
        $this->values = [];
        $this->numberOfWhere = 0;
        $this->error = false;
    }

    //set fetch mode
    public function fetchMode(PDOStatement $stmt, $mode): bool
    {
        switch (strtoupper($mode)) {
            case "CLASS":
                return $stmt->setFetchMode(PDO::FETCH_CLASS,  get_class($this->model));
            case "BOTH":
                return $stmt->setFetchMode(PDO::FETCH_BOTH);
            case "NUM":
                return $stmt->setFetchMode(PDO::FETCH_NUM);
                
            default:
                return $stmt->setFetchMode(PDO::FETCH_ASSOC);
        }
    }

    // set table
    public function table(ModelInterface $model): self
    {
        $this->model = $model;
        $this->table = $model->getTableName();
        return $this;
    }

    private function setLogicalOperator(string $logicalOperator): string
    {
        $this->numberOfWhere += 1;
        return $this->numberOfWhere > 1 ? $logicalOperator : '';
    }

    //validate
//    public function validate($data): void
//    {
//        $operators = ['LIKE', "=", "!=", ">", "<", ">=", "<="];
//        echo "<br>";
//
//        foreach ($data as $key => $value) {
//
//            if($value === null) {
//                $this->error = true;
//                $this->errorMessages[] = "Invalid sql, $key must not be of the type null.";
//            }
//
//            if ($key !== "operator" && !in_array( $key, $this->model->getModelProperties(),true )) {
//                $this->error = true;
//                $this->errorMessages[] = "Invalid sql, $key does not exists in table.";
//            }
//
//            if($key === "operator" && !in_array($value, $operators, true) ) {
//                echo $value;
//
//                $this->error = true;
//                $this->errorMessages[] = "Invalid sql, operator $value is invalid.";
//            }
//        }
//    }

    //check sql
    public function validateArrayType($data) {
        if (!$this->isAssoc($data) ){
            $this->error = true;
            $this->errorMessages[] = "Invalid sql, wrong type of parameter sent, data must be of the type associative array.";
        }
    }

    //set condition
    public function where(array $where, string $logicalOperator=' &&'): self
    {

        if($this->isAssoc($where)){
            $this->validator->validate($where, $this->model);
            foreach ($where as $key=>$value){
                $queryOperator = $this->setLogicalOperator($logicalOperator);
                $this->sql .= "$queryOperator " . " " . $key . " = ?";
                array_push($this->values, $value);
            }
        }else {
            $this->validator->validate([$where[0] => $where[2], "operator" => $where[1]], $this->model);
            $queryOperator = $this->setLogicalOperator($logicalOperator);
            $this->sql .= "$queryOperator " . $where[0] . " " . $where[1] . " ? ";
            array_push($this->values, $where[2]);
        }
  
        return $this;
    }

    public function orWhere(array $where): self
    {
        return $this->where($where, " ||");
    }

    //prepare query
    private function prepareQuery(string $sql, array $array=null): PDOStatement
    {
        if(!empty($this->validator->errors)){
            foreach($this->validator->getErrors() as $error){
                throw new Exception($error);
            }
            die();
        }
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
        $this->annul();

        return $stmt->fetchAll();
    }

    private function implodeArray(array $array): string
    {
        return implode(', ', $array);
    }

    private function mergeArray($array1, $array2)
    {
        return array_merge( $array1, $array2);
    }

    //insert
    public function insert(array $data): void
    {
        $this->validator->validate($data, $this->model);
        $this->validateArrayType($data);
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $columns = $this->implodeArray($dataKeys);
        $values = $this->implodeArray(array_fill(0, count($dataKeys), '?'));
        $this->values = $this->mergeArray($this->values, $dataValues);

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values);";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->annul();
    }

    //update
    public function update(array $data): void
    {
        $this->validator->validate($data, $this->model);
        $this->validateArrayType($data);
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $columns = $this->implodeArray($dataKeys);
        $this->values = $this->mergeArray($dataValues, $this->values);

        $sql = "UPDATE $this->table SET $columns" . " = ? WHERE $this->sql";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->annul();
    }

    //delete
    public function delete(): void
    {
        $sql = "DELETE FROM $this->table WHERE $this->sql;";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->annul();

    }

}
