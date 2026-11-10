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

        );

        $data['tariffs'] = $this->common_model->buildingSearch('saiyoojyam_tariffs','tariffs_id','Desc',$joins,$building,$room_type);

        $usedTariffs = [];
        if (!empty($data['tariffs'])) {
            foreach ($data['tariffs'] as $t) {
                $usage = $this->getTariffUsage($t);
                if ($usage) {
                    $usedTariffs[$t->tariffs_id] = $usage['uid_text'];
                }
            }
        }
        $data['used_tariffs'] = $usedTariffs;

        $data['rooms_types'] = $this->common_model->FetchAll('saiyoojyam_room_type');

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        return view('admin/view_tariff',$data);
    }

    public function Add(){
        
        if ($this->request->getMethod() === 'POST') {

            $buildings  = $this->request->getPost('tariffs_building');
            $room_types = $this->request->getPost('tariffs_room_types');
            $prices     = $this->request->getPost('tariffs_price');

            if (!is_array($room_types)) {
                $buildings  = array($buildings);
                $room_types = array($room_types);
                $prices     = array($prices);
            }

            $added_count = 0;
            $errors = array();

            foreach ($room_types as $index => $room_type_id) {
                if (empty($room_type_id)) continue;

                $building_id  = isset($buildings[$index]) ? $buildings[$index] : '';
                $price        = isset($prices[$index]) ? $prices[$index] : 0;

                // Check if tariff already exists for this building & room type
                $tariff_avaliable = $this->common_model->FetchWhere('saiyoojyam_tariffs', array(
                    'tariffs_building'   => $building_id,
                    'tariffs_room_types' => $room_type_id
                ));

                if (!empty($tariff_avaliable)) {
                    $rt_info = $this->common_model->SingleRow('saiyoojyam_room_type', array('room_type_id' => $room_type_id));
                    $rt_name = $rt_info ? $rt_info->room_type_name : "Room Type #$room_type_id";
                    $errors[] = "$rt_name already exists for this building";
                } else {
                    $insert_data = array(
                        'tariffs_building'   => $building_id,
                        'tariffs_room_types' => $room_type_id,
                        'tariffs_rooms'      => null,
                        'tariffs_price'      => $price,
                        'tariffs_created_at' => date('Y-m-d')
                    );

                    $building_fees = $this->common_model->SingleRow('saiyoojyam_building', array('building_id' => $building_id));

                    if (!empty($building_fees)) {
                        $insert_data['tariffs_admission_fees'] = $building_fees->building_admission_fees;
                        $insert_data['tariffs_caution_deposit'] = $building_fees->building_caution_deposit;
                    }

                    $this->common_model->InsertData('saiyoojyam_tariffs', $insert_data);
                    $added_count++;
                }
            }

            if ($added_count > 0) {
                $response['status'] = "true";
                $msg = "$added_count Tariff(s) Added Successfully";
                if (!empty($errors)) {
                    $msg .= ". Skipped: " . implode(', ', $errors);
                }
                $response['msg'] = $msg;
            } else {
                $response['status'] = "false";
                $response['msg'] = !empty($errors) ? implode(', ', $errors) : "Please select valid room type(s) to add tariff";
            }

            echo json_encode($response);
            return;

        }

        $selected_building_id = $this->request->getGet('building_id');
        $selected_type_id     = $this->request->getGet('room_type_id');

        $data['selected_building_id'] = $selected_building_id;
        $data['selected_type_id']     = $selected_type_id;

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        if (!empty($selected_building_id)) {
            $data['preselected_room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type', array('room_type_building_id' => $selected_building_id));
        } else {
            $data['preselected_room_types'] = [];
        }

        return view('admin/add_tariff', $data);

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

         );
        $data['tariff'] = $this->common_model->SingleRowJoin('saiyoojyam_tariffs',array('tariffs_id' => $id),$joins); 

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        $data['room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $data['tariff']->tariffs_building));

        $data['history'] = $this->common_model->FetchWhereOrderby('saiyoojyam_tariff_history',array('tariff_history_tariff_id' => $id),'tariff_history_id','DESC');

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $old_price = $data['tariff']->tariffs_price;

            $building_fees = $this->common_model->SingleRow('saiyoojyam_building',array('building_id' => $this->request->getPost('tariffs_building')));

            if(!empty($building_fees)){

                $update_data['tariffs_admission_fees'] = $building_fees->building_admission_fees;

                $update_data['tariffs_caution_deposit'] = $building_fees->building_caution_deposit;

            }

            $update_data['tariffs_updated_at'] = date('Y-m-d'); 

            $this->common_model->EditData($update_data,array('tariffs_id' => $id),'saiyoojyam_tariffs');

            $new_price = $this->request->getPost('tariffs_price');

            if($new_price != $old_price){

                $history_data = array(
                    'tariff_history_tariff_id'    => $id,
                    'tariff_history_old_price'    => $old_price,
                    'tariff_history_new_price'    => $new_price,
                    'tariff_history_effective_month' => date('Y-m'),
                    'tariff_history_created_at'   => date('Y-m-d H:i:s'),
                );

                $this->common_model->InsertData('saiyoojyam_tariff_history',$history_data);

            }

            $flashdata = array(

                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Tariff/Edit/'.$id));


        }

        return view('admin/edit_tariff',$data);

    }


    private function getTariffUsage($tariff)
    {
        if (empty($tariff)) {
            return null;
        }

        $db = \Config\Database::connect();
        $tariffId   = (int) $tariff->tariffs_id;
        $buildingId = (int) ($tariff->tariffs_building ?? 0);
        $roomTypeId = (int) ($tariff->tariffs_room_types ?? 0);

        $usedInmates = [];

        // 1. Direct tariff assignment in inmates
        $inmatesByTariff = $db->table('saiyoojyam_inmates')
            ->where('inmates_tariffs', $tariffId)
            ->get()
            ->getResult();
        foreach ($inmatesByTariff as $inm) {
            $usedInmates[$inm->inmates_id] = $inm;
        }

        // 2. Inmates occupying rooms of this building & room type
        if ($buildingId > 0 && $roomTypeId > 0) {
            $inmatesByType = $db->table('saiyoojyam_inmates')
                ->where('inmates_building', $buildingId)
                ->where('inmates_room_type', $roomTypeId)
                ->get()
                ->getResult();
            foreach ($inmatesByType as $inm) {
                $usedInmates[$inm->inmates_id] = $inm;
            }
        }

        // 3. Invoices check for linked inmates
        $hasInvoices = false;
        if (!empty($usedInmates) && $db->tableExists('saiyoojyam_invoice')) {
            $inmateIds = array_keys($usedInmates);
            $invCount = $db->table('saiyoojyam_invoice')
                ->whereIn('invoice_inmates', $inmateIds)
                ->countAllResults();
            if ($invCount > 0) {
                $hasInvoices = true;
            }
        }

        if (empty($usedInmates) && !$hasInvoices) {
            return null;
        }

        $uids = [];
        foreach ($usedInmates as $inm) {
            $uids[] = !empty($inm->inmates_uid) ? $inm->inmates_uid : ('#' . $inm->inmates_id);
        }

        return [
            'count'    => count($usedInmates),
            'inmates'  => $usedInmates,
            'uid_text' => implode(', ', array_slice($uids, 0, 3)) . (count($uids) > 3 ? ' and ' . (count($uids) - 3) . ' more' : ''),
        ];
    }

    public function Delete($id){

        $tariff = $this->common_model->SingleRow('saiyoojyam_tariffs', array('tariffs_id' => $id));

        if (empty($tariff)) {
            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Tariff not found',
            );
            $this->session->setFlashdata('alert', $flashdata);
            return redirect()->to(site_url('Admin/Tariff'));
        }

        $usage = $this->getTariffUsage($tariff);

        if (!empty($usage)) {
            $uidStr = !empty($usage['uid_text']) ? ' (' . $usage['uid_text'] . ')' : '';
            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Cannot delete: This tariff price is currently used by inmate(s)' . $uidStr . '.',
            );

            $this->session->setFlashdata('alert', $flashdata);

            return redirect()->to(site_url('Admin/Tariff'));
        }

        $this->common_model->DeleteData('saiyoojyam_tariff_history', array('tariff_history_tariff_id' => $id));

        $this->common_model->DeleteData('saiyoojyam_tariffs', array('tariffs_id' => $id));

        $flashdata = array(
            'type' => 'success',
            'msg'  => 'Tariff Deleted Successfully',
        );

        $this->session->setFlashdata('alert', $flashdata);

        return redirect()->to(site_url('Admin/Tariff'));

    }


    
}
