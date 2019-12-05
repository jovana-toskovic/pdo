<?php

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;

return new QueryBuilder(
    DBConnection::getInstance()->getConnection()
);