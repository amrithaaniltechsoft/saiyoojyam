<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Tariff extends BaseController
{
    public function index(){

        if(!empty($this->request->getGet('building'))){
            
            $building = $this->request->getGet('building');
        }
        else{

            $building = "";
        }

       

        if(!empty($this->request->getGet('room_type'))){

            $room_type = $this->request->getGet('room_type');
        }
        else{

            $room_type = "";
        }

        $joins = array(

            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'tariffs_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'tariffs_room_types',
            ),
            array(
                'table' => 'saiyoojyam_rooms',
                'pk'    => 'rooms_id',
                'fk'    => 'tariffs_rooms',
            ),

        );

        $data['tariffs'] = $this->common_model->buildingSearch('saiyoojyam_tariffs','tariffs_id','Desc',$joins,$building,$room_type);

        $data['rooms_types'] = $this->common_model->FetchAll('saiyoojyam_room_type');

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        return view('admin/view_tariff',$data);
    }

    public function Add(){
        
        if ($this->request->getMethod() === 'POST') {

            $insert_data = $this->request->getPost();

            $rooms = $this->request->getPost('tariffs_rooms');

            $tariff_avaliable = $this->common_model->FetchWhere('saiyoojyam_tariffs',array('tariffs_rooms' => $rooms));

            if(!empty($tariff_avaliable)){

                $response['status'] = "false";

                $response['msg'] = "This room already exists. Please choose a different name";

            }else{
 

                if(empty($this->request->getPost('tariffs_caution_deposit'))){

                    $insert_data['tariffs_caution_deposit'] = $this->request->getPost('tariffs_price');

                }

                $insert_data['tariffs_created_at'] = date('Y-m-d'); 

                $id = $this->common_model->InsertData('saiyoojyam_tariffs',$insert_data);

                $response['status'] = "true";

                $response['msg'] = "Data Added Successfully";

            }

            echo json_encode($response);

            return;

        }

        //$data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        $data['rooms'] = $this->common_model->FetchAllOrder('saiyoojyam_rooms','rooms_name','ASC');

        return view('admin/add_tariff',$data);


    }

    
    public function Edit($id){
        
        $joins = array(

            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'tariffs_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'tariffs_room_types',
            ),
            array(
                'table' => 'saiyoojyam_rooms',
                'pk'    => 'rooms_id',
                'fk'    => 'tariffs_rooms',
            ),

         );
        $data['tariff'] = $this->common_model->SingleRowJoin('saiyoojyam_tariffs',array('tariffs_id' => $id),$joins); 

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        $data['rooms'] = $this->common_model->FetchAllOrder('saiyoojyam_rooms','rooms_id','DESC');

        $data['room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $data['tariff']->tariffs_building));

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $room_avaliable = $this->common_model->CheckDataWhere('saiyoojyam_tariffs','tariffs_rooms',$this->request->getPost('tariffs_rooms'),$data['tariff']->tariffs_id,'tariffs_id');
            
            if(!empty($room_avaliable)){
                 
                $flashdata = array(
                'type' => 'error',
                'msg'  => 'This room already exists. Please choose a different name',
                );
    
                $this->session->setFlashdata('alert',$flashdata);

            }

            else{
                
                $update_data['tariffs_updated_at'] = date('Y-m-d'); 

                $this->common_model->EditData($update_data,array('tariffs_id' => $id),'saiyoojyam_tariffs');

                $flashdata = array(

                    'type' => 'success',
                    'msg'  => 'Data Updated Successfully',
                );
        
                $this->session->setFlashdata('alert',$flashdata);

            }

            return redirect()->to(site_url('Admin/Tariff/Edit/'.$id));


        }

        return view('admin/edit_tariff',$data);

    }


    public function Delete($id){

        $this->common_model->DeleteData('saiyoojyam_tariffs',array('tariffs_id' => $id));

        $flashdata = array(
            'type' => 'success',
            'msg' => 'Date Deleted Successfully',
        );

        $this->session->setFlashdata('alert',$flashdata);

        return redirect()->to(site_url().'Admin/Tariff');


    }


    
}
