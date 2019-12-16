<?php

namespace App\Contracts;

interface ModelInterface
{
    public function getTableName();

    public function getColumnNames();
}
