<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BedRentals extends BaseController
{
    public function index(){
        
        $data['inmates'] = $this->common_model->FetchAllOrder('saiyoojyam_inmates','inmates_name','ASC');

        return view('admin/add_bed_rental',$data);
    }


    public function Add(){

        $insert_data = $this->request->getPost();

        $insert_data['bed_rental_create_at'] = date('Y-m-d'); 

        $id = $this->common_model->InsertData('saiyoojyam_bed_rental',$insert_data);

        $data['status'] = "true";

        $data['msg'] = "Data Added Successfully";

        echo json_encode($data);


    }
    

    public function view(){

        return view('admin/view_rental');
    }
}
