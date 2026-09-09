<?php

namespace App\Controllers;

class Rooms extends BaseController
{
    public function index()
    {   
        $data['building']= $this->common_model->RoomsCategory();

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 5));

        /*$check_in_date  = date('Y-m-d'); 

        $available_rooms = [];

        foreach($data['building'] as $build){

            foreach ($build->build_rooms as $room) {

                $occupied_count = $this->common_model->CountInmatesInRoomOnDate($room->rooms_id, $check_in_date);

                if ($occupied_count < $room->rooms_capacity) {

                    $available_rooms[] = [

                        'room_id'     => $room->rooms_id,
                        'room_name'   => $room->rooms_name,
                        'capacity'    => $room->rooms_capacity,
                        'occupied'    => $occupied_count,
                        'available'   => $room->rooms_capacity - $occupied_count,
                        'buliding'    => $room->rooms_building,
                        'description' => $room->rooms_description,
                        'image'       => $room->rooms_image,
                        'ac-type'     => $room->rooms_ac_type,
                        'room_type'   => $room->room_type_name,
                        
                    ];
                }
            }
        }

        $data['available_rooms'] = $available_rooms;*/


        return view('user/rooms',$data);
    }


    public function Detail($slug){

        $joins = array(

            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'rooms_type',
            ),

            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'rooms_building',
            ),
         
        );

        $data['rooms'] = $this->common_model->SingleRowJoin('saiyoojyam_rooms',array('rooms_slug' => $slug),$joins);

        //$date = date('Y-m-d');

        //$occupied_count = $this->common_model->CountInmatesInRoomOnDate($data['rooms']->rooms_id,$date);

        //$data['available'] = $data['rooms']->rooms_capacity - $occupied_count;

        $data['available'] = $data['rooms']->rooms_capacity;

        $data['more_images'] = $this->common_model->FetchWhere('saiyoojyam_more_image',array('more_image_room_id' => $data['rooms']->rooms_id));

        $features = explode(',',$data['rooms']->rooms_features);

        $features_data = [];

        foreach($features as $feat){

            $features_data[] = $this->common_model->SingleRow('saiyoojyam_room_feature',array('feature_id' => $feat));
        }
        
        $data['features_data'] = $features_data;

        $data['duration_of_stay'] = $this->common_model->FetchAllOrder('saiyoojyam_duration_of_stay','duration_id','DESC');
      
        return view('user/room-detail',$data);

    }


    public function Checkout(){
        
        if ($this->request->getMethod() === 'POST') {
       
            $person     = $this->request->getPost('person');

            $room_id = $this->request->getPost('room_id');

            

            $check_in_date  = $this->request->getPost('check_in_date');

            if(!empty($this->request->getPost('check_out_date'))){
                 
                $check_out_date  = $this->request->getPost('check_out_date');

                $check_out_date = date('Y-m-d',strtotime($check_out_date));

            }
            else{
 
                $check_out_date = '0000-00-00';

            }

            $check_in_date = date('Y-m-d',strtotime($check_in_date));


           // $occupied_count = $this->common_model->CountInmatesInRoomBetweenDates($room_id,$check_in_date,$check_out_date);

            //$occupied_count = $this->common_model->InmatesCout($room_id,$check_in_date,$check_out_date);

            $single_rooms = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $room_id));

            $occupied_count = $this->common_model->CountInmatesInRoomOnDate($room_id,$check_in_date,$check_out_date,$single_rooms->rooms_capacity);

           
            $joins = array(

                array(
                    'table' => 'saiyoojyam_room_type',
                    'pk'    => 'room_type_id',
                    'fk'    => 'rooms_type',
                ),

                array(
                    'table' => 'saiyoojyam_building',
                    'pk'    => 'building_id',
                    'fk'    => 'rooms_building',
                ),

               
         
            );

            $data['rooms'] = $this->common_model->SingleRowJoin('saiyoojyam_rooms',array('rooms_id' => $room_id),$joins);

            

            $tariffs = $this->common_model->SingleRow('saiyoojyam_tariffs',array('tariffs_room_types' => $data['rooms']->rooms_type));

            if(!empty($tariffs)){
            
                $caution_deposit = $tariffs->tariffs_caution_deposit;

                $admission_fees = $tariffs->tariffs_admission_fees;

                $price          = $tariffs->tariffs_price;

                $total_amount = $caution_deposit + $admission_fees +  $price;
                
                /*if ($occupied_count) {
                    echo "Room is available";
                } else {
                    echo "Room is FULL";
                }
                exit();*/

                

                if($occupied_count){

                    $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 5));
                    
                    
                    
                    if(!empty($this->request->getPost('check_out_date'))){

                        $check_in = new \DateTime($check_in_date);
                        $check_out = new \DateTime($check_out_date);
                        $diff=date_diff($check_out,$check_in);

                        $stay_type = 1;

                    }else{

                        $stay_type = 2;

                        $diff = "";
                    }

                    $this->session->set('RoomData',array(

                        'room_id'          => $data['rooms']->rooms_id,

                        'room_name'        => $data['rooms']->rooms_name,
                        
                        'room_type'        => $data['rooms']->room_type_name,

                        'rooms_type_id'    => $data['rooms']->rooms_type,

                        'check_in_date'    => $check_in_date,

                        'check_out_date'   => $check_out_date,

                        'ac_type'          => $data['rooms']->rooms_ac_type,

                        'building_name'    => $data['rooms']->building_name,

                        'building_id'      => $data['rooms']->building_id,

                        'stay_type'        => $stay_type,  

                        'lenght_of_stay'   => $diff,

                        'no_person'        => $person,

                        'total_amount'     => $total_amount,

                        'caution_deposit'  => $caution_deposit,

                        'admission_fees'  => $admission_fees,
                    ));
                    
                    return view('user/check-room',$data);


                }else{
                    
                    $flashdata = array(
                        'type' => 'error',
                        'msg' => 'Room availability is limited—please try different dates',
                    );

                    $this->session->setFlashdata('alert',$flashdata);

                    return redirect()->to(site_url().'Room/'.$data['rooms']->rooms_slug);

                }

            }else{

                    $flashdata = array(
                        'type' => 'error',
                        'msg' => 'Room is not available for the selected dates. Please choose a different date range.',
                    );

                    $this->session->setFlashdata('alert',$flashdata);

                    return redirect()->to(site_url().'Room/'.$data['rooms']->rooms_slug);
            }

  
        }

    }

    public function Booking(){

        if ($this->request->getMethod() === 'POST') {

            if(empty($this->request->getPost('consent'))){

                $session = session();

                $room_data_check = $session->get("RoomData");

                $slug = "";

                if(!empty($room_data_check['room_id'])){

                    $room_row = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $room_data_check['room_id']));

                    if(!empty($room_row)){ $slug = $room_row->rooms_slug; }
                }

                $flashdata = array(
                    'type' => 'error',
                    'msg'  => 'Please accept the confirmation to proceed.',
                );

                $this->session->setFlashdata('alert',$flashdata);

                return redirect()->to(site_url('Room/'.$slug));
            }

            $idProof = $this->request->getFile('id_proof');
            $photo = $this->request->getFile('photo');

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

            $session = session();
            $room_data = $session->get("RoomData");

            $insert_data = [
                
                'inmates_name'             => $this->request->getPost('name'),
                'inmates_age'              => $this->request->getPost('age'),
                'inmates_building'         => $room_data['building_id'],
                'inmates_rooms'            => $room_data['room_id'],
                'inmates_check_in_date'    => $room_data['check_in_date'],
                'inmates_check_out_date'   => $room_data['check_out_date'],
                'inmates_duration_of_stay' => $room_data['stay_type'],
                'inmates_room_type'        => $room_data['rooms_type_id'],
                'inmates_caution_deposit'  => $room_data['caution_deposit'],
                'inmates_admission_fee'    => $room_data['admission_fees'],
                'inmates_phone_no'         => $this->request->getPost('phone'),
                'inmates_whats_app_number' => $this->request->getPost('whatsapp'),
                'inmates_guardian_name'    => $this->request->getPost('guardian_name'),
                'inmates_relation'         => $this->request->getPost('relation'),
                'inmates_guardian_contact' => $this->request->getPost('guardian_phone'),
                'inmates_id_proof'         => $idProofName,
                'inmates_photo'            => $photoName,
                'inmates_created_at'       => date('Y-m-d'),
            ]; 

            $id = $this->common_model->InsertData('saiyoojyam_inmates',$insert_data);


            $inmates_id = new_booking_id($id, 'IN');

            $this->common_model->EditData(array('inmates_uid' =>  $inmates_id),array('inmates_id' => $id),'saiyoojyam_inmates');


            $invoice_data = [
                   
                'invoice_inmates'       =>  $id,

                'invoice_payment_month' =>  date('Y-m-1'),

                'invoice_paid_date'     =>  date('Y-m-d'),
               
                'invoice_total'         =>  $room_data['total_amount'],

                'invoice_paid_amount'   =>  $room_data['total_amount'],

                'invoice_status'        =>  1

            ];

            $this->common_model->InsertData('saiyoojyam_invoice',$invoice_data);

            /*$flashdata = array(
                'type' => 'success',
                'msg' => 'Your booking has been successfully completed',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url());*/

            return redirect()->to(site_url('Rooms/payment'));

            
        }
    }


    public function Category($slug){
        
        $data['room_type'] = $this->common_model->SingleRow('saiyoojyam_room_type',array('room_type_slug' => $slug));

        $data['seo']       = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 5));

        $data['rooms']     = $this->common_model->FetchWhere('saiyoojyam_rooms',array('rooms_type' => $data['room_type']->room_type_id));

        return view('user/rooms-sub-category',$data);

    }


    public function Categories($slug){

        $data['room_building']  = $this->common_model->SingleRow('saiyoojyam_building',array('building_slug' => $slug));

        $data['seo']            = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 5));

        $data['rooms_type']     = $this->common_model->room_type(['room_type_building_id' => $data['room_building']->building_id]);

        return view('user/rooms-category',$data);

    }


    public function Payment(){

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 5));

        return view('user/payment',$data);

    }

    public function CheckAvailability(){

        if($this->request->getPost('room_id') === null){ return; }

        $room_id     = (int)$this->request->getPost('room_id');

        $check_in    = date('Y-m-d',strtotime($this->request->getPost('check_in_date')));

        $check_out_p = $this->request->getPost('check_out_date');

        $check_out   = (!empty($check_out_p)) ? date('Y-m-d',strtotime($check_out_p)) : '0000-00-00';

        $target      = (int)$this->request->getPost('persons');

        $room = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $room_id));

        $occupied = $this->common_model->CountOccupiedInRoom($room_id,$check_in,$check_out);

        $available_slots = ((int)$room->rooms_capacity) - $occupied;

        $response['capacity']         = (int)$room->rooms_capacity;

        $response['occupied']         = $occupied;

        $response['available_slots']  = $available_slots;

        $response['ok']               = $target <= $available_slots;

        echo json_encode($response);

    }
}
