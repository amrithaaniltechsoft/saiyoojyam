<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Payments extends BaseController
{
    public function index(){

        return view('admin/add_payments');
    }

    public function View(){

        return view('admin/view_payments');
    }

    
}
