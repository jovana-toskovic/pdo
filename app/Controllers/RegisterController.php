<?php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Classes\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function showRegisterForm($arg=[])
    {
        view('users.register.view');
    }

    public function register($arg=[])
    {
        echo 'here';
        $arg['password'] = password_hash($arg['password'], PASSWORD_DEFAULT);
        $this->db->table($this->model)->insert($arg);
        $this->redirect('login');
    }
}
