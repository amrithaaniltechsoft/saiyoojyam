<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Facilities extends BaseController
{
    public function index(){

        $data['facilities'] = $this->common_model->SingleRow('saiyoojyam_facilities',array('facilities_id' => 1));

        return view('admin/view_facilities',$data);
    }

    public function Edit($id){

        $data['facilities'] = $this->common_model->SingleRow('saiyoojyam_facilities',array('facilities_id' => 1));

        if ($this->request->getMethod() === 'POST') {

            $update_data = [
                'facilities_description'  => $this->request->getPost('description'),
                'facilities_video1'       => $this->request->getPost('video1'),
                'facilities_video2'       => $this->request->getPost('video2'),
            ];

            $this->common_model->EditData($update_data,array('facilities_id' => 1),'saiyoojyam_facilities');

            $flashdata = array(
                'type' => 'success',
                'msg' => 'Facilities Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Facilities/Edit/'.$id));

        }

        return view('admin/edit_facilities',$data);
    }


   
}
