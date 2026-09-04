<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Seo extends BaseController
{
    public function index(){

        $data['pagedata'] = $this->common_model->FetchAllOrder('saiyoojyam_seo','id','asc');

        return view('admin/view_seo',$data);
    }


    public function Edit($id){
          
        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => $id)); 

        
        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $update_data['updated_at'] = date('Y-m-d'); 

            $this->common_model->EditData($update_data,array('id' => $id),'saiyoojyam_seo');

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Seo/Edit/'.$id));


        }

        return view('admin/edit_seo',$data);

    }

    


   
}
