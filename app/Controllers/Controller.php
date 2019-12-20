<?php

namespace App\Controllers;

use App\Core\DB;

class Controller
{
    private $db;
    private $model;

    public function __construct($model)
    {
        $modelName = "App\Classes\\" . rtrim(ucfirst($model), 's');
        $this->db = DB::return();
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
        $id = $condition['id'];
        $this->db->table($this->model)->where($condition)->update($arg);
        $this->redirect("posts/$id");

    }

    public function update($arg)
    {
        $post =  $this->db->table($this->model)->where($arg)->get();
        view('posts.edit.view', $post[0]);
    }

    public function store($arg=[])
    {
        view('posts.create.view');
    }

    public function create($arg) {
        if (!empty($arg)) {
            $this->db->table($this->model)->insert($arg);
            $this->redirect('posts');
        }
    }

    public function delete($arg) {
        $this->db->table($this->model)->where($arg)->delete();
        $this->redirect('posts');
    }


    function redirect($url){
        header("Location: " . URL_PATH . $url);
    }

}
