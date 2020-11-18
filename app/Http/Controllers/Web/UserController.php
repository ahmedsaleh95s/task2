<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function login()
    {
        return view('users.login');
    }

    public function all()
    {
        return view('users.all');
    }
}
