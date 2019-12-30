<?php
namespace App\Controllers;

use App\Classes\User;
use App\Controllers\Controller;

class LoginController extends Controller
{
     public function index($arg=[])
     {
         view('users.login.view');
     }

     public function create($arg)
     {
         echo 'here';
         $users = $this->db->table(new User())
             ->where(['email' => $arg['email']])
             ->get();
         $user = $users[0];
        echo $arg['password'];
        echo $user->password;
         if(password_verify($arg['password'], $user->password)) {
            $_SESSION['id'] = $user->id;
            echo 'yay';
         }
     }
}
