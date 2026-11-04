<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index(){

        $rooms = $this->common_model->FetchAllOrder('saiyoojyam_rooms','rooms_id','DESC');

            $current_date  = date('Y-m-d');
            
            $available_rooms = [];

            foreach ($rooms as $room) {

                $occupied_count = $this->common_model->fetchAvaliableRooms($room->rooms_id, $current_date);

                if ($occupied_count < $room->rooms_capacity) {
                    $available_rooms[] = [

                        'room_id'   => $room->rooms_id,
                        'room_name' => $room->rooms_name,
                        'capacity'  => $room->rooms_capacity,
                        'occupied'  => $occupied_count,
                        'available' => $room->rooms_capacity - $occupied_count
                    ];
                }
            }

            $data['available_rooms'] = $available_rooms;

            $todays_date = date('Y-m-d');

            //todays check In's (only officially active inmates)
            $data['todays_check_in'] = $this->common_model->checkWhereCount('saiyoojyam_inmates',array('inmates_check_in_date' => $todays_date, 'inmates_status' => 'active'));
            
            //todays check out's
            $data['todays_check_out'] = $this->common_model->checkWhereCount('saiyoojyam_inmates',array('inmates_check_out_date' => $todays_date, 'inmates_status' => 'checked_out'));            

            //total active inmates
            $data['active_inmates']    = $this->common_model->checkWhereCount('saiyoojyam_inmates',array('inmates_status' => 'active')); 

            //pending bookings count & list
            $data['pending_bookings_count'] = $this->common_model->checkWhereCount('saiyoojyam_inmates', array('inmates_status' => 'pending'));
            $data['pending_bookings']       = $this->common_model->getPendingBookingRequests(); 

            // Only show pending bookings alert modal once right after login
            $showPendingAlertModal = false;
            if (session()->get('show_pending_alert_on_login') || session()->getFlashdata('show_pending_alert')) {
                $showPendingAlertModal = true;
                session()->remove('show_pending_alert_on_login');
            }
            $data['show_pending_alert_modal'] = $showPendingAlertModal;

        return view('admin/index',$data);
    }


    public function ToggleMenu($type){

        if($type=="Booking"){

            $this->session->remove('manage');
            
            return redirect()->to('admin/home'); 

        }
        else{

            $this->session->set('manage','website');

            return redirect()->to('admin/home'); 


        }


    }
}
