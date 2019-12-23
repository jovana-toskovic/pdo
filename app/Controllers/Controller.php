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

    public function index($arg=[])
    {
        //Db::table('users')->all();
        if (!empty($arg)) {
            return $this->db->table($this->model)->where($arg)->get();
        } else {
            return $this->db->table($this->model)->getAll();
        }
    }

    public function edit($arg)
    {
        $condition = ['id' => $arg['id']];
        $id = $condition['id'];
        $this->db->table($this->model)->where($condition)->update($arg);
        return $id;
    }

    public function update($arg)
    {
        return $this->db->table($this->model)->where($arg)->get();
    }

    public function create($arg) {
        $this->db->table($this->model)->insert($arg);
    }

    public function delete($arg) {
        $this->db->table($this->model)->where($arg)->delete();
    }

    public function redirect($url){
        header("Location: " . URL_PATH . $url);
    }

}
