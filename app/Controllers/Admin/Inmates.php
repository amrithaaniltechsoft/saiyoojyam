<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use \Mpdf\Mpdf;

use DateTime;

class Inmates extends BaseController
{
    public function index($uri_status = null){

        $db = \Config\Database::connect();

        // 1. Auto-migration: ensure ENUM includes 'rejected' and 'cancelled' on server
        try {
            $colRes = $db->query("SHOW COLUMNS FROM saiyoojyam_inmates LIKE 'inmates_status'")->getRow();
            if ($colRes && stripos($colRes->Type, "'rejected'") === false) {
                $db->query("ALTER TABLE saiyoojyam_inmates MODIFY COLUMN inmates_status ENUM('pending','active','checked_out','rejected','cancelled') NOT NULL DEFAULT 'pending'");
            }
            $db->query("ALTER TABLE saiyoojyam_inmates MODIFY COLUMN inmates_place_of_work varchar(255) NOT NULL DEFAULT ''");
        } catch (\Throwable $e) {}

        // 2. Auto-heal: convert any empty string or corrupted status records to 'rejected'
        try {
            $db->table('saiyoojyam_inmates')
                ->where('inmates_status', '')
                ->orWhere('inmates_status IS NULL', null, false)
                ->update(['inmates_status' => 'rejected']);
        } catch (\Throwable $e) {}

        $this->common_model->AutoCheckoutInmates();

        $ref = $this->request->getGet('ref');

        $check_in = $this->request->getGet('check_in');

        $check_out = $this->request->getGet('check_out');

        $conditions = array();

        $payMap = array('paid' => 1, 'unpaid' => 0, 'partial' => 2, 'advance' => 3);

        $status = $this->request->getGet('status');

        $pay = $this->request->getGet('pay');

        if(empty($status) && empty($pay) && !empty($uri_status)){

            if(preg_match('/^(active|checked_out)_(paid|unpaid|partial|advance)$/', $uri_status, $m)){

                $status = $m[1];

                $pay = $m[2];

            }
            elseif(array_key_exists($uri_status, $payMap)){

                $pay = $uri_status;

            }
            else{

                $status = $uri_status;

            }

        }

        if(!empty($pay) && !empty($status)){

            $data['pagedata'] = $this->common_model->InmatesByPaymentStatus($payMap[$pay], $status);

        }
        elseif(!empty($pay)){

            $data['pagedata'] = $this->common_model->InmatesByPaymentStatus($payMap[$pay]);

        }
        else{

            if(!empty($status) && in_array($status, array('active','checked_out'), true)){

                $conditions['inmates_status'] = $status;

            } elseif(empty($status)){

                // Only include legitimate active or checked-out inmates in official Inmates list
                $conditions['inmates_status IN'] = array('active', 'checked_out');

            }

            if(!empty($ref)){

                $conditions['inmates_uid'] = $ref;

            }

            if(!empty($check_in)){

                $conditions['inmates_check_in_date'] = $check_in;

            }

            if(!empty($check_out)){

                $conditions['inmates_check_out_date'] = $check_out;

            }

            $data['pagedata'] = $this->common_model->FetchInmatesActiveFirst($conditions);

        }

        $data['rooms_data'] = $this->common_model->FetchAll('saiyoojyam_rooms');

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        $data['room_types'] = $this->common_model->FetchAll('saiyoojyam_room_type');

        $db = \Config\Database::connect();
        $data['reffers'] = $db->table('saiyoojyam_inmates')
            ->whereNotIn('inmates_status', array('pending', 'rejected', 'cancelled'))
            ->orderBy('inmates_uid', 'ASC')
            ->get()
            ->getResult();

        $data['active_ref'] = $ref;

        $data['active_check_in'] = $check_in;

        $data['active_check_out'] = $check_out;

        $data['active_status'] = $status;

        $data['active_pay'] = $pay;

        
        return view('admin/view_inmates',$data);
    }


    public function View($id = null){

        if(empty($id)){
            return redirect()->to(site_url().'Admin/Inmates');
        }

        $joins = array(
            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'inmates_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'inmates_room_type',
            ),
            array(
                'table' => 'saiyoojyam_rooms',
                'pk'    => 'rooms_id',
                'fk'    => 'inmates_rooms',
            ),
        );

        $data['inmate'] = $this->common_model->SingleRowJoin('saiyoojyam_inmates',array('inmates_id' => $id),$joins);

        if(empty($data['inmate'])){

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Inmate not found',
            );

            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url().'Admin/Inmates');
        }

        $data['duration'] = $this->common_model->SingleRow('saiyoojyam_duration_of_stay',array('duration_id' => $data['inmate']->inmates_duration_of_stay));

        return view('admin/view_inmate',$data);
    }

    


    public function Add()
    {
    
        if ($this->request->getMethod() === 'POST') {

            // Get the uploaded files
            $idProof = $this->request->getFile('inmates_id_proof');
            $photo = $this->request->getFile('inmates_photo');

            $idProofName = null;
            $photoName = null;

            // Upload directory
            $uploadPath = WRITEPATH . 'uploads/inmates/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle ID Proof upload
            if ($idProof && $idProof->isValid() && !$idProof->hasMoved()) {
                $idProofName = $idProof->getRandomName();
                $idProof->move($uploadPath, $idProofName);
            } 

            // Handle Photo upload
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);
            } 
            
            // Collect other form inputs
            $check_in_date = $this->request->getPost('inmates_check_in_date');
            
            if(!empty($this->request->getPost('inmates_check_out_date'))){
                 
                $check_out_date = $this->request->getPost('inmates_check_out_date');
            }else{

                $check_out_date = "0000-00-00";
            }

            if($check_out_date != '0000-00-00' && strtotime($check_out_date) <= strtotime($check_in_date)){

                $response['status'] = false;

                $response['msg'] = 'Check out date must be after the check in date';

                echo json_encode($response);

                return;
            }
            
            
            $email = trim((string)$this->request->getPost('inmates_email'));
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['status'] = false;
                $response['msg'] = 'Please enter a valid email address.';
                echo json_encode($response);
                return;
            }

            // Check if email belongs to another active or pending resident (in Add mode)
            $db = \Config\Database::connect();
            if (!empty($email)) {
                $conflictInmate = $db->table('saiyoojyam_inmates')
                    ->where('LOWER(inmates_email)', strtolower($email))
                    ->whereIn('inmates_status', ['active', 'pending'])
                    ->get()
                    ->getRow();

                if ($conflictInmate) {
                    $response['status'] = false;
                    $response['msg'] = "The email '{$email}' is already registered to another resident ({$conflictInmate->inmates_name}).";
                    echo json_encode($response);
                    return;
                }
            }

            $roomId = $this->request->getPost('inmates_rooms');
            $buildingId = $this->request->getPost('inmates_building');
            $roomTypeId = $this->request->getPost('inmates_room_type');

            $db = \Config\Database::connect();
            $tariff = null;
            if (!empty($buildingId) && !empty($roomTypeId)) {
                $tariff = $db->table('saiyoojyam_tariffs')
                    ->where('tariffs_building', $buildingId)
                    ->where('tariffs_room_types', $roomTypeId)
                    ->get()
                    ->getRow();
            }

            if (!$tariff && !empty($roomId)) {
                $tariff = $db->table('saiyoojyam_tariffs')
                    ->where('tariffs_rooms', $roomId)
                    ->get()
                    ->getRow();
            }

            $tariffId = $tariff ? (int)$tariff->tariffs_id : 0;
            $admFee   = $tariff ? (float)$tariff->tariffs_admission_fees : 0.00;
            $cautDep  = $tariff ? (float)$tariff->tariffs_caution_deposit : 0.00;

            if ($admFee <= 0 || $cautDep <= 0) {
                $bRow = $db->table('saiyoojyam_building')->where('building_id', $buildingId)->get()->getRow();
                if ($bRow) {
                    if ($admFee <= 0) $admFee = (float)$bRow->building_admission_fees;
                    if ($cautDep <= 0) $cautDep = (float)$bRow->building_caution_deposit;
                }
            }

            $data = [
                
                'inmates_name'             => $this->request->getPost('inmates_name'),
                'inmates_age'              => $this->request->getPost('inmates_age'),
                'inmates_building'         => $buildingId,
                'inmates_room_type'        => $roomTypeId,
                'inmates_rooms'            => $roomId,
                'inmates_check_in_date'    => date('Y-m-d',strtotime($check_in_date)),
                'inmates_check_out_date'   => date('Y-m-d',strtotime($check_out_date)),
                'inmates_duration_of_stay' => $this->request->getPost('inmates_duration_of_stay'),
                'inmates_phone_no'         => $this->request->getPost('inmates_phone_no'),
                'inmates_email'            => $email,
                'inmates_whats_app_number' => $this->request->getPost('inmates_whats_app_number'),
                'inmates_guardian_name'    => $this->request->getPost('inmates_guardian_name'),
                'inmates_relation'         => $this->request->getPost('inmates_relation'),
                'inmates_guardian_contact' => $this->request->getPost('inmates_guardian_contact'),
                'inmates_id_proof'         => $idProofName,
                'inmates_photo'            => $photoName,
                'inmates_place_of_work'    => $this->request->getPost('place_of_work'),
                'inmates_tariffs'          => $tariffId,
                'inmates_admission_fee'    => $admFee,
                'inmates_caution_deposit'  => $cautDep,
                'inmates_status'           => 'active',
                'inmates_approved_at'      => date('Y-m-d H:i:s'),
                'inmates_created_at'       => date('Y-m-d H:i:s'),
            ]; 

            $id = $this->common_model->InsertData('saiyoojyam_inmates',$data);

            $inmates_id = new_booking_id($id, 'IN');

            $this->common_model->EditData(array('inmates_uid' =>  $inmates_id),array('inmates_id' => $id),'saiyoojyam_inmates');

            if (!empty($email) && $db->tableExists("saiyoojyam_customers")) {
                $cust = $db->table("saiyoojyam_customers")->where("customer_email", $email)->get()->getRow();
                $now = date('Y-m-d H:i:s');
                if ($cust) {
                    $db->table("saiyoojyam_customers")->where("customer_id", $cust->customer_id)->update([
                        "customer_name"  => $this->request->getPost('inmates_name'),
                        "customer_phone" => $this->request->getPost('inmates_phone_no'),
                        "updated_at"     => $now,
                    ]);
                } else {
                    $db->table("saiyoojyam_customers")->insert([
                        "customer_name"  => $this->request->getPost('inmates_name'),
                        "customer_email" => $email,
                        "customer_phone" => $this->request->getPost('inmates_phone_no'),
                        "created_at"     => $now,
                        "updated_at"     => $now,
                    ]);
                }
            }

            $response['status'] = true;
            $response['msg'] = 'Data Added Successfully';

            echo json_encode($response);
            return;
        
        }

        $data['duration'] = $this->common_model->FetchAllOrder('saiyoojyam_duration_of_stay','duration_stay','ASC');

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        return view('admin/add_inmates',$data);
    }


    public function Edit($id = null){

        if(empty($id)){
            return redirect()->to(site_url().'Admin/Inmates');
        }

        $data['inmate'] = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $id));

        if(empty($data['inmate'])){

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Inmate not found',
            );

            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url().'Admin/Inmates');
        }

        if ($this->request->getMethod() === 'POST') {

            // Get the uploaded files
            $idProof = $this->request->getFile('inmates_id_proof');
            $photo = $this->request->getFile('inmates_photo');

            $idProofName = $data['inmate']->inmates_id_proof;
            $photoName = $data['inmate']->inmates_photo;

            // Upload directory
            $uploadPath = WRITEPATH . 'uploads/inmates/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle ID Proof upload
            if ($idProof && $idProof->isValid() && !$idProof->hasMoved()) {
                $idProofName = $idProof->getRandomName();
                $idProof->move($uploadPath, $idProofName);
            }

            // Handle Photo upload
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);
            }

            // Collect other form inputs
            $check_in_date = $this->request->getPost('inmates_check_in_date');

            if(!empty($this->request->getPost('inmates_check_out_date'))){
                $check_out_date = $this->request->getPost('inmates_check_out_date');
            }else{
                $check_out_date = "0000-00-00";
            }

            if($check_out_date != '0000-00-00' && strtotime($check_out_date) <= strtotime($check_in_date)){
                $this->session->setFlashdata('alert', [
                    'type' => 'error',
                    'msg'  => 'Check out date must be after the check in date',
                ]);
                return redirect()->to(site_url('Admin/Inmates/Edit/' . $id));
            }

            $email = trim((string)$this->request->getPost('inmates_email'));
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->session->setFlashdata('alert', [
                    'type' => 'error',
                    'msg'  => 'Please enter a valid email address.',
                ]);
                return redirect()->to(site_url('Admin/Inmates/Edit/' . $id));
            }

            // Check if email belongs to another active or pending resident (in Edit mode)
            $db = \Config\Database::connect();
            $userId = (int) ($data['inmate']->inmates_user_id ?? 0);

            if (!empty($email)) {
                // 1. Check saiyoojyam_inmates for another active or pending resident with this email
                $conflictInmate = $db->table('saiyoojyam_inmates')
                    ->where('inmates_id !=', $id)
                    ->where('LOWER(inmates_email)', strtolower($email))
                    ->whereIn('inmates_status', ['active', 'pending'])
                    ->get()
                    ->getRow();

                if ($conflictInmate) {
                    $flashdata = [
                        'type' => 'error',
                        'msg'  => "The email '{$email}' is already registered to another resident ({$conflictInmate->inmates_name}, UID: {$conflictInmate->inmates_uid}).",
                    ];
                    $this->session->setFlashdata('alert', $flashdata);
                    return redirect()->to(site_url('Admin/Inmates/Edit/' . $id));
                }

                // 2. Check auth_identities to ensure no unique constraint collision
                if ($db->tableExists('auth_identities')) {
                    $existingIdentity = $db->table('auth_identities')
                        ->where('type', 'email_password')
                        ->where('LOWER(secret)', strtolower($email))
                        ->get()
                        ->getRow();

                    if ($existingIdentity && (int)$existingIdentity->user_id !== $userId) {
                        // Check if that user_id is linked to another active or pending resident
                        $otherResident = $db->table('saiyoojyam_inmates')
                            ->where('inmates_id !=', $id)
                            ->where('inmates_user_id', (int)$existingIdentity->user_id)
                            ->whereIn('inmates_status', ['active', 'pending'])
                            ->get()
                            ->getRow();

                        if ($otherResident) {
                            $flashdata = [
                                'type' => 'error',
                                'msg'  => "The email '{$email}' is already registered to another resident ({$otherResident->inmates_name}, UID: {$otherResident->inmates_uid}).",
                            ];
                            $this->session->setFlashdata('alert', $flashdata);
                            return redirect()->to(site_url('Admin/Inmates/Edit/' . $id));
                        } else {
                            // The identity belongs to a deleted or orphaned account - remove it to free the email
                            $db->table('auth_identities')->where('id', (int)$existingIdentity->id)->delete();
                        }
                    }
                }
            }

            $update_data = [

                'inmates_name'             => $this->request->getPost('inmates_name'),
                'inmates_age'              => $this->request->getPost('inmates_age'),
                'inmates_building'         => $this->request->getPost('inmates_building'),
                'inmates_room_type'        => $this->request->getPost('inmates_room_type'),
                'inmates_rooms'            => $this->request->getPost('inmates_rooms'),
                'inmates_check_in_date'    => date('Y-m-d',strtotime($check_in_date)),
                'inmates_check_out_date'   => date('Y-m-d',strtotime($check_out_date)),
                'inmates_duration_of_stay' => $this->request->getPost('inmates_duration_of_stay'),
                'inmates_phone_no'         => $this->request->getPost('inmates_phone_no'),
                'inmates_email'            => $email,
                'inmates_whats_app_number' => $this->request->getPost('inmates_whats_app_number'),
                'inmates_guardian_name'    => $this->request->getPost('inmates_guardian_name'),
                'inmates_relation'         => $this->request->getPost('inmates_relation'),
                'inmates_guardian_contact' => $this->request->getPost('inmates_guardian_contact'),
                'inmates_id_proof'         => $idProofName,
                'inmates_photo'            => $photoName,
                'inmates_place_of_work'    => $this->request->getPost('place_of_work'),
            ];

            $old_room = $data['inmate']->inmates_rooms;

            $new_room = $this->request->getPost('inmates_rooms');
            $new_building = $this->request->getPost('inmates_building');
            $new_room_type = $this->request->getPost('inmates_room_type');

            if($old_room != $new_room){

                $old_room_row = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $old_room));

                $new_room_row = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $new_room));

                $old_tariff = $this->findTariffForRoom($old_room, !empty($old_room_row) ? $old_room_row->rooms_building : $data['inmate']->inmates_building, !empty($old_room_row) ? $old_room_row->rooms_type : $data['inmate']->inmates_room_type);

                $new_tariff = $this->findTariffForRoom($new_room, !empty($new_room_row) ? $new_room_row->rooms_building : $new_building, !empty($new_room_row) ? $new_room_row->rooms_type : $new_room_type);

                $room_history_data = array(
                    'room_history_inmates_id'      => $id,
                    'room_history_old_room'        => $old_room,
                    'room_history_new_room'        => $new_room,
                    'room_history_old_tariff_price'=> !empty($old_tariff) ? (float)$old_tariff->tariffs_price : 0,
                    'room_history_new_tariff_price'=> !empty($new_tariff) ? (float)$new_tariff->tariffs_price : 0,
                    'room_history_effective_month' => date('Y-m'),
                    'room_history_effective_date'  => date('Y-m-d'),
                    'room_history_created_at'      => date('Y-m-d H:i:s'),
                );

                $this->common_model->InsertData('saiyoojyam_inmate_room_history',$room_history_data);

                if(!empty($new_tariff)){
                    $update_data['inmates_tariffs'] = (int) $new_tariff->tariffs_id;
                }
            } else {
                $cur_tariff = $this->findTariffForRoom($new_room, $new_building, $new_room_type);
                if(!empty($cur_tariff)){
                    $update_data['inmates_tariffs'] = (int) $cur_tariff->tariffs_id;
                }
            }

            $oldCheckout = $data['inmate']->inmates_check_out_date ?? null;
            $newCheckout = $update_data['inmates_check_out_date'] ?? null;

            $this->common_model->EditData($update_data,array('inmates_id' => $id),'saiyoojyam_inmates');

            if (!empty($newCheckout) && $newCheckout !== $oldCheckout) {
                $this->syncCheckoutExtensionRent($id, $oldCheckout, $newCheckout);
            }

            // Sync updated email & name to resident login credentials (auth_identities & saiyoojyam_users)
            $userId = (int) ($data['inmate']->inmates_user_id ?? 0);
            if ($userId <= 0 && !empty($data['inmate']->inmates_email)) {
                $identRow = $db->table('auth_identities')
                    ->where('type', 'email_password')
                    ->where('LOWER(secret)', strtolower($data['inmate']->inmates_email))
                    ->get()
                    ->getRow();
                if ($identRow) {
                    $userId = (int) $identRow->user_id;
                    $db->table('saiyoojyam_inmates')->where('inmates_id', $id)->update(['inmates_user_id' => $userId]);
                }
            }

            if ($userId > 0 && !empty($email)) {
                $now = date('Y-m-d H:i:s');
                try {
                    $currentIdentity = $db->table('auth_identities')
                        ->where('user_id', $userId)
                        ->where('type', 'email_password')
                        ->get()
                        ->getRow();

                    if ($currentIdentity) {
                        // Update existing identity
                        $db->table('auth_identities')
                            ->where('id', (int) $currentIdentity->id)
                            ->update([
                                'secret'     => $email,
                                'updated_at' => $now,
                            ]);
                    } else {
                        // Insert if missing
                        $cleanUser = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->request->getPost('inmates_name') ?: 'inmate'));
                        $db->table('auth_identities')->insert([
                            'user_id'     => $userId,
                            'type'        => 'email_password',
                            'name'        => '',
                            'secret'      => $email,
                            'secret2'     => password_hash('Saiy' . rand(100, 999) . '@' . date('y'), PASSWORD_DEFAULT),
                            'force_reset' => 0,
                            'created_at'  => $now,
                            'updated_at'  => $now,
                        ]);
                    }

                    // Update saiyoojyam_users table if present
                    if ($db->tableExists('saiyoojyam_users')) {
                        $db->table('saiyoojyam_users')
                            ->where('users_id', $userId)
                            ->update([
                                'users_email' => $email,
                                'users_name'  => $this->request->getPost('inmates_name'),
                            ]);
                    }
                } catch (\Throwable $e) {
                    log_message('error', 'Failed updating auth_identities on inmate edit: ' . $e->getMessage());
                }
            }

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );

            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Inmates/Edit/'.$id));

        }

        $data['duration'] = $this->common_model->FetchAllOrder('saiyoojyam_duration_of_stay','duration_stay','ASC');

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        $db = \Config\Database::connect();
        $tariffRows = $db->table('saiyoojyam_tariffs')->get()->getResult();
        $tariffRoomIdList = [];
        $tariffRoomTypeList = [];
        foreach ($tariffRows as $tr) {
            if (!empty($tr->tariffs_rooms)) {
                $tariffRoomIdList[] = (int) $tr->tariffs_rooms;
            }
            if (!empty($tr->tariffs_room_types)) {
                $tariffRoomTypeList[(int) $tr->tariffs_building][] = (int) $tr->tariffs_room_types;
            }
        }

        $allRooms = $this->common_model->FetchWhereOrderby('saiyoojyam_rooms',array('rooms_building' => $data['inmate']->inmates_building),'rooms_name','ASC');
        $filteredRooms = [];
        $bId = (int)$data['inmate']->inmates_building;
        $allowedTypes = $tariffRoomTypeList[$bId] ?? [];
        foreach($allRooms as $r){
            if(in_array((int)$r->rooms_type, $allowedTypes, true) || in_array((int)$r->rooms_id, $tariffRoomIdList, true) || (int)$r->rooms_id === (int)($data['inmate']->inmates_rooms ?? 0)){
                $filteredRooms[] = $r;
            }
        }
        $data['rooms'] = $filteredRooms;

        $data['room_history'] = $this->common_model->FetchWhereOrderby('saiyoojyam_inmate_room_history',array('room_history_inmates_id' => $id),'room_history_id','DESC');

        if(!empty($data['room_history'])){

            $room_names = array();

            $all_rooms = $this->common_model->FetchAll('saiyoojyam_rooms');

            foreach($all_rooms as $r){

                $room_names[$r->rooms_id] = $r->rooms_name;
            }

            foreach($data['room_history'] as $rh){

                $rh->old_room_name = isset($room_names[$rh->room_history_old_room]) ? $room_names[$rh->room_history_old_room] : '-';

                $rh->new_room_name = isset($room_names[$rh->room_history_new_room]) ? $room_names[$rh->room_history_new_room] : '-';
            }
        }

        return view('admin/edit_inmates',$data);
    }
    


    public function Image($id, $type){

        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $id));

        if(empty($inmate)){
            return redirect()->to(site_url().'Admin/Inmates');
        }

        if($type == 'proof'){
            $file = $inmate->inmates_id_proof;
        }else{
            $file = $inmate->inmates_photo;
        }

        $filePath = WRITEPATH . 'uploads/inmates/' . $file;

        if(!empty($file) && is_file($filePath)){

            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            $mime = 'application/octet-stream';

            if(in_array($ext, array('jpg','jpeg'))){
                $mime = 'image/jpeg';
            }
            elseif($ext == 'png'){
                $mime = 'image/png';
            }
            elseif($ext == 'gif'){
                $mime = 'image/gif';
            }
            elseif($ext == 'webp'){
                $mime = 'image/webp';
            }

            header('Content-Type: '.$mime);

            readfile($filePath);

            exit;
        }

        return redirect()->to(site_url().'Admin/Inmates');
    }


    public function Receipt($id = null){
        if(empty($id)){
            return redirect()->to(site_url().'Admin/Inmates');
        }
        
        $data['total_rent_month'] = 0;
$joins = array(
            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'inmates_building',
            ),
            array(
                'table' => 'saiyoojyam_rooms',
                'pk'    => 'rooms_id',
                'fk'    => 'inmates_rooms',
            ),
            
            

        );
       
        $data['inmates'] = $this->common_model->SingleRowJoin('saiyoojyam_inmates',array('inmates_id' => $id),$joins);

        $data['tariffs'] = $this->findTariffForRoom($data['inmates']->inmates_rooms, $data['inmates']->inmates_building, $data['inmates']->inmates_room_type ?? null);
        if (empty($data['tariffs']) && !empty($data['inmates']->inmates_tariffs)) {
            $data['tariffs'] = $this->common_model->SingleRow('saiyoojyam_tariffs', array('tariffs_id' => $data['inmates']->inmates_tariffs));
        }
        
        if(empty($data['tariffs'])){

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Please Add Tariffs',
            );

            $this->session->setFlashdata('alert',$flashdata);


            return redirect()->to(site_url().'Admin/Inmates');


        }

        // Synchronize invoice rent & balance with inmate's checkout date
        $this->syncInmateCurrentInvoiceWithCheckout($id);

        $data['invoices'] = $this->common_model->FetchWhereOrderby('saiyoojyam_invoice',['invoice_inmates' => $id],'invoice_payment_month','DESC');

        $data['rent_per_month'] = $data['tariffs']->tariffs_price;
        
        //Check if there is any balance remaining from the previous amount
        $data['last_paid_invoice'] = $this->common_model->FetchLastInvoice('saiyoojyam_invoice',array('invoice_inmates' => $id));

        
        //check payment is uptodate
        $check_date = date('Y-m-01');
        
        $data['last_paid_amount'] = $this->common_model->last_payment_month('saiyoojyam_invoice',$id);
        
        //check out date
        $data['inmates_check_out'] = $data['inmates']->inmates_check_out_date;


        //invoice count
        $invoice_count = $this->common_model->checkWhereCount('saiyoojyam_invoice',array('invoice_inmates' => $id));

        

        if(empty($data['invoices'])){

            if(!empty($data['tariffs']->tariffs_price)){

                $check_in_date = $data['inmates']->inmates_check_in_date;

                $join_y = date('Y', strtotime($check_in_date));

                $join_m = date('m', strtotime($check_in_date));

                $join_day = (int) date('j', strtotime($check_in_date));

                $join_month_days = cal_days_in_month(CAL_GREGORIAN, $join_m, $join_y);

                // 1. If the person comes on or before 5th: full month rent
                if($join_day <= 5){

                    $data['payment_month'] = date('Y-m-01', strtotime($check_in_date));

                    $effective_tariff = $this->getEffectiveTariff($id, $data['payment_month']);

                    $data['rent_per_month'] = !empty($effective_tariff) ? $this->getApplicableRent($effective_tariff->tariffs_id,$data['payment_month'],$effective_tariff->tariffs_price) : $data['tariffs']->tariffs_price;

                    $monthly_rent = $this->getSplitMonthRent($id, $data['payment_month'], $data['rent_per_month']);

                    $data['rent_per_month'] = $monthly_rent;

                // 2. Until 20th of a month: collect rent from the joining date till end of the month
                // Rent/day = (monthly rent) / (No. of days in the month)
                }elseif($join_day <= 20){

                    $data['payment_month'] = date('Y-m-01', strtotime($check_in_date));

                    $effective_tariff = $this->getEffectiveTariff($id, $data['payment_month']);

                    $data['rent_per_month'] = !empty($effective_tariff) ? $this->getApplicableRent($effective_tariff->tariffs_id,$data['payment_month'],$effective_tariff->tariffs_price) : $data['tariffs']->tariffs_price;

                    $monthly_rent = $this->getSplitMonthRent($id, $data['payment_month'], $data['rent_per_month']);

                    $data['rent_per_month'] = $monthly_rent;

                    $stay_days = $join_month_days - $join_day + 1;

                    $per_day   = $monthly_rent / $join_month_days;

                    $monthly_rent = round($stay_days * $per_day, 2);

                // 3. From 21st: Rent = Rent for the days left in current month + next month rent
                }else{

                    $data['payment_month'] = date('Y-m-01', strtotime('first day of next month', strtotime($check_in_date)));

                    $effective_tariff = $this->getEffectiveTariff($id, $data['payment_month']);

                    $data['rent_per_month'] = !empty($effective_tariff) ? $this->getApplicableRent($effective_tariff->tariffs_id,$data['payment_month'],$effective_tariff->tariffs_price) : $data['tariffs']->tariffs_price;

                    $monthly_rent = $this->getSplitMonthRent($id, $data['payment_month'], $data['rent_per_month']);

                    $data['rent_per_month'] = $monthly_rent;

                    // add the join month stay days rent into the next month invoice
                    $join_effective_tariff = $this->getEffectiveTariff($id, $check_in_date);

                    $join_rent = !empty($join_effective_tariff) ? $this->getApplicableRent($join_effective_tariff->tariffs_id,$check_in_date,$join_effective_tariff->tariffs_price) : $data['tariffs']->tariffs_price;

                    $stay_days = $join_month_days - $join_day + 1;

                    $per_day   = $join_rent / $join_month_days;

                    $monthly_rent = $monthly_rent + round($stay_days * $per_day, 2);

                }

                if (!empty($data['inmates_check_out']) && $data['inmates_check_out'] != '0000-00-00') {
                    $monthly_rent = $this->getVacatingRent($data['rent_per_month'], $data['payment_month'], $data['inmates_check_out'], $check_in_date);
                }

                $data['rent_per_month'] = $monthly_rent;

                $total_rent_month  = $monthly_rent + $data['tariffs']->tariffs_caution_deposit + $data['tariffs']->tariffs_admission_fees;

                $data['total_rent_month'] = number_format($total_rent_month, 2, '.', ',');

            }

        }else{
           

            if(!empty($data['last_paid_amount']) && $data['last_paid_amount'] < $check_date){

                $date = new \DateTime($data['last_paid_amount']);

                $final = $date->modify('+1 month');

                $data['payment_month'] = $final->format('Y-m-1');

                $effective_tariff = $this->getEffectiveTariff($id, $data['payment_month']);

                $data['rent_per_month'] = !empty($effective_tariff) ? $this->getApplicableRent($effective_tariff->tariffs_id,$data['payment_month'],$effective_tariff->tariffs_price) : $data['tariffs']->tariffs_price;

               

                $year = date('Y', strtotime($data['payment_month']));

                $month = date('m', strtotime($data['payment_month']));

                $days_in_a_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);

                //$monthly_rent = $data['tariffs']->tariffs_price * $days_in_a_month;
                
                $monthly_rent = $this->getSplitMonthRent($id, $data['payment_month'], $data['rent_per_month']);

                $data['rent_per_month'] = $monthly_rent;

                $monthly_rent = $this->getVacatingRent($monthly_rent, $data['payment_month'], $data['inmates_check_out'], $data['inmates']->inmates_check_in_date);

                $data['rent_per_month'] = $monthly_rent;

                $invoice_single = $this->common_model->FetchLastInvoice('saiyoojyam_invoice',array('invoice_inmates' => $id));

                if($invoice_single->invoice_status == 3){
 
                    $monthly_rent = $monthly_rent - $invoice_single->invoice_advance;

                }

                if($invoice_single->invoice_status == 2){
                    
                    //$balace_amount = $invoice_single->invoice_total - $invoice_single->invoice_paid_amount;

                    $balace_amount  = $invoice_single->invoice_balance;

                    $monthly_rent = $monthly_rent + $balace_amount;
                }

                $monthly_rent = round($monthly_rent);
              
                $data['total_rent_month'] = number_format($monthly_rent, 2, '.', ',');

            }


        }

        //room effective for the displayed payment month
        $payment_month_for_room = !empty($data['payment_month']) ? $data['payment_month'] : date('Y-m-01');

        $effective_room_id = $this->getEffectiveRoomId($id, $payment_month_for_room);

        $effective_room = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_id' => $effective_room_id));

        if (!empty($effective_room)) {
            $data['effective_room_name'] = $effective_room->rooms_name;
            $effective_building = $this->common_model->SingleRow('saiyoojyam_building', array('building_id' => $effective_room->rooms_building));
            $data['effective_building_name'] = !empty($effective_building) ? $effective_building->building_name : $data['inmates']->building_name;
        } else {
            $data['effective_room_name'] = $data['inmates']->rooms_name;
            $data['effective_building_name'] = $data['inmates']->building_name;
        }

        return view('admin/view_receipt',$data);
    }


    public function AddReceipt(){

        if ($this->request->getMethod() === 'POST') {

            $current_date = date('Y-m-d');

            $single_invoice = $this->common_model->SingleRow('saiyoojyam_invoice',array('invoice_inmates' => $this->request->getPost('inmates_id')));

            $inmates = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $this->request->getPost('inmates_id')));

            // check first payment or not
            if(empty($single_invoice)){
                
                $join_day = (int) date('j', strtotime($inmates->inmates_check_in_date));

                // From 21st, payment month is next month
                if($join_day >= 21){

                    $payment_month = date('Y-m-01', strtotime('first day of next month', strtotime($inmates->inmates_check_in_date)));

                }else{

                    $payment_month = date('Y-m-01', strtotime($inmates->inmates_check_in_date));
                }

                //update caution deposit and admission fee 

                $caution_check = $this->request->getPost('caution_check');

                $admission_check = $this->request->getPost('admission_check');

                if($caution_check == 1){
                 
                    $caution_deposit = $this->request->getPost('caution_deposit');

                }
                else{

                    $caution_deposit = "";
                }
          
                if($admission_check == 2){

                    $admission_fees = $this->request->getPost('admission_fees');
                }
                else{

                    $admission_fees = "";
                }

                $update = [

                    'inmates_caution_deposit' => $caution_deposit,
                    'inmates_admission_fee'   => $admission_fees,

                ];

            
                $this->common_model->EditData($update,array('inmates_id' => $this->request->getPost('inmates_id')),'saiyoojyam_inmates');


            }else{
              

                $last_paid_amount = $this->common_model->last_payment_month('saiyoojyam_invoice',$this->request->getPost('inmates_id'));
                $check_date = date('Y-m-01');

                if (!empty($last_paid_amount) && $last_paid_amount < $check_date) {

                    $date = new \DateTime($last_paid_amount); 
                    $final = $date->modify('+1 month');
                    $payment_month = $final->format('Y-m-1');
 
                } else {
                    $payment_month = !empty($last_paid_amount) ? $last_paid_amount : date('Y-m-01');
                } 
               
              
            }

            
            //add invoice

            $advance_amount = "";

            $balance_amount ="";

            $current_amount ="";

            $prv_status    = "";

            $balance_amt ="";

            $invoice_balance_amt = "";

            $invoice_paid_amt = "";
           

            $total_amount = str_replace(',','',$this->request->getPost('total_amount'));
            
            if(!empty($this->request->getPost('paid_amount'))){
               
                $paid_amount = str_replace(',','',$this->request->getPost('paid_amount'));


                if($paid_amount < $total_amount){
                 
                    $status = 2;

                    $balance_amount = $total_amount - $paid_amount ;

                }

                elseif($paid_amount > $total_amount){

                    $status = 3;

                    $advance_amount = $paid_amount - $total_amount;

                }else{

                    $status =  1;
                }
               


            }else{

               $paid_amount = $total_amount;

               $status =  1;

            }

            //Check if there is any balance remaining from the previous amount
            
            $last_paid_invoice = $this->common_model->FetchLastInvoice('saiyoojyam_invoice',array('invoice_inmates' => $this->request->getPost('inmates_id')));

            if(!empty($last_paid_invoice)){

                
            
                if($last_paid_invoice->invoice_status == 2){


                    if($paid_amount > $last_paid_invoice->invoice_balance){

                        $balance_amt    = $paid_amount - $last_paid_invoice->invoice_balance;

                        $total_amount   = $total_amount - $last_paid_invoice->invoice_balance;

                        $paid_amount    = $balance_amt;

                        $prv_status     = 1;
                         
                        $current_amount = $last_paid_invoice->invoice_balance;

                        $invoice_balance_amt = 0.00;

                        $invoice_paid_amt = $last_paid_invoice->invoice_total;

                    }

                    elseif($paid_amount < $last_paid_invoice->invoice_balance){
                         
                        $balance_amt  = $last_paid_invoice->invoice_balance - $paid_amount;

                        $current_amount = $paid_amount;

                        $paid_amount = 0;

                        $prv_status   = 2;

                        $invoice_balance_amt = $balance_amt;

                        $invoice_paid_amt = $last_paid_invoice->invoice_paid_amount + $current_amount;
                    }
                    
                    else{
                        
                        if($paid_amount == $last_paid_invoice->invoice_balance){

                            $current_amount = $paid_amount;

                            $paid_amount = 0;

                            $prv_status   = 1;

                            $invoice_balance_amt = 0.00;

                            $invoice_paid_amt = $last_paid_invoice->invoice_total;

                        }
                       
                    }

                    if($paid_amount < $total_amount){
                 
                        $status = 2;

                        
                    }

                    elseif($paid_amount > $total_amount){

                        $status = 3;


                    }
	
                    else{

                        $status =  1;
                    }
                    

                    $prv_history_data = [

                        'history_invoice_id'  => $last_paid_invoice->invoice_id,

                        'history_paid_date'   => date('Y-m-d'),

                        'history_paid_amount' => $current_amount,
                    ];

                    $this->common_model->InsertData('saiyoojyam_invoice_history',$prv_history_data);

                    $prv_data = [

                        'invoice_status'       => $prv_status,

                        'invoice_balance'      => $invoice_balance_amt,

                        'invoice_paid_amount'  => $invoice_paid_amt,
    
                    ];


                    $this->common_model->EditData($prv_data,array('invoice_id' => $last_paid_invoice->invoice_id),'saiyoojyam_invoice');

                }

            }

            if($paid_amount !=0){

                //insert data
                $data = [
                    
                    'invoice_rent'          => str_replace(',','',$this->request->getPost('one_month_amount')),
                    'invoice_total'         => $total_amount,
                    'invoice_paid_amount'   => $paid_amount,
                    'invoice_balance'       => $balance_amount,
                    'invoice_advance'       => $advance_amount,
                    'invoice_inmates'       => $this->request->getPost('inmates_id'),
                    'invoice_paid_date'     => $current_date,
                    'invoice_payment_month' => $payment_month,
                    'invoice_status'        => $status,
                
                ]; 

                $id = $this->common_model->InsertData('saiyoojyam_invoice',$data);

                //partially paid  cond

                $invoice_data = $this->common_model->SingleRow('saiyoojyam_invoice',array('invoice_id' => $id));

                if($invoice_data->invoice_status == 2){

                    $history_data = [
                    
                        'history_paid_amount'   => $paid_amount,
                    
                        'history_paid_date'     => $current_date,
                        
                        'history_invoice_id'    => $invoice_data->invoice_id,
                
                    ]; 

                    $id = $this->common_model->InsertData('saiyoojyam_invoice_history',$history_data);

                }

            }



            //check payment is up to date
            $last_paid_amount1 = $this->common_model->last_payment_month('saiyoojyam_invoice',$this->request->getPost('inmates_id'));
            $response['last_month_balance'] = "";
            if(!empty($last_paid_amount1)){

                $check_date = date('Y-m-01');
               
                if($last_paid_amount1 >= $check_date){

                    $response['payment'] = 1;
                     
                    $response['payment_month1'] = "";

                    $response['rent_per_day'] = "";

                    $response['monthly rent'] = "";

                }
                else{

                    $is_checkout_paid = false;
                    if (!empty($inmates->inmates_check_out_date) && $inmates->inmates_check_out_date != '0000-00-00') {
                        $oldDate = $inmates->inmates_check_out_date;
                        $date = new DateTime($oldDate);
                        $date->setDate($date->format('Y'), $date->format('m'), 01);
                        $newCheckDate = $date->format('Y-m-d');

                        if ($last_paid_amount1 >= $newCheckDate) {
                            $is_checkout_paid = true;
                        }
                    }

                    if($is_checkout_paid){

                        $response['payment'] = 1;
                     
                        $response['payment_month1'] = "";

                        $response['rent_per_day'] = "";

                        $response['monthly rent'] = "";


                    }else{

                        $response['payment'] = 0;

                        $date1 = new \DateTime($last_paid_amount1); 
                        $final1 = $date1->modify('+1 month');
                        $payment_month1 = $final1->format('Y-m-1');

                        $year = date('Y', strtotime($payment_month1));
                        $month = date('m', strtotime($payment_month1));
                        $days_in_a_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);

                        
                        $effective_tariff = $this->getEffectiveTariff($this->request->getPost('inmates_id'), $payment_month1);

                        if(empty($effective_tariff)){

                            $effective_tariff = $this->findTariffForRoom($inmates->inmates_rooms, $inmates->inmates_building, $inmates->inmates_room_type ?? null);
                        }
    
                        $response['payment_month1'] = date('M-Y',strtotime($payment_month1));

                        // Calculate effective room and building for the new payment month
                        $effective_room_id = $this->getEffectiveRoomId($this->request->getPost('inmates_id'), $payment_month1);
                        $effective_room = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_id' => $effective_room_id));

                        if (!empty($effective_room)) {
                            $response['effective_room_name'] = $effective_room->rooms_name;
                            $effective_building = $this->common_model->SingleRow('saiyoojyam_building', array('building_id' => $effective_room->rooms_building));
                            $response['effective_building_name'] = !empty($effective_building) ? $effective_building->building_name : '';
                        } else {
                            $orig_room = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_id' => $inmates->inmates_rooms));
                            $orig_building = $this->common_model->SingleRow('saiyoojyam_building', array('building_id' => $inmates->inmates_building));
                            $response['effective_room_name'] = !empty($orig_room) ? $orig_room->rooms_name : '';
                            $response['effective_building_name'] = !empty($orig_building) ? $orig_building->building_name : '';
                        }

                        $rent_per_day = !empty($effective_tariff) ? $this->getApplicableRent($effective_tariff->tariffs_id,$payment_month1,$effective_tariff->tariffs_price) : 0;

                        //$monthly_rent = $inmates->tariffs_price * $days_in_a_month;

                        $monthly_rent = $this->getSplitMonthRent($this->request->getPost('inmates_id'), $payment_month1, $rent_per_day);

                        $response['rent_per_day'] = $monthly_rent;

                        $monthly_rent = $this->getVacatingRent($monthly_rent, $payment_month1, $inmates->inmates_check_out_date, $inmates->inmates_check_in_date);
                        $response['rent_per_day'] = $monthly_rent;

                        $invoice_last = $this->common_model->FetchLastInvoice('saiyoojyam_invoice',array('invoice_inmates' =>  $this->request->getPost('inmates_id')));

                        if(!empty($invoice_last)){

                            if($invoice_last->invoice_status == 3){
            
                                $monthly_rent = $monthly_rent - $invoice_last->invoice_advance;

                            }

                            if($invoice_last->invoice_status == 2){
                                
                                
                                $balace_amount  = $invoice_last->invoice_balance;

                                $monthly_rent = $monthly_rent + $balace_amount;

                                $response['last_month_balance'] = $balace_amount;
                                  

                            }

                        }

                        $monthly_rent = round($monthly_rent);
                      
                        $response['monthly_rent'] = number_format($monthly_rent, 2, '.', ',');

                        

                    }


                }

            }
            
            
            //payment details fetch
            $invoices = $this->common_model->FetchWhereOrderby('saiyoojyam_invoice',['invoice_inmates' => $this->request->getPost('inmates_id')],'invoice_payment_month','DESC');

            $response['payment_data'] = "";

            $ciDay = !empty($inmates->inmates_check_in_date) ? (int)date('j', strtotime($inmates->inmates_check_in_date)) : 0;
            $ciMonthDate = !empty($inmates->inmates_check_in_date) ? date('Y-m-01', strtotime($inmates->inmates_check_in_date)) : '';
            $nextMonthDate = !empty($inmates->inmates_check_in_date) ? date('Y-m-01', strtotime('first day of next month', strtotime($inmates->inmates_check_in_date))) : '';

            foreach($invoices as $invoice){

                $tablePayMonthDisplay = date('M-Y', strtotime($invoice->invoice_payment_month));
                if ($ciDay >= 21 && $invoice->invoice_payment_month == $nextMonthDate) {
                    $tablePayMonthDisplay = date('M-Y', strtotime($ciMonthDate)) . ' & ' . date('M-Y', strtotime($invoice->invoice_payment_month));
                }

                $printUrl = base_url('Admin/Inmates/Print/' . $inmates->inmates_id . '?invoice_id=' . $invoice->invoice_id);

                $response['payment_data'] .= "<tr>
                        <td data-order='".$invoice->invoice_payment_month."'>".$tablePayMonthDisplay."</td>
                        <td>".$invoice->invoice_paid_date."</td>
                        <td>".$invoice->invoice_total."</td>
                        <td>".$invoice->invoice_paid_amount."</td>";
                        

                        if($invoice->invoice_status == 1){ 

                          $response['payment_data'] .= "<td><span class='btn btn-success'>Fully Paid</span></td>";

                        } elseif($invoice->invoice_status == 2){ 

                          $response['payment_data'] .= "<td><span class='btn btn-warning partiall_paid_clz' data-id=".$invoice->invoice_id." data-total=".$invoice->invoice_total." data-paid=".$invoice->invoice_paid_amount.">Partially Paid</span></td>";

                         
                        } elseif($invoice->invoice_status == 3){

                          $response['payment_data'] .= "<td><span class='btn btn-info'>Advance Paid</span></td>";

                        } 

                        $response['payment_data'] .="<td><span class='btn history_btn history_clz' data-history=".$invoice->invoice_id.">History</span></td>";

                        $response['payment_data'] .="<td>
                          <a href='".$printUrl."' target='_blank' class='btn btn-sm btn-icon btn-outline-secondary p-1' title='Print Invoice'>
                            <i class='icon-base bx bx-printer' style='font-size:17px;'></i>
                          </a>
                        </td>";
                      
                $response['payment_data'] .= "</tr>";
            }

           
            $response['status'] = true;
            $response['msg'] = 'Status Updated';

            echo json_encode($response);
            return;


        }


    }

    public function RentalDetails(){

        $data['month'] = $this->common_model->FetchAllOrder('saiyoojyam_month','month_id','ASC');

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC'); 

        $year = date('Y'); 

        $date_start = "$year-01-01";

        $date_end   = "$year-12-31";

        $data['inmates'] = $this->common_model->inmatesMonthRent($date_start,$date_end);

        return view('admin/imates_rent_details',$data);
    }

    public function History(){

        if($this->request->getMethod() === 'POST') {

            $current_date = date('Y-m-d');

            $data = [
                
                'history_paid_amount'      => str_replace(',','',$this->request->getPost('paid_amount')),

                'history_invoice_id'       => $this->request->getPost('invoice_id'),

                'history_paid_date'        => $current_date,
            
            ]; 

            $id = $this->common_model->InsertData('saiyoojyam_invoice_history',$data);

            $invoice_data = $this->common_model->SingleRow('saiyoojyam_invoice',array('invoice_id' => $this->request->getPost('invoice_id')));


            $paid_amount = $invoice_data->invoice_paid_amount + str_replace(',','',$this->request->getPost('paid_amount'));


            if($this->request->getPost('paid_amount') > $invoice_data->invoice_balance){

                $balance_amount = "0.00";
            }
            elseif($this->request->getPost('paid_amount') < $invoice_data->invoice_balance){

                $balance_amount =  $invoice_data->invoice_balance - $this->request->getPost('paid_amount');

            }
            else{

                $balance_amount = "0.00";
            }



            $invoice_update = [
                
                'invoice_paid_amount'   => $paid_amount,

                'invoice_balance'       => $balance_amount

            ];

            $this->common_model->EditData($invoice_update,array('invoice_id' => $this->request->getPost('invoice_id')),'saiyoojyam_invoice');

            $invoice_data1 = $this->common_model->SingleRow('saiyoojyam_invoice',array('invoice_id' => $this->request->getPost('invoice_id')));
           

            if((int)$invoice_data1->invoice_total === (int)$invoice_data1->invoice_paid_amount){
               

                $status_update = [
                
                    'invoice_status'  => 1

                ];

                $this->common_model->EditData($status_update,array('invoice_id' => $this->request->getPost('invoice_id')),'saiyoojyam_invoice');

            } 


            if((int)$invoice_data1->invoice_total < (int)$invoice_data1->invoice_paid_amount){


                $status_update = [
                
                    'invoice_status'  => 3

                ];

                $this->common_model->EditData($status_update,array('invoice_id' => $this->request->getPost('invoice_id')),'saiyoojyam_invoice');

            }

            
            


            $flashdata = array(

                    'type' => 'success',
                    'msg'  => 'Data Updated Successfully',
                );
        
            $this->session->setFlashdata('alert',$flashdata);



        }

        return redirect()->to(site_url('Admin/Inmates/Receipt/'.$invoice_data->invoice_inmates));

    }


    public function viewHistory(){
           
        $invoice_id = $this->request->getPost('ID');

        $invoice_history = $this->common_model->FetchWhere('saiyoojyam_invoice_history',array('history_invoice_id' => $invoice_id));


        if(!empty($invoice_history)){

            $response['history_html'] = "";

            foreach($invoice_history as $inv_hist){

            $response['history_html'] .= "<tr>
                                            <td>".date('d-m-Y',strtotime($inv_hist->history_paid_date))."</td>
                                            <td>".$inv_hist->history_paid_amount."</td>
                                        </tr>";
            }


            $response['status'] = true;

        }else{
          
            $response['status'] = false;

        }

        echo json_encode($response);

        return;

    }


    public function Print($id = null)
    {
        if (empty($id)) {
            $id = $this->request->getGet('id') ?? $this->request->getGet('inmates_id');
        }

        $invoiceId = $this->request->getGet('invoice_id');

        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        $db = \Config\Database::connect();
        $inmate = null;
        $invRow = null;

        // If an explicit invoice_id query param was passed, load that invoice first
        if (!empty($invoiceId)) {
            $invRow = $db->table('saiyoojyam_invoice')->where('invoice_id', (int) $invoiceId)->get()->getRow();
            if ($invRow && empty($id)) {
                $id = $invRow->invoice_inmates;
            }
        }

        // Try to load inmate
        if (!empty($id)) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', (int) $id)->get()->getRow();
        }

        // If inmate not found by ID, maybe $id passed was an invoice_id
        if (!$inmate && !empty($id)) {
            $maybeInv = $db->table('saiyoojyam_invoice')->where('invoice_id', (int) $id)->get()->getRow();
            if ($maybeInv) {
                $invRow = $maybeInv;
                $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', (int) $invRow->invoice_inmates)->get()->getRow();
            }
        }

        // If invoice not yet loaded and inmate is found, fetch matching or latest invoice
        if (!$invRow && $inmate) {
            $invRow = $db->table('saiyoojyam_invoice')
                ->where('invoice_inmates', (string) $inmate->inmates_id)
                ->orderBy('invoice_id', 'DESC')
                ->get()->getRow();
        }

        $guestName = $inmate ? $inmate->inmates_name : 'Guest';
        $guestPhone = $inmate ? $inmate->inmates_phone_no : '';
        $joinDate = $inmate ? $inmate->inmates_check_in_date : date('Y-m-d');
        $inmateUid = $inmate ? $inmate->inmates_uid : '';
        $building = 'Saiyoojyam Ladies Hostel';
        $room = 'Room';
        $buildingHeaderName = 'Saiyoojyam Ladies Hostel';
        $buildingAddressHtml = 'Prathibha Layout, Second Cross Road,<br>Block Panchayath Office Road, Kusumagiri P.O, Kakkanad, Kochi';
        $buildingContact = '';

        if ($inmate) {
            $bRow = $db->table('saiyoojyam_building')->where('building_id', (int) $inmate->inmates_building)->get()->getRow();
            if ($bRow) {
                $building = $bRow->building_name;
                $buildingHeaderName = !empty($bRow->building_name) ? $bRow->building_name : 'Saiyoojyam Ladies Hostel';
                if (!empty($bRow->building_address)) {
                    $buildingAddressHtml = nl2br(htmlspecialchars($bRow->building_address));
                }
                if (!empty($bRow->building_whatsapp)) {
                    $buildingContact = $bRow->building_whatsapp;
                }
            }
            $rRow = $db->table('saiyoojyam_rooms')->where('rooms_id', (int) $inmate->inmates_rooms)->get()->getRow();
            if ($rRow) {
                $room = 'Room ' . $rRow->rooms_name;
            }
        }

        $paymentMonth = date('Y-m-01');
        $invoiceTotal = 0.0;
        $paidAmount = 0.0;
        $balanceAmount = 0.0;
        $advanceAmount = 0.0;
        $status = 1;
        $invoiceNo = $invRow ? $invRow->invoice_id : '';
        $invoicePaidDate = $invRow ? $invRow->invoice_paid_date : date('Y-m-d');

        $cautionDeposit = $inmate ? (float) $inmate->inmates_caution_deposit : 0.0;
        $admissionFees = $inmate ? (float) $inmate->inmates_admission_fee : 0.0;

        if ($invRow) {
            $paymentMonth   = $invRow->invoice_payment_month;
            $invoiceTotal   = (float) $invRow->invoice_total;
            $paidAmount     = (float) $invRow->invoice_paid_amount;
            $balanceAmount  = (float) $invRow->invoice_balance;
            $advanceAmount  = (float) $invRow->invoice_advance;
            $status         = (int) $invRow->invoice_status;
        } else {
            // Fallback if no invoice exists yet (e.g. preview)
            $tRow = ($inmate && !empty($inmate->inmates_tariffs)) ? $db->table('saiyoojyam_tariffs')->where('tariffs_id', (int) $inmate->inmates_tariffs)->get()->getRow() : null;
            $rentRate = $tRow ? (float) $tRow->tariffs_price : 0.0;
            $invoiceTotal = $rentRate + $cautionDeposit + $admissionFees;
            $paidAmount = $invoiceTotal;
            $balanceAmount = 0.0;
            $status = 1;
        }

        // Determine if caution deposit and admission fee belong on this specific invoice
        // They are one-time fees applicable ONLY to the first admission invoice
        $isFirstInvoice = false;
        if ($invRow && $inmate) {
            $firstInv = $db->table('saiyoojyam_invoice')
                ->where('invoice_inmates', (string) $inmate->inmates_id)
                ->orderBy('invoice_id', 'ASC')
                ->get()->getRow();
            if ($firstInv && (int)$firstInv->invoice_id === (int)$invRow->invoice_id) {
                $isFirstInvoice = true;
            }
        } elseif (!$invRow && $inmate) {
            $isFirstInvoice = true;
        }

        if ($isFirstInvoice && ($cautionDeposit > 0 || $admissionFees > 0)) {
            $displayCaution = $cautionDeposit;
            $displayAdmission = $admissionFees;
            $displayRent = max(0.0, $invoiceTotal - ($displayCaution + $displayAdmission));
            if ($displayRent == 0 && $invRow && (float)$invRow->invoice_rent > 0) {
                $displayRent = (float)$invRow->invoice_rent;
            }
        } else {
            $displayCaution = 0.0;
            $displayAdmission = 0.0;
            // On regular recurring invoices, if invoice_rent was corrupted by the duplicate input name bug to equal balance, fall back to invoiceTotal
            if ($invRow) {
                $rentInDb = (float)$invRow->invoice_rent;
                if ($rentInDb > 0 && ($rentInDb != $balanceAmount || $balanceAmount == 0)) {
                    $displayRent = $rentInDb;
                } else {
                    $displayRent = $invoiceTotal;
                }
            } else {
                $displayRent = $invoiceTotal;
            }
        }

        $paymentMonthDisplay = date('F Y', strtotime($paymentMonth));
        if ($inmate) {
            $joinDay = (int)date('j', strtotime($joinDate));
            $nextMonthDate = date('Y-m-01', strtotime('first day of next month', strtotime($joinDate)));
            if ($joinDay >= 21 && $paymentMonth == $nextMonthDate) {
                $paymentMonthDisplay = date('F Y', strtotime($joinDate)) . ' & ' . date('F Y', strtotime($paymentMonth));
            }
        }

        // Status badge label and styling
        $statusText = 'Fully Paid';
        $statusColor = '#2e7d32'; // green
        if ($status == 2) {
            $statusText = 'Partially Paid';
            $statusColor = '#e65100'; // orange
        } elseif ($status == 3) {
            $statusText = 'Advance Paid';
            $statusColor = '#1565c0'; // blue
        } elseif ($status == 0) {
            $statusText = 'Unpaid';
            $statusColor = '#c62828'; // red
        }

        $logo = base_url('assets/admin/img/logo.png');

        $html = '
    <html>
    <head><meta charset="utf-8"></head>
    <body style="font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #2c3e50;">

    <!-- FULL BORDER WRAPPER -->
    <div style="border: 1px solid #ddd; padding: 20px; height: 100%; box-sizing: border-box;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 15px;">
            <img src="' . $logo . '" style="height: 50px; margin-bottom: 6px;">
            <h2 style="margin: 2px 0 4px 0; font-size: 20px; color: #1e293b; font-weight: bold;">' . htmlspecialchars($buildingHeaderName) . '</h2>
            <div style="font-size: 11px; color: #555; line-height: 1.4;">
                ' . $buildingAddressHtml . '
                ' . (!empty($buildingContact) ? '<br><span>Phone / WhatsApp: ' . htmlspecialchars($buildingContact) . '</span>' : '') . '
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #aaa; margin-bottom: 15px;">

        <!-- Title & Meta -->
        <div style="text-align: center; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 0.5px;">INVOICE & RECEIPT</h3>
            <div style="font-size: 12px; color: #555; margin-top: 5px;">
                ' . ($invoiceNo ? 'Invoice No: <strong>#INV-' . htmlspecialchars($invoiceNo) . '</strong> &nbsp;|&nbsp; ' : '') . '
                ' . ($inmateUid ? 'Booking ID: <strong>' . htmlspecialchars($inmateUid) . '</strong>' : '') . '
                ' . ($invoicePaidDate && $invoicePaidDate != '0000-00-00' ? ' &nbsp;|&nbsp; Date: <strong>' . date('d M Y', strtotime($invoicePaidDate)) . '</strong>' : '') . '
            </div>
        </div>

        <!-- Personal Info -->
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 12px; background-color: #f9f9f9;">
            <h4 style="margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #374151;">Personal Details</h4>
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="padding: 4px; width: 25%; font-weight: bold; color: #555;">Name</td>
                    <td style="padding: 4px; color: #111;">' . htmlspecialchars($guestName) . '</td>
                    ' . (!empty($guestPhone) ? '<td style="padding: 4px; width: 20%; font-weight: bold; color: #555;">Phone</td><td style="padding: 4px; color: #111;">' . htmlspecialchars($guestPhone) . '</td>' : '<td></td><td></td>') . '
                </tr>
                <tr>
                    <td style="padding: 4px; font-weight: bold; color: #555;">Join Date</td>
                    <td style="padding: 4px; color: #111;">' . date('d M Y', strtotime($joinDate)) . '</td>
                    <td style="padding: 4px; font-weight: bold; color: #555;">Payment Month</td>
                    <td style="padding: 4px; color: #111;">' . $paymentMonthDisplay . '</td>
                </tr>
            </table>
        </div>

        <!-- Room Info -->
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 12px; background-color: #fdfdfd;">
            <h4 style="margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #374151;">Room Details</h4>
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="padding: 4px; width: 25%; font-weight: bold; color: #555;">Building</td>
                    <td style="padding: 4px; color: #111;">' . htmlspecialchars($building) . '</td>
                    <td style="padding: 4px; width: 20%; font-weight: bold; color: #555;">Room</td>
                    <td style="padding: 4px; color: #111;">' . htmlspecialchars($room) . '</td>
                </tr>
            </table>
        </div>

        <!-- Payment Breakdown -->
        <div style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">
            <h4 style="margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #374151;">Payment Breakdown</h4>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; width: 60%; color: #374151;">Rent Amount</td>
                    <td style="padding: 6px; text-align: right; color: #111;">₹' . number_format($displayRent, 2) . '</td>
                </tr>
                ' . ($displayCaution > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; color: #374151;">Caution Deposit (One-time)</td>
                    <td style="padding: 6px; text-align: right; color: #111;">₹' . number_format($displayCaution, 2) . '</td>
                </tr>' : '') . '
                ' . ($displayAdmission > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; color: #374151;">Admission Fee (One-time)</td>
                    <td style="padding: 6px; text-align: right; color: #111;">₹' . number_format($displayAdmission, 2) . '</td>
                </tr>' : '') . '
                <tr style="border-top: 2px solid #cbd5e1; background-color: #f1f5f9;">
                    <td style="padding: 7px 6px; font-weight: bold; color: #0f172a;">Total Billed</td>
                    <td style="padding: 7px 6px; text-align: right; font-weight: bold; color: #0f172a;">₹' . number_format($invoiceTotal, 2) . '</td>
                </tr>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; font-weight: bold; color: #2e7d32;">Amount Paid</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #2e7d32;">₹' . number_format($paidAmount, 2) . '</td>
                </tr>
                ' . ($balanceAmount > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb; background-color: #fef2f2;">
                    <td style="padding: 6px; font-weight: bold; color: #dc2626;">Balance Remaining</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #dc2626;">₹' . number_format($balanceAmount, 2) . '</td>
                </tr>' : '') . '
                ' . ($advanceAmount > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb; background-color: #eff6ff;">
                    <td style="padding: 6px; font-weight: bold; color: #2563eb;">Advance Carried Forward</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #2563eb;">₹' . number_format($advanceAmount, 2) . '</td>
                </tr>' : '') . '
                <tr style="border-top: 1px solid #94a3b8;">
                    <td style="padding: 8px 6px; font-weight: bold; font-size: 13px;">Payment Status</td>
                    <td style="padding: 8px 6px; text-align: right; font-weight: bold; font-size: 13px; color: ' . $statusColor . ';">' . $statusText . '</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div style="text-align: center; font-size: 11px; color: #64748b; margin-top: 25px;">
            <p style="margin: 3px 0;">Thank you for staying with us at Saiyoojyam.</p>
            <p style="margin: 3px 0;">For queries, contact the hostel office.</p>
        </div>

    </div> <!-- End border wrapper -->

    </body>
    </html>';

        $mpdf->WriteHTML($html);

        return $this->response
            ->setContentType('application/pdf')
            ->setBody($mpdf->Output('invoice_' . ($invoiceNo ? 'INV' . $invoiceNo : ($inmateUid ?: $id)) . '.pdf', 'I'));
    }


    public function Delete($id = null){
        if(empty($id)){
            return redirect()->to(site_url().'Admin/Inmates');
        }

        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $id));

        if(empty($inmate)){

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Inmate not found',
            );

            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url().'Admin/Inmates');
        }

        $invoice = $this->common_model->SingleRow('saiyoojyam_invoice',array('invoice_inmates' => $id));

        if(!empty($invoice)){

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Cannot delete: Inmate has payment/invoice history',
            );

            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url().'Admin/Inmates');
        }

        $this->common_model->DeleteData('saiyoojyam_inmates',array('inmates_id' => $id));

        $this->common_model->DeleteData('saiyoojyam_inmate_room_history',array('room_history_inmates_id' => $id));

        if (!empty($inmate->inmates_user_id)) {
            $db = \Config\Database::connect();
            $db->table('auth_identities')->where('user_id', $inmate->inmates_user_id)->delete();
            $db->table('auth_groups_users')->where('user_id', $inmate->inmates_user_id)->delete();
            $db->table('users')->where('id', $inmate->inmates_user_id)->delete();
            if ($db->tableExists('saiyoojyam_users')) {
                $db->table('saiyoojyam_users')->where('users_id', $inmate->inmates_user_id)->delete();
            }
        }

        $uploadPath = WRITEPATH . 'uploads/inmates/';

        if(!empty($inmate->inmates_id_proof) && is_file($uploadPath.$inmate->inmates_id_proof)){
            @unlink($uploadPath.$inmate->inmates_id_proof);
        }

        if(!empty($inmate->inmates_photo) && is_file($uploadPath.$inmate->inmates_photo)){
            @unlink($uploadPath.$inmate->inmates_photo);
        }

        $flashdata = array(
            'type' => 'success',
            'msg'  => 'Inmate Deleted Successfully',
        );

        $this->session->setFlashdata('alert',$flashdata);

        return redirect()->to(site_url().'Admin/Inmates');
    }


    public function CheckOut($id = null){

        $isAjax = $this->request->isAJAX() || $this->request->getPost("is_ajax") || ($this->request->getHeaderLine("X-Requested-With") === "XMLHttpRequest");

        $inmateId = $id ?: $this->request->getPost('inmates_id');
        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates', array('inmates_id' => $inmateId));

        if(empty($inmate)){
            $msg = 'Inmate not found.';
            if ($isAjax) {
                return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url().'Admin/Inmates');
        }

        $today = date('Y-m-d');

        // Check if inmate is already completely checked out in the past or today
        if($inmate->inmates_status === 'checked_out' && !empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date <= $today){
            $msg = 'Inmate has already checked out on ' . date('d-M-Y', strtotime($inmate->inmates_check_out_date)) . '.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url().'Admin/Inmates');
        }

        $checkout_type = $this->request->getPost('checkout_type') ?: 'today';

        if ($checkout_type === 'upcoming') {
            $checkout_date = trim((string)$this->request->getPost('upcoming_checkout_date'));
            if (empty($checkout_date)) {
                $checkout_date = trim((string)$this->request->getPost('checkout_date'));
            }
            if (empty($checkout_date)) {
                $msg = 'Please select a valid upcoming check out date.';
                if ($isAjax) {
                    return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => $msg]);
                }
                $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
                return redirect()->to(site_url().'Admin/Inmates');
            }
            if ($checkout_date < $today) {
                $msg = 'Upcoming check out date must be today or a future date.';
                if ($isAjax) {
                    return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => $msg]);
                }
                $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
                return redirect()->to(site_url().'Admin/Inmates');
            }
        } else {
            $checkout_date = $today;
        }

        // If resident already has a scheduled upcoming check-out date in the future,
        // rescheduled check-out date cannot be earlier than the currently scheduled date.
        $existingCheckout = (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date !== '0000-00-00') ? $inmate->inmates_check_out_date : null;
        if ($existingCheckout && $existingCheckout > $today && $checkout_date < $existingCheckout) {
            $existing_fmt = date('d-M-Y', strtotime($existingCheckout));
            $msg = 'Check out date cannot be earlier than currently scheduled date (' . $existing_fmt . ').';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url().'Admin/Inmates');
        }

        // Validate 1-month minimum stay rule: Inmates can check out only after 1 month from check in date
        // Note: Policy applies ONLY to Long Term stay. Short Term stays (duration_of_stay == 1) do NOT require a 1-month minimum stay!
        $isShortTerm = ((int)($inmate->inmates_duration_of_stay ?? 0) === 1);
        if (!$isShortTerm && !empty($inmate->inmates_check_in_date) && $inmate->inmates_check_in_date !== '0000-00-00') {
            $one_month = date('Y-m-d', strtotime($inmate->inmates_check_in_date . ' + 1 month'));
            if ($checkout_date < $one_month) {
                $checkin_fmt = date('d-M-Y', strtotime($inmate->inmates_check_in_date));
                $eligible_fmt = date('d-M-Y', strtotime($one_month));
                $msg = 'Check out is allowed only after one month from the check in date (' . $checkin_fmt . '). Earliest allowed check out date is ' . $eligible_fmt . '.';
                if ($isAjax) {
                    return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => $msg]);
                }
                $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
                return redirect()->to(site_url().'Admin/Inmates');
            }
        }

        if (!empty($inmate->inmates_check_in_date) && $checkout_date < $inmate->inmates_check_in_date) {
            $msg = 'Check out date cannot be earlier than check in date (' . date('d-M-Y', strtotime($inmate->inmates_check_in_date)) . ').';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url().'Admin/Inmates');
        }

        // Determine status:
        // If checkout is today or past, status is 'checked_out'
        // If checkout is an upcoming date in future, inmate remains 'active' until that date arrives
        $status = ($checkout_date <= $today) ? 'checked_out' : 'active';

        $this->common_model->EditData(array(
            'inmates_check_out_date' => $checkout_date,
            'inmates_status'         => $status,
        ), array('inmates_id' => $inmateId), 'saiyoojyam_inmates');

        // Recalculate rent and synchronize invoice balance if checkout date changed
        $this->syncCheckoutExtensionRent($inmateId, $existingCheckout, $checkout_date);

        $formatted_date = date('d-M-Y', strtotime($checkout_date));
        $msg = ($status === 'checked_out')
            ? "Inmate checked out successfully today ($formatted_date)."
            : "Upcoming check out date scheduled successfully for $formatted_date. Resident remains active until this date.";

        if ($isAjax) {
            return $this->response->setJSON([
                'status'        => true,
                'message'       => $msg,
                'checkout_date' => $formatted_date,
                'inmate_status' => $status
            ]);
        }

        $this->session->setFlashdata('alert', ['type' => 'success', 'msg' => $msg]);
        return redirect()->to(site_url().'Admin/Inmates');
    }

    /**
     * Synchronize invoice rent and balance when an inmate's checkout date is updated/extended.
     */
    public function syncCheckoutExtensionRent($inmateId, $oldCheckout = null, $newCheckout = null)
    {
        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates', ['inmates_id' => $inmateId]);
        if (!$inmate) {
            return;
        }

        $checkIn = $inmate->inmates_check_in_date;
        $checkOut = !empty($newCheckout) ? $newCheckout : $inmate->inmates_check_out_date;

        if (empty($checkIn) || $checkIn === '0000-00-00' || empty($checkOut) || $checkOut === '0000-00-00') {
            return;
        }

        $checkoutMonth = date('Y-m-01', strtotime($checkOut));
        $checkinMonth = date('Y-m-01', strtotime($checkIn));

        // Find existing invoice for checkout month, or check-in month
        $invoice = $this->common_model->SingleRow('saiyoojyam_invoice', [
            'invoice_inmates'       => $inmateId,
            'invoice_payment_month' => $checkoutMonth,
        ]);

        if (!$invoice) {
            $invoice = $this->common_model->SingleRow('saiyoojyam_invoice', [
                'invoice_inmates'       => $inmateId,
                'invoice_payment_month' => $checkinMonth,
            ]);
        }

        if (!$invoice) {
            return;
        }

        $isShortTerm = ((int)$inmate->inmates_duration_of_stay === 1);

        $effective_tariff = $this->getEffectiveTariff($inmateId, $invoice->invoice_payment_month);
        $monthlyBaseRent = !empty($effective_tariff) ? (float)$this->getApplicableRent($effective_tariff->tariffs_id, $invoice->invoice_payment_month, $effective_tariff->tariffs_price) : 0;
        if ($monthlyBaseRent <= 0 && !empty($inmate->inmates_tariffs)) {
            $tariff = $this->common_model->SingleRow('saiyoojyam_tariffs', ['tariffs_id' => $inmate->inmates_tariffs]);
            $monthlyBaseRent = !empty($tariff) ? (float)$tariff->tariffs_price : 0;
        }

        if ($monthlyBaseRent <= 0) {
            return;
        }

        $invMonth = $invoice->invoice_payment_month;
        $invYear = (int)date('Y', strtotime($invMonth));
        $invMonthNum = (int)date('m', strtotime($invMonth));
        $daysInInvMonth = cal_days_in_month(CAL_GREGORIAN, $invMonthNum, $invYear);
        $perDayRate = $monthlyBaseRent / $daysInInvMonth;

        if ($isShortTerm) {
            $dIn = new \DateTime($checkIn);
            $dOut = new \DateTime($checkOut);

            if (date('Y-m', strtotime($checkOut)) === date('Y-m', strtotime($invMonth))) {
                if (date('Y-m', strtotime($checkIn)) === date('Y-m', strtotime($invMonth))) {
                    $diff = $dIn->diff($dOut);
                    $stayDays = max(1, (int)$diff->days);
                } else {
                    $stayDays = max(1, (int)date('j', strtotime($checkOut)));
                }
            } else {
                $inDay = (int)date('j', strtotime($checkIn));
                $stayDays = max(1, $daysInInvMonth - $inDay + 1);
            }

            $expectedRent = round($stayDays * $perDayRate, 2);
        } else {
            $expectedRent = $this->getVacatingRent($monthlyBaseRent, $invMonth, $checkOut, $checkIn);
        }

        $currentRent = (float)$invoice->invoice_rent;
        if (abs($expectedRent - $currentRent) > 0.01) {
            $rentDiff = $expectedRent - $currentRent;
            $newTotal = round((float)$invoice->invoice_total + $rentDiff, 2);
            $paidAmount = (float)$invoice->invoice_paid_amount;
            $newBalance = max(0, round($newTotal - $paidAmount, 2));
            $newAdvance = max(0, round($paidAmount - $newTotal, 2));

            $newStatus = 1; // Fully paid
            if ($newBalance > 0.01) {
                $newStatus = 2; // Partially paid
            } elseif ($newAdvance > 0.01) {
                $newStatus = 3; // Advance paid
            }

            $this->common_model->EditData([
                'invoice_rent'    => $expectedRent,
                'invoice_total'   => $newTotal,
                'invoice_balance' => $newBalance,
                'invoice_advance' => $newAdvance,
                'invoice_status'  => $newStatus,
            ], ['invoice_id' => $invoice->invoice_id], 'saiyoojyam_invoice');
        }
    }

    /**
     * Helper to synchronize current invoice of an inmate with their current check out date.
     */
    public function syncInmateCurrentInvoiceWithCheckout($inmateId)
    {
        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates', ['inmates_id' => $inmateId]);
        if ($inmate && !empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date !== '0000-00-00') {
            $this->syncCheckoutExtensionRent($inmateId, null, $inmate->inmates_check_out_date);
        }
    }


    private function getApplicableRent($tariff_id, $payment_month, $current_price){

        $history = $this->common_model->FetchWhereOrderby('saiyoojyam_tariff_history',array('tariff_history_tariff_id' => $tariff_id),'tariff_history_effective_month','ASC');

        $pm = date('Y-m', strtotime($payment_month));

        if(empty($history)){

            return $current_price;
        }

        $applicable = $history[0]->tariff_history_old_price;

        foreach($history as $h){

            if($h->tariff_history_effective_month <= $pm){

                $applicable = $h->tariff_history_new_price;
            }
        }

        return $applicable;
    }


    private function getEffectiveRoomId($inmate_id, $payment_month){

        $room_history = $this->common_model->FetchWhereOrderby('saiyoojyam_inmate_room_history',array('room_history_inmates_id' => $inmate_id),'room_history_effective_month','ASC');

        $pm = date('Y-m', strtotime($payment_month));

        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $inmate_id));

        if(empty($room_history)){

            return $inmate->inmates_rooms;
        }

        $effective_room = null;

        foreach($room_history as $h){

            if($h->room_history_effective_month <= $pm){

                $effective_room = $h->room_history_new_room;
            }
        }

        if($effective_room === null){

            $effective_room = $room_history[0]->room_history_old_room;
        }

        return $effective_room;
    }


    private function findTariffForRoom($room_id, $building_id = null, $room_type_id = null){
        $db = \Config\Database::connect('default');

        if (!empty($building_id) && !empty($room_type_id)) {
            $t = $db->table('saiyoojyam_tariffs')
                ->where('tariffs_building', (int)$building_id)
                ->where('tariffs_room_types', (int)$room_type_id)
                ->get()
                ->getRow();
            if ($t) return $t;
        }

        if (!empty($building_id) && !empty($room_id)) {
            $room = $db->table('saiyoojyam_rooms')->where('rooms_id', (int)$room_id)->get()->getRow();
            if ($room && !empty($room->rooms_type)) {
                $t = $db->table('saiyoojyam_tariffs')
                    ->where('tariffs_building', (int)$building_id)
                    ->where('tariffs_room_types', (int)$room->rooms_type)
                    ->get()
                    ->getRow();
                if ($t) return $t;
            }
        }

        if (!empty($room_id)) {
            $t = $db->table('saiyoojyam_tariffs')
                ->where('tariffs_rooms', (string)$room_id)
                ->get()
                ->getRow();
            if ($t) return $t;

            $t = $db->table('saiyoojyam_tariffs')
                ->where("FIND_IN_SET(" . $db->escape((string)$room_id) . ", tariffs_rooms) > 0")
                ->get()
                ->getRow();
            if ($t) return $t;
        }

        return null;
    }

    private function getEffectiveTariff($inmate_id, $payment_month){

        $room_id = $this->getEffectiveRoomId($inmate_id, $payment_month);

        $room = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $room_id));

        if(empty($room)){

            return null;
        }

        return $this->findTariffForRoom($room->rooms_id, $room->rooms_building, $room->rooms_type ?? null);
    }

    private function getSplitMonthRent($inmate_id, $payment_month, $default_monthly_rent){

        $room_history = $this->common_model->FetchWhereOrderby('saiyoojyam_inmate_room_history', array('room_history_inmates_id' => $inmate_id), 'room_history_effective_date', 'ASC');

        if(empty($room_history)){

            return $default_monthly_rent;
        }

        $pm = date('Y-m', strtotime($payment_month));

        $year = (int) date('Y', strtotime($pm));

        $month = (int) date('n', strtotime($pm));

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $changes_in_month = array();

        $current_room = null;

        $inmate = $this->common_model->SingleRow('saiyoojyam_inmates', array('inmates_id' => $inmate_id));

        $first_day = $pm . '-01';

        foreach($room_history as $h){

            $ed = $h->room_history_effective_date;

            if(empty($ed) || $ed == '0000-00-00'){

                continue;
            }

            if(date('Y-m', strtotime($ed)) == $pm){

                $changes_in_month[] = $h;

            }elseif($ed < $first_day){

                $current_room = $h->room_history_new_room;
            }
        }

        if(empty($changes_in_month)){

            return $default_monthly_rent;
        }

        if($current_room === null){

            $current_room = !empty($changes_in_month[0]) ? $changes_in_month[0]->room_history_old_room : (!empty($inmate) ? $inmate->inmates_rooms : $room_history[0]->room_history_old_room);
        }

        $room_per_day = array();

        for($d = 1; $d <= $days_in_month; $d++){

            $room_per_day[$d] = $current_room;
        }

        foreach($changes_in_month as $h){

            $change_day = (int) date('j', strtotime($h->room_history_effective_date));

            for($d = $change_day; $d <= $days_in_month; $d++){

                $room_per_day[$d] = $h->room_history_new_room;
            }
        }

        $room_prices = array();

        foreach($room_per_day as $room_id){

            if(isset($room_prices[$room_id])){

                continue;
            }

            $room = $this->common_model->SingleRow('saiyoojyam_rooms', array('rooms_id' => $room_id));

            $tariff = !empty($room) ? $this->findTariffForRoom($room->rooms_id, $room->rooms_building, $room->rooms_type ?? null) : null;

            $stored_price = 0;

            foreach($room_history as $h){

                if($h->room_history_old_room == $room_id){

                    $stored_price = $h->room_history_old_tariff_price;
                }

                if($h->room_history_new_room == $room_id){

                    $stored_price = $h->room_history_new_tariff_price;
                }
            }

            $room_prices[$room_id] = !empty($tariff) ? $this->getApplicableRent($tariff->tariffs_id, $pm, $tariff->tariffs_price) : $stored_price;
        }

        $per_day = array();

        foreach($room_prices as $room_id => $monthly_price){

            $per_day[$room_id] = $monthly_price / $days_in_month;
        }

        $split_rent = 0;

        foreach($room_per_day as $room_id){

            $split_rent += $per_day[$room_id];
        }

        return round($split_rent, 2);
    }

    private function getVacatingRent($monthly_rent, $payment_month, $check_out_date, $check_in_date = null){

        if(empty($check_out_date) || $check_out_date == '0000-00-00'){

            return $monthly_rent;
        }

        $pm = date('Y-m', strtotime($payment_month));

        $cm = date('Y-m', strtotime($check_out_date));

        if($pm != $cm){

            return $monthly_rent;
        }

        $day = (int) date('j', strtotime($check_out_date));
        $year = (int) date('Y', strtotime($check_out_date));
        $month = (int) date('n', strtotime($check_out_date));
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $per_day = $monthly_rent / $days_in_month;

        // If the inmate joined in the same month as vacating, charge from check-in to check-out
        if (!empty($check_in_date) && $check_in_date != '0000-00-00' && date('Y-m', strtotime($check_in_date)) == $cm) {
            $in_day = (int) date('j', strtotime($check_in_date));
            $stay_days = max(1, $day - $in_day + 1);
        } else {
            // Vacating month (joined in an earlier month): charge for days from 1st to checkout day
            $stay_days = $day;
        }

        if ($stay_days > $days_in_month) {
            $stay_days = $days_in_month;
        }

        $monthly_rent = round($stay_days * $per_day, 2);

        return $monthly_rent;
    }



    public function Pending()
    {
        return redirect()->to(base_url("Admin/Home#pending-bookings-section"));
    }

    public function ApproveBooking()
    {
        $isAjax = $this->request->isAJAX() || $this->request->getPost("is_ajax") || ($this->request->getHeaderLine("X-Requested-With") === "XMLHttpRequest");

        $inmateId = (int) $this->request->getPost("inmates_id");
        $username = trim((string) $this->request->getPost("username"));
        $email    = trim((string) $this->request->getPost("email"));
        $phone    = trim((string) $this->request->getPost("phone"));
        $password = trim((string) $this->request->getPost("password"));

        if ($inmateId <= 0) {
            $msg = "Invalid booking ID.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        if (empty($username) || empty($email) || empty($password)) {
            $msg = "Username, Email and Password are required to approve inmate and create their login.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        if (strlen($password) < 8) {
            $msg = "Password must be at least 8 characters long.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        if (!preg_match('/[a-z]/', $password)) {
            $msg = "Password must contain at least one lowercase letter.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $msg = "Password must contain at least one uppercase letter.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        if (!preg_match('/[0-9]/', $password)) {
            $msg = "Password must contain at least one number.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        $db = \Config\Database::connect();
        $inmate = $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->get()->getRow();
        if (!$inmate) {
            $msg = "Inmate booking record not found.";
            if ($isAjax) {
                return $this->response->setStatusCode(404)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        // 1. Resolve or Create CodeIgniter Shield User
        // Guard against duplicate email belonging to another active or pending resident
        $otherInmateByEmail = $db->table("saiyoojyam_inmates")
            ->where("inmates_id !=", $inmateId)
            ->where("LOWER(inmates_email)", strtolower($email))
            ->whereIn("inmates_status", ["active", "pending"])
            ->get()
            ->getRow();

        if ($otherInmateByEmail) {
            $msg = "The email '{$email}' is already registered to another resident ({$otherInmateByEmail->inmates_name}, UID: {$otherInmateByEmail->inmates_uid}). Each resident must have their own unique email address.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        $existingEmailIdentity = $db->table("auth_identities")
            ->where("type", "email_password")
            ->where("LOWER(secret)", strtolower($email))
            ->get()
            ->getRow();

        $existingUserByUsername = $db->table("users")
            ->where("LOWER(username)", strtolower($username))
            ->get()
            ->getRow();

        $userId = 0;
        $now = date("Y-m-d H:i:s");

        if ($existingEmailIdentity) {
            // Check if this identity belongs to a DIFFERENT inmate
            $otherInmateByUser = $db->table("saiyoojyam_inmates")
                ->where("inmates_id !=", $inmateId)
                ->where("inmates_user_id", (int) $existingEmailIdentity->user_id)
                ->whereIn("inmates_status", ["active", "pending"])
                ->get()
                ->getRow();

            if ($otherInmateByUser) {
                $msg = "The email '{$email}' is already in use by another resident account ({$otherInmateByUser->inmates_name}, UID: {$otherInmateByUser->inmates_uid}). Please enter a unique email address.";
                if ($isAjax) {
                    return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
                }
                return redirect()->back()->with("error", $msg);
            }

            // An account already exists for this email address -> re-use and activate
            $existingUser = $db->table("users")->where("id", $existingEmailIdentity->user_id)->get()->getRow();

            if ($existingUser) {
                $userId = (int) $existingUser->id;

                // Update username if requested and not taken by someone else
                if (strtolower($existingUser->username) !== strtolower($username)) {
                    if (!$existingUserByUsername || $existingUserByUsername->id == $userId) {
                        $db->table("users")->where("id", $userId)->update([
                            "username"   => $username,
                            "active"     => 1,
                            "updated_at" => $now,
                        ]);
                    } else {
                        // Username is taken by another account, keep existing username
                        $username = $existingUser->username;
                        $db->table("users")->where("id", $userId)->update([
                            "active"     => 1,
                            "updated_at" => $now,
                        ]);
                    }
                } else {
                    $db->table("users")->where("id", $userId)->update([
                        "active"     => 1,
                        "updated_at" => $now,
                    ]);
                }

                // Update password
                $db->table("auth_identities")->where("id", $existingEmailIdentity->id)->update([
                    "secret2"    => password_hash($password, PASSWORD_DEFAULT),
                    "updated_at" => $now,
                ]);
            } else {
                // Clean up orphaned identity if parent user row was missing
                $db->table("auth_identities")->where("id", $existingEmailIdentity->id)->delete();
                $existingEmailIdentity = null;
            }
        }

        if (!$userId) {
            // Create brand new Shield user
            if ($existingUserByUsername) {
                // If username is taken, append unique suffix
                $username = $username . '_' . strtolower($inmate->inmates_uid ?: rand(100, 999));
            }

            $db->table("users")->insert([
                "username"   => $username,
                "active"     => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ]);
            $userId = (int) $db->insertID();

            // Insert password into auth_identities
            $db->table("auth_identities")->insert([
                "user_id"     => $userId,
                "type"        => "email_password",
                "name"        => "",
                "secret"      => $email,
                "secret2"     => password_hash($password, PASSWORD_DEFAULT),
                "force_reset" => 0,
                "created_at"  => $now,
                "updated_at"  => $now,
            ]);

            // Add group
            $db->table("auth_groups_users")->insert([
                "user_id"    => $userId,
                "group"      => "user",
                "created_at" => $now,
            ]);
        }

        // 2. Sync saiyoojyam_users
        if ($db->tableExists("saiyoojyam_users")) {
            $sUser = $db->table("saiyoojyam_users")->where("users_id", $userId)->get()->getRow();
            if ($sUser) {
                $db->table("saiyoojyam_users")->where("users_id", $userId)->update([
                    "users_name"   => $inmate->inmates_name,
                    "users_email"  => $email,
                    "users_mobile" => $phone ?: $inmate->inmates_phone_no,
                ]);
            } else {
                $db->table("saiyoojyam_users")->insert([
                    "users_id"         => $userId,
                    "users_name"       => $inmate->inmates_name,
                    "users_email"      => $email,
                    "users_mobile"     => $phone ?: $inmate->inmates_phone_no,
                    "users_address"    => "",
                    "users_created_at" => $now,
                ]);
            }
        }

        // 3. Sync saiyoojyam_customers
        if ($db->tableExists("saiyoojyam_customers")) {
            $cust = $db->table("saiyoojyam_customers")->where("customer_email", $email)->get()->getRow();
            if ($cust) {
                $db->table("saiyoojyam_customers")->where("customer_id", $cust->customer_id)->update([
                    "customer_name"  => $inmate->inmates_name,
                    "customer_phone" => $phone ?: $inmate->inmates_phone_no,
                    "updated_at"     => $now,
                ]);
            } else {
                $db->table("saiyoojyam_customers")->insert([
                    "customer_name"  => $inmate->inmates_name,
                    "customer_email" => $email,
                    "customer_phone" => $phone ?: $inmate->inmates_phone_no,
                    "created_at"     => $now,
                    "updated_at"     => $now,
                ]);
            }
        }

        // 4. Update saiyoojyam_inmates status to "active"
        $updateInmate = [
            "inmates_status"      => "active",
            "inmates_user_id"     => $userId,
            "inmates_email"       => $email,
            "inmates_approved_at" => $now,
        ];
        if (!empty($phone)) {
            $updateInmate["inmates_phone_no"] = $phone;
        }

        $postedCheckOut = $this->request->getPost("check_out_date");
        if (!empty($postedCheckOut) && $postedCheckOut !== '0000-00-00') {
            $updateInmate["inmates_check_out_date"] = date('Y-m-d', strtotime($postedCheckOut));
        }

        $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->update($updateInmate);

        // 5. Send Approval Email to User with Credentials
        $buildingRow = $db->table("saiyoojyam_building")->where("building_id", (int) $inmate->inmates_building)->get()->getRow();
        $roomRow = $db->table("saiyoojyam_rooms")->where("rooms_id", (int) $inmate->inmates_rooms)->get()->getRow();
        $buildingName = $buildingRow ? $buildingRow->building_name : "Saiyoojyam Hostel";
        $roomName = $roomRow ? "Room " . $roomRow->rooms_name : "Room #" . $inmate->inmates_rooms;

        $finalCheckOut = !empty($postedCheckOut) && $postedCheckOut !== '0000-00-00'
            ? date('Y-m-d', strtotime($postedCheckOut))
            : (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date !== '0000-00-00' ? $inmate->inmates_check_out_date : null);
        $isShortTermBooking = ((int) $inmate->inmates_duration_of_stay === 1);
        $checkOutRow = '';
        if ($isShortTermBooking && !empty($finalCheckOut)) {
            $checkOutRow = '<tr>
                        <td class="details-label">Check-out Date:</td>
                        <td class="details-value">' . date("d M Y", strtotime($finalCheckOut)) . '</td>
                    </tr>';
        }

        $emailSent = false;
        $emailError = null;
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $emailService = \Config\Services::email();
                $emailService->initialize([
                    "SMTPHost"   => "smtp.gmail.com",
                    "SMTPUser"   => "websolutionstechsoft@gmail.com",
                    "SMTPPass"   => "auugkahjshqosnrv",
                    "SMTPPort"   => 587,
                    "SMTPCrypto" => "tls",
                    "protocol"   => "smtp",
                    "fromEmail"  => "websolutionstechsoft@gmail.com",
                    "fromName"   => "Saiyoojyam Ladies Hostels",
                    "mailType"   => "html",
                    "CRLF"       => "\r\n",
                    "newline"    => "\r\n",
                ]);

                $emailService->setFrom("websolutionstechsoft@gmail.com", "Saiyoojyam Ladies Hostels");
                $emailService->setTo($email);
                $emailService->setSubject("Booking Approved - Your Saiyoojyam Inmate Login Credentials");

                $portalUrl = "http://localhost:3000";

                $htmlMessage = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background-color: #f7f7f9; margin: 0; padding: 24px; color: #1f2937; }
        .container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 24px rgba(0,0,0,0.07); border: 1px solid #eaeaea; }
        .header { background: linear-gradient(135deg, #FF561C 0%, #e0450d 100%); padding: 32px 24px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0 0 8px 0; font-size: 24px; font-weight: 700; }
        .header p { margin: 0; font-size: 14px; opacity: 0.95; }
        .content { padding: 32px 28px; }
        .greeting { font-size: 16px; font-weight: 700; margin-bottom: 12px; color: #111827; }
        .intro { font-size: 14px; line-height: 1.6; color: #4b5563; margin-bottom: 22px; }
        .details-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px; margin-bottom: 22px; }
        .details-title { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6b7280; margin-bottom: 10px; letter-spacing: 0.5px; }
        .details-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .details-table td { padding: 6px 0; }
        .details-label { color: #6b7280; }
        .details-value { font-weight: 600; color: #111827; text-align: right; }
        .cred-box { background: #fff5f2; border: 2px dashed #FF561C; border-radius: 12px; padding: 20px; margin: 24px 0; }
        .cred-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #c23807; margin-bottom: 14px; }
        .cred-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .cred-table td { padding: 8px 0; }
        .btn-wrapper { text-align: center; margin: 28px 0 10px 0; }
        .btn { display: inline-block; background: #FF561C; color: #ffffff !important; font-weight: 700; font-size: 14px; padding: 13px 32px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(255,86,28,0.3); }
        .footer { background: #f9fafb; padding: 20px 24px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Approved!</h1>
            <p>Welcome to Saiyoojyam Ladies Hostels</p>
        </div>
        <div class="content">
            <div class="greeting">Dear ' . esc($inmate->inmates_name) . ',</div>
            <div class="intro">
                We are pleased to inform you that your online room reservation has been officially <strong>approved</strong> by the hostel administration! Your inmate account is now active.
            </div>

            <!-- Booking Summary -->
            <div class="details-card">
                <div class="details-title">Booking Details</div>
                <table class="details-table">
                    <tr>
                        <td class="details-label">Booking UID:</td>
                        <td class="details-value" style="color: #FF561C; font-family: monospace;">' . esc($inmate->inmates_uid ?: ("IN" . str_pad($inmate->inmates_id, 6, "0", STR_PAD_LEFT))) . '</td>
                    </tr>
                    <tr>
                        <td class="details-label">Hostel Building:</td>
                        <td class="details-value">' . esc($buildingName) . '</td>
                    </tr>
                    <tr>
                        <td class="details-label">Room Assigned:</td>
                        <td class="details-value">' . esc($roomName) . '</td>
                    </tr>
                    <tr>
                        <td class="details-label">Check-in Date:</td>
                        <td class="details-value">' . date("d M Y", strtotime($inmate->inmates_check_in_date)) . '</td>
                    </tr>
                    ' . $checkOutRow . '
                </table>
            </div>

            <!-- Inmate Login Credentials Box -->
            <div class="cred-box">
                <div class="cred-title">Your Inmate Login Credentials</div>
                <table class="cred-table">
                    <tr style="border-bottom: 1px solid #ffdcd1;">
                        <td style="color: #6b7280;">Username:</td>
                        <td style="font-weight: 700; color: #111827; font-family: monospace; text-align: right;">' . esc($username) . '</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ffdcd1;">
                        <td style="color: #6b7280;">Email Address:</td>
                        <td style="font-weight: 700; color: #111827; text-align: right;">' . esc($email) . '</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ffdcd1;">
                        <td style="color: #6b7280;">Phone Number:</td>
                        <td style="font-weight: 700; color: #111827; text-align: right;">' . esc($phone ?: $inmate->inmates_phone_no) . '</td>
                    </tr>
                    <tr>
                        <td style="color: #6b7280;">Login Password:</td>
                        <td style="font-weight: 800; color: #FF561C; font-family: monospace; font-size: 16px; text-align: right;">' . esc($password) . '</td>
                    </tr>
                </table>
            </div>

            <div class="btn-wrapper">
                <a href="' . $portalUrl . '" class="btn" target="_blank">Access Inmate Portal</a>
            </div>

            <p style="font-size: 12px; color: #6b7280; line-height: 1.5; margin-top: 24px; text-align: center;">
                Please keep these credentials confidential. At the time of check-in, kindly present your government ID proof at the reception.
            </p>
        </div>

        <div class="footer">
            <strong>Saiyoojyam Ladies Hostels</strong><br>
            Kakkanad, Kochi, Kerala<br>
            Helpline: +91 70341 11368 | websolutionstechsoft@gmail.com
        </div>
    </div>
</body>
</html>';

                $emailService->setMessage($htmlMessage);
                $emailSent = $emailService->send(false);
                if (!$emailSent) {
                    $emailError = $emailService->printDebugger(["headers"]);
                    log_message("error", "[ApproveBooking] Email send error: " . $emailError);
                }
            } catch (\Throwable $e) {
                $emailError = $e->getMessage();
                log_message("error", "[ApproveBooking] Email exception: " . $emailError);
            }
        }

        $successMsg = "Booking request approved successfully! Inmate is now officially active. Credentials created -> Username: " . $username . ", Email: " . $email;
        if ($emailSent) {
            $successMsg .= ". An approval email with login credentials has been sent to " . $email . ".";
        } elseif ($emailError) {
            $successMsg .= " (Note: Could not send email notification: " . strip_tags($emailError) . ")";
        }

        if ($isAjax) {
            return $this->response->setJSON([
                "status"  => true,
                "message" => $successMsg,
                "data"    => [
                    "inmates_id"  => $inmateId,
                    "username"    => $username,
                    "email"       => $email,
                    "phone"       => $phone,
                    "inmate_name" => $inmate->inmates_name,
                    "receipt_url" => base_url("Admin/Inmates/Receipt/" . $inmateId),
                ],
            ]);
        }

        return redirect()->to(base_url("Admin/Home"))->with("success", $successMsg);
    }

    public function RejectBooking()
    {
        $isAjax = $this->request->isAJAX() || $this->request->getPost("is_ajax") || ($this->request->getHeaderLine("X-Requested-With") === "XMLHttpRequest");

        $inmateId = (int) $this->request->getPost("inmates_id");
        if ($inmateId <= 0) {
            $msg = "Invalid booking ID.";
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        $db = \Config\Database::connect();
        $inmate = $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->get()->getRow();
        if (!$inmate) {
            $msg = "Inmate record not found.";
            if ($isAjax) {
                return $this->response->setStatusCode(404)->setJSON(["status" => false, "message" => $msg]);
            }
            return redirect()->back()->with("error", $msg);
        }

        // Ensure column enum supports 'rejected'
        try {
            $colRes = $db->query("SHOW COLUMNS FROM saiyoojyam_inmates LIKE 'inmates_status'")->getRow();
            if ($colRes && stripos($colRes->Type, "'rejected'") === false) {
                $db->query("ALTER TABLE saiyoojyam_inmates MODIFY COLUMN inmates_status ENUM('pending','active','checked_out','rejected','cancelled') NOT NULL DEFAULT 'pending'");
            }
        } catch (\Throwable $e) {}

        $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->update([
            "inmates_status"         => "rejected",
            "inmates_check_out_date" => date('Y-m-d'),
        ]);

        $successMsg = "Booking request has been rejected.";
        if ($isAjax) {
            return $this->response->setJSON(["status" => true, "message" => $successMsg]);
        }
        return redirect()->to(base_url("Admin/Home"))->with("success", $successMsg);
    }

    public function RegeneratePassword()
    {
        $isAjax = $this->request->isAJAX() || $this->request->getPost("is_ajax") || ($this->request->getHeaderLine("X-Requested-With") === "XMLHttpRequest");

        $inmateId = (int) $this->request->getPost("inmates_id");
        if ($inmateId <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                "status"  => false,
                "message" => "Invalid Inmate ID.",
            ]);
        }

        $db = \Config\Database::connect();
        $inmate = $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->get()->getRow();
        if (!$inmate) {
            return $this->response->setStatusCode(404)->setJSON([
                "status"  => false,
                "message" => "Inmate record not found.",
            ]);
        }

        $now = date("Y-m-d H:i:s");
        $customPassword = trim((string) $this->request->getPost("password"));
        $sendEmail = (int) $this->request->getPost("send_email");

        // Generate password if empty
        if (!empty($customPassword)) {
            $password = $customPassword;
            if (strlen($password) < 6) {
                return $this->response->setStatusCode(400)->setJSON([
                    "status"  => false,
                    "message" => "Password must be at least 6 characters long.",
                ]);
            }
        } else {
            // Generate clean, memorable strong password e.g. Saiy742@26K
            $randNum = rand(100, 999);
            $symbols = ['@', '#', '$', '!', '&'];
            $sym = $symbols[array_rand($symbols)];
            $randChar = chr(rand(65, 90));
            $password = "Saiy" . $randNum . $sym . date('y') . $randChar;
        }

        $email = trim((string) ($inmate->inmates_email ?? ''));
        $phone = trim((string) ($inmate->inmates_phone_no ?? ''));

        // Resolve or create Shield user account
        $userId = (int) ($inmate->inmates_user_id ?? 0);
        $userRow = null;
        if ($userId > 0) {
            $userRow = $db->table("users")->where("id", $userId)->get()->getRow();
        }

        // If not linked yet, check by email in auth_identities
        if (!$userRow && !empty($email)) {
            $existingIdent = $db->table("auth_identities")
                ->where("type", "email_password")
                ->where("LOWER(secret)", strtolower($email))
                ->get()
                ->getRow();
            if ($existingIdent) {
                $userRow = $db->table("users")->where("id", (int) $existingIdent->user_id)->get()->getRow();
                if ($userRow) {
                    $userId = (int) $userRow->id;
                }
            }
        }

        // Generate username if creating or needing update
        $cleanUsername = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($inmate->inmates_name ?: 'inmate'));
        if (strlen($cleanUsername) < 3) {
            $cleanUsername = 'inmate' . $inmateId;
        }

        if (!$userRow) {
            // Check if username taken
            $taken = $db->table("users")->where("username", $cleanUsername)->get()->getRow();
            if ($taken) {
                $cleanUsername = $cleanUsername . '_' . strtolower($inmate->inmates_uid ?: rand(100, 999));
            }

            $db->table("users")->insert([
                "username"   => $cleanUsername,
                "active"     => 1,
                "created_at" => $now,
                "updated_at" => $now,
            ]);
            $userId = (int) $db->insertID();

            // Insert password into auth_identities
            $db->table("auth_identities")->insert([
                "user_id"     => $userId,
                "type"        => "email_password",
                "name"        => "",
                "secret"      => $email ?: ($cleanUsername . '@saiyoojyam.local'),
                "secret2"     => password_hash($password, PASSWORD_DEFAULT),
                "force_reset" => 0,
                "created_at"  => $now,
                "updated_at"  => $now,
            ]);

            // Add group
            $db->table("auth_groups_users")->insert([
                "user_id"    => $userId,
                "group"      => "user",
                "created_at" => $now,
            ]);

            // Link to inmate
            $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->update([
                "inmates_user_id" => $userId
            ]);
        } else {
            // Existing user - update password in auth_identities
            $ident = $db->table("auth_identities")
                ->where("user_id", $userId)
                ->where("type", "email_password")
                ->get()
                ->getRow();

            if ($ident) {
                $db->table("auth_identities")->where("id", $ident->id)->update([
                    "secret"     => $email ?: $ident->secret,
                    "secret2"    => password_hash($password, PASSWORD_DEFAULT),
                    "updated_at" => $now,
                ]);
            } else {
                $db->table("auth_identities")->insert([
                    "user_id"     => $userId,
                    "type"        => "email_password",
                    "name"        => "",
                    "secret"      => $email ?: ($userRow->username . '@saiyoojyam.local'),
                    "secret2"     => password_hash($password, PASSWORD_DEFAULT),
                    "force_reset" => 0,
                    "created_at"  => $now,
                    "updated_at"  => $now,
                ]);
            }

            // Ensure user is active
            $db->table("users")->where("id", $userId)->update([
                "active"     => 1,
                "updated_at" => $now,
            ]);

            // Ensure inmates_user_id is linked
            if ((int)($inmate->inmates_user_id ?? 0) !== $userId) {
                $db->table("saiyoojyam_inmates")->where("inmates_id", $inmateId)->update([
                    "inmates_user_id" => $userId
                ]);
            }

            $cleanUsername = $userRow->username;
        }

        // Send Email if requested and email is valid
        $emailSent = false;
        $emailError = null;
        if ($sendEmail && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $emailService = \Config\Services::email();
                $emailService->initialize([
                    "SMTPHost"   => "smtp.gmail.com",
                    "SMTPUser"   => "websolutionstechsoft@gmail.com",
                    "SMTPPass"   => "auugkahjshqosnrv",
                    "SMTPPort"   => 587,
                    "SMTPCrypto" => "tls",
                    "protocol"   => "smtp",
                    "fromEmail"  => "websolutionstechsoft@gmail.com",
                    "fromName"   => "Saiyoojyam Ladies Hostels",
                    "mailType"   => "html",
                    "CRLF"       => "\r\n",
                    "newline"    => "\r\n",
                ]);

                $emailService->setFrom("websolutionstechsoft@gmail.com", "Saiyoojyam Ladies Hostels");
                $emailService->setTo($email);
                $emailService->setSubject("Password Reset - Your Saiyoojyam Inmate Login Credentials");

                $portalUrl = "http://localhost:3000";

                $htmlMessage = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background-color: #f7f7f9; margin: 0; padding: 24px; color: #1f2937; }
        .container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 24px rgba(0,0,0,0.07); border: 1px solid #eaeaea; }
        .header { background: linear-gradient(135deg, #FF561C 0%, #e0450d 100%); padding: 30px 24px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0 0 6px 0; font-size: 22px; font-weight: 700; }
        .header p { margin: 0; font-size: 13px; opacity: 0.95; }
        .content { padding: 30px 26px; }
        .greeting { font-size: 16px; font-weight: 700; margin-bottom: 12px; color: #111827; }
        .intro { font-size: 14px; line-height: 1.6; color: #4b5563; margin-bottom: 20px; }
        .cred-box { background: #fff5f2; border: 2px dashed #FF561C; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .cred-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #c23807; margin-bottom: 12px; }
        .cred-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .cred-table td { padding: 7px 0; }
        .btn-wrapper { text-align: center; margin: 24px 0 10px 0; }
        .btn { display: inline-block; background: #FF561C; color: #ffffff !important; font-weight: 700; font-size: 14px; padding: 12px 30px; border-radius: 8px; text-decoration: none; }
        .footer { background: #f9fafb; padding: 18px 24px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Regenerated</h1>
            <p>Saiyoojyam Ladies Hostels - Resident Account</p>
        </div>
        <div class="content">
            <div class="greeting">Dear ' . esc($inmate->inmates_name) . ',</div>
            <div class="intro">
                Your login credentials for the Saiyoojyam Inmate Resident Portal have been updated by management. You can sign in using your new credentials below:
            </div>
            <div class="cred-box">
                <div class="cred-title">Updated Login Credentials</div>
                <table class="cred-table">
                    <tr><td style="color:#6b7280;width:35%;">Reference ID:</td><td style="font-weight:700;color:#111827;">' . esc($inmate->inmates_uid ?: 'N/A') . '</td></tr>
                    <tr><td style="color:#6b7280;">Username / Email:</td><td style="font-weight:700;color:#111827;">' . esc($email ?: $cleanUsername) . '</td></tr>
                    <tr><td style="color:#6b7280;">New Password:</td><td style="font-family:monospace;font-weight:700;font-size:16px;color:#c23807;">' . esc($password) . '</td></tr>
                </table>
            </div>
            <div class="btn-wrapper">
                <a href="' . $portalUrl . '" class="btn" target="_blank">Access Resident Portal</a>
            </div>
        </div>
        <div class="footer">
            Saiyoojyam Ladies Hostels &bull; Kakkanad, Kochi<br>
            Please keep your password secure.
        </div>
    </div>
</body>
</html>';

                $emailService->setMessage($htmlMessage);
                $emailSent = $emailService->send();
            } catch (\Throwable $e) {
                $emailSent = false;
                $emailError = $e->getMessage();
            }
        }

        return $this->response->setJSON([
            "status"        => true,
            "message"       => "Password regenerated successfully!",
            "email_sent"    => $emailSent,
            "email_address" => $email ?: "None",
            "email_error"   => $emailError,
            "credentials"   => [
                "name"       => $inmate->inmates_name,
                "uid"        => $inmate->inmates_uid ?: 'IN' . str_pad((string)$inmateId, 6, '0', STR_PAD_LEFT),
                "login_id"   => $email ?: $cleanUsername,
                "username"   => $cleanUsername,
                "email"      => $email ?: '',
                "password"   => $password,
                "portal_url" => "http://localhost:3000",
            ],
        ]);
    }
}
