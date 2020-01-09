<?php
namespace App\Controllers;

use App\Classes\User;
use App\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();

    }
    public function showLoginForm($arg=[])
    {
        view('users.login.view');
    }

    public function login($arg)
    {
        list($user) = $this->db->table(new User())
            ->select(['*'])
            ->where(['email' => $arg['email']])
            ->get();

        if(password_verify($arg['password'], $user->password)) {
            $this->session->startSession();
            $this->session->setStoredValue(['id' => $user->id]);
            $this->redirect('home');
        }
    }

    public function logout()
    {
        $this->session->startSession();
        $this->session->destroySession();
        $this->redirect('login');
        
    }
}
