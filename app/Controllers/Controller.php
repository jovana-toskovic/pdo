<?php

namespace App\Controllers;

use App\Core\DB;
use App\Classes\Session;

class Controller
{
    protected $db;
    protected $model;
    protected $session;

    public function __construct($model=null)
    {
        if ($model !== null) $this->model = $model;
        $this->db = DB::return();
        $this->session = new Session();
    }

    public function redirect($url)
    {
        header("Location: " . URL_PATH . $url);
    }
}
