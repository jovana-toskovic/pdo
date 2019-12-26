<?php

namespace App\Controllers;

use App\Classes\Post;
use App\Classes\User;
use App\Controllers\Controller;

class PostController extends Controller
{

    public function __construct()
    {
        parent::__construct(new Post());
    }

    public function index($arg=[])
    {
        $posts;
        if (!empty($arg)) {
            $posts = $this->db->join($this->model, 'users', 'posts.user_id' )
                ->select(['users.username AS username', 'posts.body', 'posts.title', 'posts.user_id AS user_id'])
                ->where($arg)->getAll();
        } else {
            $posts = $this->db->join($this->model, 'users', 'posts.user_id' )
                ->select(['users.username AS username', 'posts.body', 'posts.user_id AS user_id'])
                ->getAll();
        }
        view('posts.view', $posts);
    }

    public function edit($arg)
    {
        $id = parent::edit($arg);
        $this->redirect("posts/$id");

    }

    public function update($arg)
    {
        $posts = $this->db->join($this->model, 'users', 'posts.user_id' )
            ->select(['users.username AS username', 'posts.body', 'posts.title', 'posts.user_id AS user_id'])
            ->where(["posts.user_id" => 'users.id'])->getAll();
        $post = $posts[0];
        if ($post->user_id === $_SESSION['id']) {
            view('posts.edit.view', $post);
        } else {
            $error = "You cant edit this post.";
            view('error.view', $error);
        }

    }

    public function store($arg=[])
    {
        $users = $this->db->table(new User())->where(['id' => $_SESSION['id']])->get();

        $username = $users[0]->username;
        echo $username;
        view('posts.create.view', $username);
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
