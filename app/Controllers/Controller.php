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
        if (!empty($arg) ) {
            $posts = $this->db->table($this->post)->where($arg)->get();
        } else {
            $posts = $this->db->table($this->post)->getAll();
        }

//        view('post/index.php', $posts);
        require PageHelper::displayPage('posts.view.php');
    }

    public function edit($arg)
    {
        var_dump($arg);
        echo 'edit';
        $condition = ['id' => $arg['id']];
        $data = $arg;
        unset($data['id']);

        $this->db->table(new Post)->where($condition)->update($data);

        $posts = $this->index($condition);


        require PageHelper::displayPage('posts.view.php');


    }

}


// Što se tiče rutera. Treba da napraviš klasu koja hvata sve requeste.
// Ukoliko se putanja iz url adrese poklapa sa putanjom koju si
// definisala u ruteru treba da se izvrši odredjena akcija.
// Nema potreba da gadjaš direktnon php failove