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
            $rooms      = $this->request->getPost('tariffs_rooms');
            $prices     = $this->request->getPost('tariffs_price');

            if (!is_array($rooms)) {
                $buildings  = array($buildings);
                $room_types = array($room_types);
                $rooms      = array($rooms);
                $prices     = array($prices);
            }

            $added_count = 0;
            $errors = array();

            foreach ($rooms as $index => $room_id) {
                if (empty($room_id)) continue;

                $building_id  = isset($buildings[$index]) ? $buildings[$index] : '';
                $room_type_id = isset($room_types[$index]) ? $room_types[$index] : '';
                $price        = isset($prices[$index]) ? $prices[$index] : 0;

                $tariff_avaliable = $this->common_model->FetchWhere('saiyoojyam_tariffs', array('tariffs_rooms' => $room_id));

                if (!empty($tariff_avaliable)) {
                    $room_info = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_id' => $room_id));
                    $room_name = $room_info ? $room_info->rooms_name : "Room #$room_id";
                    $errors[] = "$room_name already exists";
                } else {
                    $insert_data = array(
                        'tariffs_building'   => $building_id,
                        'tariffs_room_types' => $room_type_id,
                        'tariffs_rooms'      => $room_id,
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
                $response['msg'] = !empty($errors) ? implode(', ', $errors) : "Please select valid room(s) to add tariff";
            }

            echo json_encode($response);

            return;

        }

        $selected_room_id     = $this->request->getGet('room_id');
        $selected_building_id = $this->request->getGet('building_id');
        $selected_type_id     = $this->request->getGet('room_type_id');

        if (!empty($selected_room_id)) {
            $target_room = null;
            if (is_numeric($selected_room_id)) {
                $target_room = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_id' => $selected_room_id));
            }
            if (!$target_room) {
                $target_room = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_name' => $selected_room_id));
            }
            if ($target_room) {
                $selected_room_id = $target_room->rooms_id;
                if (empty($selected_building_id)) {
                    $selected_building_id = $target_room->rooms_building;
                }
                if (empty($selected_type_id)) {
                    $selected_type_id = $target_room->rooms_type;
                }
            }
        }

        $data['selected_building_id'] = $selected_building_id;
        $data['selected_type_id']     = $selected_type_id;
        $data['selected_room_id']     = $selected_room_id;

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        if (!empty($selected_building_id)) {
            $data['preselected_room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type', array('room_type_building_id' => $selected_building_id));
        } else {
            $data['preselected_room_types'] = [];
        }

        if (!empty($selected_building_id) && !empty($selected_type_id)) {
            $data['preselected_rooms'] = $this->common_model->FetchWhereOrderby('saiyoojyam_rooms', array(
                'rooms_building' => $selected_building_id,
                'rooms_type'     => $selected_type_id
            ), 'rooms_name', 'ASC');
        } else {
            $data['preselected_rooms'] = [];
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

        $data['history'] = $this->common_model->FetchWhereOrderby('saiyoojyam_tariff_history',array('tariff_history_tariff_id' => $id),'tariff_history_id','DESC');

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $old_price = $data['tariff']->tariffs_price;

            $room_avaliable = $this->common_model->CheckDataWhere('saiyoojyam_tariffs','tariffs_rooms',$this->request->getPost('tariffs_rooms'),$data['tariff']->tariffs_id,'tariffs_id');
            
            if(!empty($room_avaliable)){
                 
                $flashdata = array(
                'type' => 'error',
                'msg'  => 'This room already exists. Please choose a different name',
                );
    
                $this->session->setFlashdata('alert',$flashdata);

            }

            else{
                

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

            }

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
        $tariffId = (int) $tariff->tariffs_id;
        $roomId   = (int) $tariff->tariffs_rooms;

        $usedInmates = [];

        // 1. Direct tariff assignment in inmates (all statuses: active, pending, checked_out)
        $inmatesByTariff = $db->table('saiyoojyam_inmates')
            ->where('inmates_tariffs', $tariffId)
            ->get()
            ->getResult();
        foreach ($inmatesByTariff as $inm) {
            $usedInmates[$inm->inmates_id] = $inm;
        }

        // 2. Inmates currently or historically occupying the room of this tariff (all statuses)
        if ($roomId > 0) {
            $inmatesByRoom = $db->table('saiyoojyam_inmates')
                ->where('inmates_rooms', $roomId)
                ->get()
                ->getResult();
            foreach ($inmatesByRoom as $inm) {
                $usedInmates[$inm->inmates_id] = $inm;
            }

            // 3. Inmate room transfer history
            if ($db->tableExists('saiyoojyam_inmate_room_history')) {
                $histRows = $db->table('saiyoojyam_inmate_room_history')
                    ->groupStart()
                        ->where('room_history_old_room', $roomId)
                        ->orWhere('room_history_new_room', $roomId)
                    ->groupEnd()
                    ->get()
                    ->getResult();
                $histIds = [];
                foreach ($histRows as $hr) {
                    if (!empty($hr->room_history_inmates_id)) {
                        $histIds[] = (int) $hr->room_history_inmates_id;
                    }
                }
                if (!empty($histIds)) {
                    $histInmates = $db->table('saiyoojyam_inmates')
                        ->whereIn('inmates_id', array_unique($histIds))
                        ->get()
                        ->getResult();
                    foreach ($histInmates as $inm) {
                        $usedInmates[$inm->inmates_id] = $inm;
                    }
                }
            }
        }

        // 4. Invoices check for linked inmates
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
