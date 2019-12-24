<?php

namespace App\Classes;

use App\Classes\DBConnection;
use PDO;
use PDOStatement;
use Exception;
use App\Contracts\ModelInterface;
use App\Classes\Validation\Validator;

class QueryBuilder
{
    private $connection;

    private $validator;

    //query
    private $table;
    private $model;
    private $sql;
    private $values = [];
    private $error = false;

    private $numberOfWhere;

    private $secondModel;
    private $secondTable;

    public function __construct($connection, Validator $validator)
    {
        $this->connection = $connection;
        $this->validator = $validator;
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

    //unset all
    private function unset()
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

    public function join(ModelInterface $model, ModelInterface $secondModel): self
    {
        $this->secondModel = $secondModel;
        $this->secondTable = $secondModel->getTableName();
        $this->table($model);

    }

    // set logical operator
    private function setLogicalOperator(string $logicalOperator): string
    {
        $this->numberOfWhere += 1;
        return $this->numberOfWhere > 1 ? $logicalOperator : '';
    }

    // set condition
    public function where(array $where, string $logicalOperator=' &&'): self
    {
        $operator = "=";
        if(!$this->isAssoc($where)){
            $operator =  $where[1];
            $data = [$where[0] => $where[2]];
        } else {
            $data = $where;
        }

        $this->validator->validate(array_merge($data, ["operator"=>$operator]), $this->model);

        foreach ($data as $key=>$value){

            $queryOperator = $this->setLogicalOperator($logicalOperator);
            $this->sql .= "$queryOperator " . " " . $key . " $operator ?";
            array_push($this->values, $value);
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
        if(!empty($this->validator->getErrors())){
            foreach($this->validator->getErrors() as $error){
                throw new Exception($error);
            }
            die();
        }
//        echo $sql;
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
        $this->unset();

        return $stmt->fetchAll();
    }

    private function implodeArray(array $array): string
    {
        return implode(', ', $array);
    }

    //insert
    public function insert(array $data): void
    {
        $this->validator->validate($data, $this->model);

        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $columns = $this->implodeArray($dataKeys);
        $values = $this->implodeArray(array_fill(0, count($dataKeys), '?'));
        $this->values = array_merge($this->values, $dataValues);

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values);";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->unset();
    }

    //update
    public function update(array $data): void
    {
        $this->validator->validate($data, $this->model);

        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $columns = [];
        foreach($dataKeys as $column) {
            $columns[] = $column . " = ?";
        }
        $columns = $this->implodeArray($columns);
        var_dump($columns);
        $this->values = array_merge($dataValues, $this->values);

        $sql = "UPDATE $this->table SET $columns WHERE $this->sql";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->unset();
    }

    //delete
    public function delete(): void
    {
        $sql = "DELETE FROM $this->table WHERE $this->sql;";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->unset();
    }
}
