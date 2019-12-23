<?php

namespace App\Classes;
use App\Contracts\ModelInterface;

class User implements ModelInterface
{
    public $id;
    public $username, $password, $email;
    private $columnNames = Array("id", "username", "password", "email");
    public $table = 'user';

    public function getTableName(): string
    {
        return $this->table;
    }

    public function getColumnNames()
    {
        return $this->columnNames;
    }
}
