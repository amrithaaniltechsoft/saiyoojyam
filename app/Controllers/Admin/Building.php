<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Building extends BaseController
{
    public function index(){

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');
        
        return view('admin/view_building',$data);
    }

    public function Add(){
        
        if ($this->request->getMethod() === 'POST') {

            $insert_data = $this->request->getPost();

            $insert_data['building_name'] = preg_replace('/\s+/', ' ', trim($insert_data['building_name']));

            $existing = $this->common_model->SingleRowTrimmed('saiyoojyam_building','building_name',$insert_data['building_name']);

            if(!empty($existing)){

                $response['status'] = "false";

                $response['msg'] = "Building name already exists";

                echo json_encode($response);

                return;
                
            }

            $insert_data['building_slug'] = $this->common_model->CreateSlug($insert_data['building_name'],'building_name','saiyoojyam_building');
            
            $insert_data['building_created_at'] = date('Y-m-d'); 

            $id = $this->common_model->InsertData('saiyoojyam_building',$insert_data);

            $response['status'] = "true";

            $response['msg'] = "Data Added Successfully";

            echo json_encode($response);

            return;

        }
 

        return view('admin/add_building');


    }


    public function Edit($id){

        $data['building'] = $this->common_model->SingleRow('saiyoojyam_building',array('building_id' => $id));

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $update_data['building_name'] = preg_replace('/\s+/', ' ', trim($update_data['building_name']));

            $existing = $this->common_model->SingleRowTrimmed('saiyoojyam_building','building_name',$update_data['building_name']);

            if(!empty($existing) && $existing->building_id != $id){

                $flashdata = array(
                    'type' => 'error',
                    'msg'  => 'Building name already exists',
                );

                $this->session->setFlashdata('alert',$flashdata);

                return redirect()->to(site_url('Admin/Building/Edit/'.$id));

            }

              
            if($data['building']->building_slug==$this->request->getPost('building_name'))
            {
                $slug = $data['building']->building_slug;
            }
            else
            {
                

                $slug = $this->common_model->CreateSlug($update_data['building_name'],'building_name','saiyoojyam_building');

            }

           
            
            $update_data['building_slug'] = $slug;

            $update_data['building_updated_at'] = date('Y-m-d'); 
            
           

            $this->common_model->EditData($update_data,array('building_id' => $id),'saiyoojyam_building');

             $flashdata = array(
                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Building/Edit/'.$id));
            

        }


        return view('admin/edit_building',$data);


    }


    public function Delete($id){
       
        $room_type = $this->common_model->SingleRow('saiyoojyam_room_type',array('room_type_building_id' => $id));

        $gallery = $this->common_model->SingleRow('saiyoojyam_gallery',array('gallery_category' => $id));

        
        if(empty($room_type) && empty($gallery)){
        
            $this->common_model->DeleteData('saiyoojyam_building',array('building_id' => $id));

            $flashdata = array(
                'type' => 'success',
                'msg' => 'Date Deleted Successfully',
            );

            $this->session->setFlashdata('alert',$flashdata);

        }
        else{

            $flashdata = array(
                'type' => 'error',
                'msg' => 'Cannot delete: Date is currently in use',
            );

            $this->session->setFlashdata('alert',$flashdata);
        }

        return redirect()->to(site_url().'Admin/Building');

    }

   


    
}
