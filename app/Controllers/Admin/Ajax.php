<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ajax extends BaseController
{
    

    public function RoomTypes(){

        if($this->request->getMethod() === 'POST'){

            $id =  $this->request->getpost('ID');

            $rooms = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $id));

            $data['rooms'] ="";

            $data['rooms'] .= "<select>
               <option value='' selected disabled>Select Room Types</option>";

               foreach($rooms as $room){
                
                $data['rooms'] .= "<option value=".$room->room_type_id.">".$room->room_type_name."</option>";

               }

            $data['rooms'] .= "</select>";

            echo json_encode($data);
 
        }
    }


    public function tariffRoomTypes(){

        if($this->request->getMethod() === 'POST'){

            $id =  $this->request->getpost('ID');

            

            $rooms = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $id));

            $data['rooms'] ="";

            $data['rooms'] .= "<select>
               <option value='' selected disabled>Select Room Types</option>";

               foreach($rooms as $room){
                
                $data['rooms'] .= "<option value=".$room->room_type_id.">".$room->room_type_name."</option>";

               }

            $data['rooms'] .= "</select>";

            echo json_encode($data);
 
        }
    }


    public function Rooms(){

        if($this->request->getMethod() === 'POST'){
            
            $id =  $this->request->getpost('ID');

            $joins = array(
                array(
                    'table' => 'saiyoojyam_building',
                    'pk'    => 'building_id',
                    'fk'    => 'rooms_building',
                ),
                array(
                    'table' => 'saiyoojyam_room_type',
                    'pk'    => 'room_type_id',
                    'fk'    => 'rooms_type',
                ),
            );

            $rooms = $this->common_model->SingleRowJoin('saiyoojyam_rooms',array('rooms_id' => $id),$joins);
            
            $data['building'] = $rooms->building_name;

            $data['building_id'] = $rooms->building_id ;

            $data['room_type'] = $rooms->room_type_name;

            $data['room_type_id'] = $rooms->room_type_id;

            /*$data['rooms'] ="";

            $data['rooms'] .= "<select>
               <option value='' selected disabled>Select Room </option>";
               foreach($rooms as $room){
                
                 $data['rooms'] .= "<option value=".$room->rooms_id.">".$room->rooms_name."</option>";

               }
            $data['rooms'] .= "</select>";*/

             echo json_encode($data);

        }

    }


    public function RoomFilter(){

        if($this->request->getMethod() === 'POST'){

            $id =  $this->request->getpost('ID');

            $date =  $this->request->getpost('Date');

            $check_out =  $this->request->getpost('Checkout');

            $check_in_date  = date('Y-m-d',strtotime($date)); 

            if(!empty($check_out)){
               
                $check_out_date = date('Y-m-d',strtotime($check_out));

            }else{

                $check_out_date = '0000-00-00';
            }

           
            $rooms = $this->common_model->FetchWhereOrderby('saiyoojyam_rooms', ['rooms_building' => $id], 'rooms_name', 'ASC');

            $available_rooms = [];

            foreach ($rooms as $room) {

                $occupied_count = $this->common_model->CountInmatesInRoomOnDate($room->rooms_id, $check_in_date, $check_out_date,$room->rooms_capacity);

                /*if ($occupied_count) {
                    echo "Room is available";
                } else {
                    echo "Room is FULL";
                }*/

                //if ($occupied_count < $room->rooms_capacity) {
                if ($occupied_count) {
                    
                    $available_rooms[] = [
                        'room_id'   => $room->rooms_id,
                        'room_name' => $room->rooms_name,
                        'capacity'  => $room->rooms_capacity,
                        'occupied'  => $occupied_count,
                        'available' => $room->rooms_capacity - $occupied_count
                    ];
                }
            }

           

            
            $data['rooms'] ="";

            $data['rooms'] .= "<option value='' selected disabled>Select Rooms</option>";
                
                foreach($available_rooms as $room){
                
                    $data['rooms'] .= "<option value=".$room['room_id'].">".$room['room_name']."</option>";

                }
            

             echo json_encode($data);
 

        }


    }


    public function AvaliableRoom(){

        if($this->request->getMethod() === 'POST'){

            $current_date =  $this->request->getpost('Selected_date');

            $rooms = $this->common_model->FetchAllOrder('saiyoojyam_rooms','rooms_id','DESC');

           

            $available_rooms = [];

            foreach($rooms as $room){

                //$occupied_count = $this->common_model->CountInmatesInRoomOnDate($room->rooms_id,$current_date,'',);

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
            
            //print_r($available_rooms); exit();

            $data['rooms'] ='';

            foreach($available_rooms as $room){

                $data['rooms'] .='<div class="room-cell">'.$room['room_name'].'<br><span>'.$room['available'].'Persons</span></div>';

            } 

            //print_r($data['rooms']); exit();

            echo json_encode($data);



        }
    }

    //fetch room type by room_id
    public function FetchRoomTypes(){

        if($this->request->getMethod() === 'POST'){

            $room_id =  $this->request->getpost('ID');

            $rooms = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $room_id));

            $response['room_type'] = $rooms->rooms_type;

             echo json_encode($response);

        }

    } 

    
    //fetch inmates room detail with inmates id
    public function inmatesRooms(){

        if($this->request->getMethod() === 'POST'){

            $inmates_id =  $this->request->getpost('ID');

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

            $inmates = $this->common_model->SingleRowJoin('saiyoojyam_inmates',array('inmates_id' => $inmates_id),$joins);

            $response['inmates_build'] = $inmates->building_name;

            $response['inmates_room_type'] = $inmates->room_type_name;

            $response['inmates_room'] = $inmates->rooms_name;

            echo json_encode($response);

        }


    }


    //check year
    public function checkYear(){

        if($this->request->getMethod() === 'POST'){

            $current_year =  $this->request->getpost('currentYear');

            $date_start = "$current_year-01-01";

            $date_end   = "$current_year-12-31";

            $inmates = $this->common_model->inmatesMonthRent($date_start,$date_end);
            
            $response['year_html'] ="";
            
            $year = "";

            foreach($inmates as $inmate){
               
                $response['year_html'] .="<tr";

                    if($inmate->inmates_status == 'checked_out'){
                        $response['year_html'] .= ' class="row-vacated"';
                    }

                    $response['year_html'] .=">

                    <td>".$inmate->inmates_name."<br/><small class=\"text-muted\">".$inmate->inmates_uid."</small>";
                    if($inmate->inmates_check_out_date == '0000-00-00' || empty($inmate->inmates_check_out_date)){
                        $response['year_html'] .= '<br/><a href="'.base_url().'Admin/Inmates/CheckOut/'.$inmate->inmates_id.'" onclick="return confirm(\'Check out this inmate?\');" style="font-size:12px;color:#fff;background:#e74c3c;padding:2px 8px;border-radius:4px;text-decoration:none;display:inline-block;">Check Out</a>';
                    }
                    $response['year_html'] .="</td>";

                    $invoiceMonths = [];

                    foreach($inmate->invoice as $inv){ 

                        $parts = explode('-', $inv->invoice_payment_month);
                        $month = (int)$parts[1]; 
                        $year  = (int)$parts[0]; 
                        $invoiceMonths[$month] = [
                            'month'  => $inv->invoice_payment_month,
                            'amount' => $inv->invoice_paid_amount,
                            'status' => $inv->invoice_status, 
                        ];

                    }

                    $currentMonth = (int)date('m');

                    $currentYear  = (int)date('Y');

                    $yearToShow = (int)$current_year;

                    $ciDate = strtotime($inmate->inmates_check_in_date);

                    $ciYear = (int)date('Y', $ciDate);

                    $ciMonth = (int)date('m', $ciDate);

                    $upToNow = function($m) use ($yearToShow, $currentYear, $currentMonth){
                        return $yearToShow < $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth);
                    };

                    for ($m = 1; $m <= 12; $m++) {

                        if($yearToShow < $ciYear || ($yearToShow == $ciYear && $m < $ciMonth)){

                            $response['year_html'] .='<td></td>';

                            continue;

                        }

                        if(isset($invoiceMonths[$m])) {


                            if($invoiceMonths[$m]['status'] == 1){
               
                                $response['year_html'] .='<td class="paid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invoiceMonths[$m]['amount'].'</a></td>';

                            }
            
                            elseif($invoiceMonths[$m]['status'] == 2){
                
                                $response['year_html'] .='<td class="partial"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invoiceMonths[$m]['amount'].'</a></td>';
               
                            }
                            elseif($invoiceMonths[$m]['status'] == 3){
                
                                $response['year_html'] .='<td class="advance"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invoiceMonths[$m]['amount'].'</a></td>';
               
                            }
                            else{

                                if($upToNow($m)){

                                    $response['year_html'] .='<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>';

                                }else{

                                    $response['year_html'] .='<td></td>';
                                }
                            }
                          
                        }
                        else{

                            if ($upToNow($m)) {

                                $response['year_html'] .='<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>';

                            }else{

                                $response['year_html'] .='<td></td>';
                            }
                        }

                    }

                $response['year_html'] .="</tr>";

                

            }

            echo json_encode($response);

        } 
        

    }


    public function inmatesDetails(){

        if($this->request->getMethod() === 'POST'){

            $building  =  $this->request->getpost('Build');

            $month     =  $this->request->getpost('Month');

            $year      =  $this->request->getpost('Year');

            $inmates = $this->common_model->inmatesBuilding($month,$year,array('inmates_building' => $building));

            

            $response['inmates_details'] = "";
            
            foreach($inmates as $inmate){

                $response['inmates_details'] .="<tr>
                
                                    <td>".$inmate->inmates_name."</td>
                                    <td class=''>".$inmate->rooms_name."</td>
                                    <td class=''>".date('d-m-Y',strtotime($inmate->inmates_check_in_date))."</td>
                                    <td class=''>".$inmate->inmates_phone_no."</td>
                                    <td class=''>".$inmate->inmates_place_of_work."</td>
                                    <td class=''>".$inmate->room_type_name."</td>
                                    <td class=''>".$inmate->tariffs_price."</td>
                                    <td class=''>".$inmate->inmates_caution_deposit."</td>
                                    <td class=''>".$inmate->inmates_admission_fee."</td>
                                    <td class=''>".$inmate->invoice_total."</td>
                                    <td class=''>---</td>
                                    <td class=''>".$inmate->invoice_paid_amount."</td>
                                    <td class=''>".$inmate->invoice_paid_date."</td>
                                    <td class=''>---</td>
                                    <td class=''>".$inmate->inmates_check_out_date."</td>
                                    <td class=''>---</td>
                                    <td class=''>---</td>
  
                                </tr>";
            }

            echo json_encode($response);
        }


    }


    
}
