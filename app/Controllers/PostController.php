<?php

namespace App\Controllers;

use App\Classes\Post;
use App\Controllers\Controller;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct(new Post());
    }

    public function index($arg=[])
    {
        $posts = parent::index($arg=[]);
        view('posts.view', $posts);
    }

    public function edit($arg)
    {
        $id = parent::edit($arg);
        $this->redirect("posts/$id");

    }

    public function update($arg)
    {
        $posts = parent::update($arg);
        view('posts.edit.view', $posts[0]);
    }

    public function store($arg=[])
    {
        view('posts.create.view');
    }

    public function create($arg) {
        parent::create($arg);
        $this->redirect('posts');
    }

    public function delete($arg) {
        parent::delete($arg);
        $this->redirect('posts');
    }

}
