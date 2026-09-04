<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Locations extends BaseController
{
    public function index(){

        return view('admin/add_locations');
    }

    
}
