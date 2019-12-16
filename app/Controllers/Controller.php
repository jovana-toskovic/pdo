<?php

namespace App\Controllers;

use App\Classes\DBConnection;
use App\Classes\QueryBuilder;
use App\Classes\Validation\Validator;
use App\Libs\PageHelper;

use App\Classes\Post;


class Controller
{
    private $post;
    private $db;

    public function __construct()
    {
        // QueryBuilder bi trebaloda da instanciramo samo na jednom mestu, koliko vidim vec je instanciran u bootstrap failu
        $this->db = new QueryBuilder(
            DBConnection::getInstance()->getConnection(),
            new Validator()
        );
        $this->post = new Post();

    }

    // post actions
    public function index($arg=[])
    {
        var_dump($arg);
        if (!empty($arg)) {
            $posts = $this->db->table($this->post)->where($arg)->get();
        } else {
            $posts = $this->db->table($this->post)->getAll();
        }

//      view('post/index.php', $posts);
        require PageHelper::displayPage('posts.view.php');
    }

    public function edit($arg)
    {
        $condition = ['id' => $arg['id']];
        $this->db->table(new Post)->where($condition)->update($arg);
        $this->index($condition);
    }

    public function create($arg) {
        $this->db->table(new Post)->insert($arg);
        $this->index();
    }

    public function delete($arg) {
        $this->db->table(new Post)->where($arg)->delete();
        $this->index();
    }

}
