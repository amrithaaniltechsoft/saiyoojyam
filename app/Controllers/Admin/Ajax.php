<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ajax extends BaseController
{
    

    public function RoomTypes(){

        if($this->request->getMethod() === 'POST'){

            $id =  $this->request->getpost('ID');

            $rooms = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $id));

            $data['rooms'] = "<option value='' selected disabled>Select Room Types</option>";

            foreach($rooms as $room){
                
                $data['rooms'] .= "<option value='".$room->room_type_id."'>".$room->room_type_name."</option>";

            }

            echo json_encode($data);
 
        }
    }


    public function tariffRoomTypes(){

        if($this->request->getMethod() === 'POST'){

            $id =  $this->request->getpost('ID');

            $rooms = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $id));

            $data['rooms'] = "<option value='' selected disabled>Select Room Types</option>";

            foreach($rooms as $room){
                
                $data['rooms'] .= "<option value='".$room->room_type_id."'>".$room->room_type_name."</option>";

            }

            echo json_encode($data);
 
        }
    }


    public function tariffRooms(){

        if($this->request->getMethod() === 'POST'){

            $building_id  = $this->request->getPost('building_id');
            $room_type_id = $this->request->getPost('room_type_id');

            $cond = array();
            if(!empty($building_id)){
                $cond['rooms_building'] = $building_id;
            }
            if(!empty($room_type_id)){
                $cond['rooms_type'] = $room_type_id;
            }

            $rooms = $this->common_model->FetchWhereOrderby('saiyoojyam_rooms', $cond, 'rooms_name', 'ASC');

            $options = "<option value='' selected disabled>Select Rooms</option>";

            if(!empty($rooms)){
                foreach($rooms as $room){
                    $options .= "<option value='".$room->rooms_id."'>".$room->rooms_name."</option>";
                }
            }

            $data['rooms'] = $options;

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

            $building     = $this->request->getPost('Build');
            $month        = $this->request->getPost('Month');
            $year         = $this->request->getPost('Year');
            $statusFilter = $this->request->getPost('Status') ?? 'all';

            $inmates = $this->common_model->inmatesBuilding($month, $year, array('inmates_building' => $building), $statusFilter);

            $response['inmates_details'] = "";
            
            if (empty($inmates)) {
                $response['inmates_details'] = "<tr><td colspan='9' class='text-center text-muted py-4'>No inmates found matching the selected criteria.</td></tr>";
                $response['summary'] = ['total' => 0, 'paid' => 0, 'unpaid' => 0, 'partial' => 0, 'advance' => 0];
            } else {
                $sl = 1;
                $totalCount = 0;
                $paidCount = 0;
                $unpaidCount = 0;
                $partialCount = 0;
                $advanceCount = 0;

                foreach($inmates as $inmate){
                    $totalCount++;
                    $statusBadge = '';
                    if ($inmate->payment_status == 1) {
                        $paidCount++;
                        $statusBadge = '<span class="badge" style="background:#eafaf1; color:#2e7d32; padding:5px 10px; border-radius:4px; font-weight:600; border:1px solid #2e7d32;">Paid</span>';
                    } elseif ($inmate->payment_status == 2) {
                        $partialCount++;
                        $statusBadge = '<span class="badge" style="background:#fff3cd; color:#b57f00; padding:5px 10px; border-radius:4px; font-weight:600; border:1px solid #b57f00;">Partial</span>';
                    } elseif ($inmate->payment_status == 3) {
                        $advanceCount++;
                        $statusBadge = '<span class="badge" style="background:#e6f7fb; color:#03c3ec; padding:5px 10px; border-radius:4px; font-weight:600; border:1px solid #03c3ec;">Advance</span>';
                    } else {
                        $unpaidCount++;
                        $statusBadge = '<span class="badge" style="background:#fdecea; color:#c0392b; padding:5px 10px; border-radius:4px; font-weight:600; border:1px solid #c0392b;">Unpaid</span>';
                    }

                    $roomName     = !empty($inmate->rooms_name) ? $inmate->rooms_name : '-';
                    $roomType     = !empty($inmate->room_type_name) ? $inmate->room_type_name : '-';
                    $rent         = number_format((float)$inmate->rent_amount, 2);
                    $paidAmt      = number_format((float)$inmate->paid_amount, 2);
                    $balanceAmt   = number_format((float)$inmate->balance_amount, 2);
                    $phone        = !empty($inmate->inmates_phone_no) ? $inmate->inmates_phone_no : '-';
                    $uid          = !empty($inmate->inmates_uid) ? "<br/><small class='text-muted'>UID: ".$inmate->inmates_uid."</small>" : "";

                    $actionBtn = '<a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'" class="btn btn-sm btn-primary" style="padding:4px 10px; font-size:12px; text-decoration:none;">Receipt / Collect</a>';

                    $response['inmates_details'] .= "<tr>
                        <td class='text-center'>".$sl++."</td>
                        <td><strong>".htmlspecialchars($inmate->inmates_name)."</strong>".$uid."</td>
                        <td>".htmlspecialchars($roomName)." <small class='text-muted'>(".htmlspecialchars($roomType).")</small></td>
                        <td>".htmlspecialchars($phone)."</td>
                        <td class='text-end'>₹".$rent."</td>
                        <td class='text-end text-success'>₹".$paidAmt."</td>
                        <td class='text-end text-danger'>₹".$balanceAmt."</td>
                        <td class='text-center'>".$statusBadge."</td>
                        <td class='text-center'>".$actionBtn."</td>
                    </tr>";
                }

                $response['summary'] = [
                    'total' => $totalCount,
                    'paid' => $paidCount,
                    'unpaid' => $unpaidCount,
                    'partial' => $partialCount,
                    'advance' => $advanceCount
                ];
            }

            echo json_encode($response);
        }
    }


    
}
