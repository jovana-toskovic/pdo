<?php

namespace App\Controllers;

use App\Core\Helper;

class Controller
{
    private $db;
    private $model;

    public function __construct($model)
    {
        $modelName = "App\Classes\\" . rtrim(ucfirst($model), 's');
        $this->db = Helper::returnDB();
        $this->model = new $modelName();
    }

    public function index($arg=[])
    {
        //Db::table('users')->all();
        if (!empty($arg)) {
            $posts = $this->db->table($this->model)->where($arg)->get();
        } else {
            $posts = $this->db->table($this->model)->getAll();
        }
        view('posts.view', $posts);
    }

    public function edit($arg)
    {
        $condition = ['id' => $arg['id']];
        $this->db->table($this->model)->where($condition)->update($arg);
        $this->index($condition);
    }

    public function create($arg) {
        $this->db->table($this->model)->insert($arg);
        $this->index();
    }

    public function delete($arg) {
        $this->db->table($this->model)->where($arg)->delete();
        $this->index();
    }

}
