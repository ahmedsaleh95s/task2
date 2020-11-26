<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Resources\UserResource;
use App\Models\User;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    //
    public function login()
    {
        return view('users.login');
    }

    public function all(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function reservation()
    {
        return view('users.reservation');
    }
}
