<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index(){

        return view('admin/add_users');
    }

    public function view(){

        return view('admin/view');
    }
}
