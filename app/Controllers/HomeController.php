<?php

namespace App\Controllers;

use App\Classes\User;
use App\Controllers\Controller;


class HomeController extends Controller
{

    public function index($arg=[])
    {
        view('home.view');
    }

}
