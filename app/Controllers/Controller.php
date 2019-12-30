<?php

namespace App\Controllers;

use App\Core\DB;

class Controller
{
    protected $db;
    protected $model;

    public function __construct($model=null)
    {
        if ($model !== null) $this->model = $model;
        $this->db = DB::return();
    }

    public function redirect($url)
    {
        header("Location: " . URL_PATH . $url);
    }
}
