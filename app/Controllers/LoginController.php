<?php
namespace App\Controllers;

use App\Classes\User;
use App\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm($arg=[])
    {
        view('users.login.view');
    }

    public function login($arg)
    {

        $users = $this->db->table(new User())
            ->where(['email' => $arg['email']])
            ->get();
        $user = $users[0];

        if(password_verify($arg['password'], $user->password)) {
            $_SESSION['id'] = $user->id;
            $this->redirect('home');
        }
    }

    public function logout()
    {

        echo "logout";
        
    }
}
