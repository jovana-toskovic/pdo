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
        $posts = $this->db
            ->join($this->model, 'users', 'posts.user_id' )
            ->select([
                'users.username AS username',
                'posts.body',
                'posts.id AS id',
                'posts.user_id AS user_id'
            ])
            ->getAll();
        view('posts.view', $posts);
    }

    public function show($arg=[])
    {
        $id = ['posts.id' => $arg['id']];
        $posts = $this->db
            ->join($this->model, 'users', 'posts.user_id' )
            ->select([
                'users.username AS username',
                'posts.body',
                'posts.id AS id',
                'posts.user_id AS user_id'
            ])
            ->where($id)
            ->getAll();

        view('posts.view', $posts);
    }

    public function update($arg)
    {
        $condition = ['id' => $arg['id']];
        $id = $condition['id'];
        $this->db->table($this->model)->where($condition)->update($arg);
        $this->redirect("posts/$id");
    }

    public function edit($arg)
    {
        $this->session->startSession();
        list($post) = $this->db
            ->join($this->model, 'users', 'posts.user_id' )
            ->select([
                'users.username AS username',
                'posts.body',
                'posts.id AS id',
                'posts.title',
                'posts.user_id AS user_id'
            ])
            ->where(["posts.id" => $arg['id']])
            ->getAll();

        if(!empty($post) && $post->user_id === $this->session->getStoredValue('id')) {
            view('posts.edit.view', $post);
        } else {
            $error = "You cant edit this post.";
            view('error.view', $error);
        }
    }

    public function create($arg=[])
    {
        $this->session->startSession();
        list($user) = $this->db
            ->table(new User())
            ->select(['*'])
            ->where(['id' => $this->session->getStoredValue('id')])
            ->get();
        view('posts.create.view', $user);
    }

    public function store($arg) {
        $this->db->table($this->model)->insert($arg);
        $this->redirect('posts');
    }

    public function destroy($arg) {
        $this->db
            ->table($this->model)
            ->where($arg)
            ->delete();
        $this->redirect('posts');
    }

}
