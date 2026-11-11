<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RoomTypes extends BaseController
{
    public function index(){

        $building = $this->request->getGet('building') ?? '';
        $room_type = $this->request->getGet('room_type') ?? '';

        $db = \Config\Database::connect();
        $builder = $db->table('saiyoojyam_room_type');

        if (!empty($building)) {
            $builder->where('room_type_building_id', $building);
        }

        if (!empty($room_type)) {
            $builder->where('room_type_id', $room_type);
        }

        $builder->orderBy('room_type_id', 'DESC');
        $data['pagedata'] = $builder->get()->getResult();

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building', 'building_name', 'ASC');

        if (!empty($building)) {
            $data['rooms_types'] = $this->common_model->FetchWhereOrderby('saiyoojyam_room_type', array('room_type_building_id' => $building), 'room_type_name', 'ASC');
        } else {
            $data['rooms_types'] = $this->common_model->FetchAllOrder('saiyoojyam_room_type', 'room_type_name', 'ASC');
        }

        $data['selected_building']  = $building;
        $data['selected_room_type'] = $room_type;

        return view('admin/view_room_type', $data);
    }


   

    public function Add(){

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        if ($this->request->getMethod() === 'POST') {

            $insert_data = $this->request->getPost();

            $insert_data['room_type_name'] = preg_replace('/\s+/', ' ', trim($insert_data['room_type_name']));
            $insert_data['room_type_capacity'] = !empty($insert_data['room_type_capacity']) ? max(1, (int)$insert_data['room_type_capacity']) : 1;

            $existing = $this->common_model->SingleRowTrimmedWhere('saiyoojyam_room_type','room_type_name',$insert_data['room_type_name'],array('room_type_building_id' => $insert_data['room_type_building_id']));

            if(!empty($existing)){

                $response['status'] = "false";

                $response['msg'] = "Room type already exists";

                echo json_encode($response);
                return;

            }

            $insert_data['room_type_slug'] = $this->common_model->CreateSlug($insert_data['room_type_name'],'room_type_name','saiyoojyam_room_type');
            
            $insert_data['room_type_created_at'] = date('Y-m-d'); 

            $id = $this->common_model->InsertData('saiyoojyam_room_type',$insert_data);

            $response['status'] = "true";

            $response['msg'] = "Data Added Successfully";

            echo json_encode($response);
            return;

        }

        return view('admin/add_room_type',$data);


    }

    public function Edit($id){

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        $data['room_type'] = $this->common_model->SingleRow('saiyoojyam_room_type',array('room_type_id' => $id)); 
        
        if ($this->request->getMethod() === 'POST') {

            $update_data = $this->request->getPost();

            $update_data['	room_type_updated_at'] = date('Y-m-d'); 

            if($data['room_type']->room_type_slug==$this->request->getPost('room_type_name'))
            {
                $slug = $data['room_type']->room_type_slug;
            }
            else
            {
            
                $slug = $this->common_model->CreateSlug($update_data['room_type_name'],'room_type_name','saiyoojyam_room_type');

            }

            $update_data['room_type_slug'] = $slug;
            $update_data['room_type_capacity'] = !empty($update_data['room_type_capacity']) ? max(1, (int)$update_data['room_type_capacity']) : 1;

            $this->common_model->EditData($update_data,array('room_type_id' => $id),'saiyoojyam_room_type');

            // Keep rooms_capacity for existing rooms of this room type synchronized
            $this->common_model->EditData(['rooms_capacity' => (int)$update_data['room_type_capacity']], array('rooms_type' => $id), 'saiyoojyam_rooms');

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/RoomTypes/Edit/'.$id));

        }


        return view('admin/edit_room_type',$data);
    }


    public function Delete($id){

        $room_type = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_type' => $id)); 


        if(empty($room_type)){

            $this->common_model->DeleteData('saiyoojyam_room_type',array('room_type_id' => $id));

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

        return redirect()->to(site_url().'Admin/RoomTypes');
    }

    
}
