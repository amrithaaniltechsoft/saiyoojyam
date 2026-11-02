<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BuildingFees extends BaseController
{
    public function index(){

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        return view('admin/view_building_fees',$data);
    }


    public function Edit($id){

        $data['building'] = $this->common_model->SingleRow('saiyoojyam_building',array('building_id' => $id));

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $update_data['building_updated_at'] = date('Y-m-d'); 

            $this->common_model->EditData($update_data,array('building_id' => $id),'saiyoojyam_building');

            // Automatically sync tariffs for this building with the updated admission fee and caution deposit
            $tariffSync = [];
            if (isset($update_data['building_admission_fees'])) {
                $tariffSync['tariffs_admission_fees'] = $update_data['building_admission_fees'];
            }
            if (isset($update_data['building_caution_deposit'])) {
                $tariffSync['tariffs_caution_deposit'] = $update_data['building_caution_deposit'];
            }
            if (!empty($tariffSync)) {
                $this->common_model->EditData($tariffSync, array('tariffs_building' => $id), 'saiyoojyam_tariffs');
            }

            $flashdata = array(

                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/BuildingFees/Edit/'.$id));

        }

        return view('admin/edit_building_fees',$data);

    }


    
}
