<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Classes\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function index($arg=[])
    {

        $posts = $this->db->table($this->model)->getAll();
        view('users.view', $posts);
    }

    public function show($arg)
    {
        $posts = $this->db->table($this->model)->where($arg)->get();
        view('users.view', $posts);
    }

    public function update($arg)
    {
        $arg['password'] = password_hash($arg['password'], PASSWORD_DEFAULT);
        $condition = ['id' => $arg['id']];
        $id = $condition['id'];
        $this->db->table($this->model)->where($condition)->update($arg);
        $this->redirect("users/$id");
    }

    public function edit($arg)
    {
        $users = $this->db->table($this->model)->where($arg)->get();
        view('users.edit.view', $users[0]);
    }

    public function store($arg)
    {
        $this->db->table($this->model)->insert($arg);
    }

    public function destroy($arg) {
        $this->db->table($this->model)->where($arg)->delete();
        $this->redirect('users');
    }
}