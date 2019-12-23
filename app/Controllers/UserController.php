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
        $posts = parent::index($arg=[]);
        view('users.view', $posts);
    }

    public function edit($arg)
    {
        $arg['password'] = password_hash($arg['password'], PASSWORD_DEFAULT);
        $id = parent::edit($arg);
        $this->redirect("users/$id");
    }

    public function update($arg)
    {
        $users = parent::update($arg);
        view('users.edit.view', $users[0]);
    }

    public function store($arg=[])
    {
        view('users.create.view');
    }

    public function create($arg) {

        $arg['password'] = password_hash($arg['password'], PASSWORD_DEFAULT);

        parent::create($arg);
        $this->redirect('users');
    }

    public function delete($arg) {
        parent::delete($arg);
        $this->redirect('users');
    }
}