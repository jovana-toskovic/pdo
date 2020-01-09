<?php

namespace App\Classes;

use PDO;
use PDOStatement;
use Exception;
use App\Contracts\ModelInterface;
use App\Classes\Validation\QueryBuilderValidator;

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

    private $secondModel = "";
    private $selected = "*";

    public function __construct($connection, QueryBuilderValidator $validator)
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
        $this->model = "";
        $this->secondModel = "";
        $this->selected = "*";
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

    //inner join
    public function join(ModelInterface $model, $secondModel, $what, $type = "inner"): self
    {
        $this->secondModel = $secondModel;
        $joinType = strtoupper($type);
        $this->sql = " $joinType JOIN $this->secondModel ON $what = $secondModel.id";
        return $this->table($model);
    }

    //left join
    public function leftJoin(ModelInterface $model, $secondModel, $what): self
    {
        return $this->join($model, $secondModel, $what, 'left');
    }

    //right join
    public function rightJoin(ModelInterface $model, $secondModel, $what): self
    {
        return $this->join($model, $secondModel, $what, 'right');
    }

    public function select($arg)
    {
        //SELECT $this->selected FROM $this->table";
        if(!empty($arg)) {
            $this->selected = implode(", " , $arg);
        }
        $sql = $this->sql;
       $this->sql = "SELECT $this->selected FROM $this->table " . $sql;
    return $this;
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
        $whereSql = "";
        foreach ($data as $key=>$value){
            $queryOperator = $this->setLogicalOperator($logicalOperator);
            $whereSql .= "$queryOperator " . " " . $key . " $operator ?";
            array_push($this->values, $value);
        }
        if(!strpos($whereSql, 'WHERE')){
            $whereSql = ' WHERE ' . $whereSql;
        }
        $sql = $this->sql;
        $this->sql = $sql . $whereSql;
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
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($array);
        return $stmt;
    }

     //select all
    public function getAll(): array
    {
        $stmt = $this->prepareQuery($this->sql, $this->values);
        $this->fetchMode($stmt, 'CLASS');
        $this->unset();
        return $stmt->fetchAll();
    }

    //select
    public function get(): array
    {
        $stmt = $this->prepareQuery($this->sql, $this->values);
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
        $this->values = array_merge($dataValues, $this->values);

        $sql = "UPDATE $this->table SET $columns $this->sql";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->unset();
    }

    //delete
    public function delete(): void
    {
        $sql = "DELETE FROM $this->table $this->sql;";
        $stmt = $this->prepareQuery($sql, $this->values);
        $this->unset();
    }
}
