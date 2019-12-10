<?php

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;
use App\Classes\Validation\Validator;

return new QueryBuilder(
    DBConnection::getInstance()->getConnection(),
    new Validator()
);