<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Contact extends BaseController
{
    public function index(){

       

       $data['pagedata'] = $this->common_model->FetchAllOrder('saiyoojyam_contact','contact_id ','DESC');

        return view('admin/view_contact',$data);
    }

    public function Edit($id){

        $data['contact'] = $this->common_model->SingleRow(' saiyoojyam_contact',array('contact_id' => $id));

        if($this->request->getMethod() === 'POST'){

            
            $update_data = $this->request->getPost();

            

            $this->common_model->EditData($update_data,array('contact_id' => $id),'saiyoojyam_contact');

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Contact Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Contact/Edit/'.$id));
            

        }

        return view('admin/edit_contact',$data);
    }


   
}
