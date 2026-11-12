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

            $id =  $this->request->getPost('ID');
            $filterMode = (bool) $this->request->getPost('filter_mode');

            if(!empty($id)){
                $rooms = $this->common_model->FetchWhereOrderby('saiyoojyam_room_type', array('room_type_building_id' => $id), 'room_type_name', 'ASC');
            } else {
                $rooms = $this->common_model->FetchAllOrder('saiyoojyam_room_type', 'room_type_name', 'ASC');
            }

            if ($filterMode) {
                $data['rooms'] = "<option value=''>All Room Types</option>";
            } else {
                $data['rooms'] = "<option value='' selected disabled>Select Room Type</option>";
            }

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
            $filterMode   = (bool) $this->request->getPost('filter_mode');

            $cond = array();
            if(!empty($building_id)){
                $cond['rooms_building'] = $building_id;
            }
            if(!empty($room_type_id)){
                $cond['rooms_type'] = $room_type_id;
            }

            if(!empty($cond)){
                $rooms = $this->common_model->FetchWhereOrderby('saiyoojyam_rooms', $cond, 'rooms_name', 'ASC');
            } else {
                $rooms = $this->common_model->FetchAllOrder('saiyoojyam_rooms', 'rooms_name', 'ASC');
            }

            if ($filterMode) {
                $options = "<option value=''>All Rooms</option>";
            } else {
                $options = "<option value='' selected disabled>Select Rooms</option>";
            }

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

            $check_in_date  = !empty($date) ? date('Y-m-d',strtotime($date)) : date('Y-m-d'); 

            if(!empty($check_out)){
               
                $check_out_date = date('Y-m-d',strtotime($check_out));

            }else{

                $check_out_date = '0000-00-00';
            }

            $rooms = $this->common_model->FetchWhereOrderby('saiyoojyam_rooms', ['rooms_building' => $id], 'rooms_name', 'ASC');

            // Fetch all configured tariffs to filter only rooms that have a tariff added
            $db = \Config\Database::connect();
            $tariffRows = $db->table('saiyoojyam_tariffs')
                ->select('tariffs_rooms, tariffs_building, tariffs_room_types, tariffs_price')
                ->get()
                ->getResult();

            $directTariffRoomIds = [];
            $typeTariffKeys = [];

            foreach ($tariffRows as $tRow) {
                if (!empty($tRow->tariffs_building) && !empty($tRow->tariffs_room_types)) {
                    $typeTariffKeys[$tRow->tariffs_building . '_' . $tRow->tariffs_room_types] = (float)$tRow->tariffs_price;
                }
                if (!empty($tRow->tariffs_rooms)) {
                    $directTariffRoomIds[(int)$tRow->tariffs_rooms] = (float)$tRow->tariffs_price;
                }
            }

            $available_rooms = [];

            foreach ($rooms as $room) {
                // Only show rooms where tariff has been added
                $hasTariff = isset($directTariffRoomIds[(int)$room->rooms_id]) 
                          || isset($typeTariffKeys[$room->rooms_building . '_' . $room->rooms_type]);

                if (!$hasTariff) {
                    continue;
                }

                $occupied_count = $this->common_model->CountInmatesInRoomOnDate($room->rooms_id, $check_in_date, $check_out_date, $room->rooms_capacity);

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

            $data['rooms'] = "";

            if (empty($available_rooms)) {
                $data['rooms'] .= "<option value='' selected disabled>No tariff-configured rooms available</option>";
            } else {
                $data['rooms'] .= "<option value='' selected disabled>Select Rooms</option>";
                foreach($available_rooms as $room){
                    $data['rooms'] .= "<option value='".$room['room_id']."'>".$room['room_name']."</option>";
                }
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

                $data['rooms'] .='<div class="room-cell" data-room-id="'.$room['room_id'].'" style="cursor:pointer;" title="Click to view room & tariff details">'.$room['room_name'].'<br><span>'.$room['available'].' Persons</span></div>';

            } 

            //print_r($data['rooms']); exit();

            echo json_encode($data);



        }
    }

    // Fetch Room Details including Tariffs & Current Inmates for Admin Dashboard
    public function RoomDetails(){

        if($this->request->getMethod() === 'POST'){

            $room_id       = $this->request->getPost('room_id');
            $selected_date = $this->request->getPost('date');
            if(empty($selected_date)){
                $selected_date = date('Y-m-d');
            }

            if(empty($room_id)){
                echo json_encode(['status' => 'error', 'msg' => 'Invalid Room ID']);
                return;
            }

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
                )
            );

            $room = $this->common_model->SingleRowJoin('saiyoojyam_rooms', array('rooms_id' => $room_id), $joins);

            if(!$room){
                echo json_encode(['status' => 'error', 'msg' => 'Room not found']);
                return;
            }

            $occupied_count = $this->common_model->fetchAvaliableRooms($room_id, $selected_date);
            $capacity = (int)$room->rooms_capacity;
            $available_count = max(0, $capacity - $occupied_count);
            $occupancy_pct = $capacity > 0 ? round(($occupied_count / $capacity) * 100) : 0;

            // Tariff for this room: Check room type first, then room ID
            $tariff = null;
            if(!empty($room->rooms_type)){
                $tariff = $this->common_model->SingleRow('saiyoojyam_tariffs', array(
                    'tariffs_room_types' => $room->rooms_type,
                    'tariffs_building'   => $room->rooms_building
                ));
            }
            if(!$tariff){
                $tariff = $this->common_model->SingleRow('saiyoojyam_tariffs', array('tariffs_rooms' => $room_id));
            }

            // Inmates in this room on selected date
            $db = \Config\Database::connect();
            $inmates = $db->table('saiyoojyam_inmates')
                ->select('inmates_id, inmates_uid, inmates_name, inmates_phone_no, inmates_check_in_date, inmates_check_out_date, inmates_status')
                ->where('inmates_rooms', $room_id)
                ->where('inmates_status !=', 'pending')
                ->where('inmates_status !=', 'cancelled')
                ->where('inmates_status !=', 'rejected')
                ->where('inmates_status !=', 'checked_out')
                ->where('inmates_status !=', '')
                ->where('inmates_check_in_date <=', $selected_date)
                ->groupStart()
                    ->where('inmates_check_out_date >', $selected_date)
                    ->orWhere('inmates_check_out_date IS NULL')
                    ->orWhere('inmates_check_out_date', '')
                    ->orWhere('inmates_check_out_date', '0000-00-00')
                ->groupEnd()
                ->orderBy('inmates_name', 'ASC')
                ->get()
                ->getResult();

            $inmates_list = [];
            foreach($inmates as $inm){
                $inmates_list[] = [
                    'id'        => $inm->inmates_id,
                    'uid'       => $inm->inmates_uid,
                    'name'      => $inm->inmates_name,
                    'phone'     => $inm->inmates_phone_no,
                    'check_in'  => !empty($inm->inmates_check_in_date) ? date('d M Y', strtotime($inm->inmates_check_in_date)) : '-',
                    'check_out' => (!empty($inm->inmates_check_out_date) && $inm->inmates_check_out_date != '0000-00-00') ? date('d M Y', strtotime($inm->inmates_check_out_date)) : 'Ongoing',
                    'status'    => ucfirst($inm->inmates_status)
                ];
            }

            $tariff_data = null;
            if(!empty($tariff)){
                $rent = (float)$tariff->tariffs_price;
                $adm  = (float)$tariff->tariffs_admission_fees;
                $dep  = (float)$tariff->tariffs_caution_deposit;

                // Fallback to building admission & caution deposit if not configured in tariff
                if ($adm <= 0 && !empty($room->building_admission_fees)) {
                    $adm = (float)$room->building_admission_fees;
                }
                if ($dep <= 0 && !empty($room->building_caution_deposit)) {
                    $dep = (float)$room->building_caution_deposit;
                }

                $tariff_data = [
                    'id'              => $tariff->tariffs_id,
                    'price'           => number_format($rent, 2),
                    'admission_fees'  => number_format($adm, 2),
                    'caution_deposit' => number_format($dep, 2),
                    'total_initial'   => number_format($rent + $adm + $dep, 2),
                ];
            }

            // Room Features
            $features_list = [];
            if(!empty($room->rooms_features)){
                $feature_ids = array_filter(array_map('trim', explode(',', $room->rooms_features)));
                if(!empty($feature_ids)){
                    $features = $db->table('saiyoojyam_room_feature')
                        ->whereIn('feature_id', $feature_ids)
                        ->get()
                        ->getResult();
                    foreach($features as $feat){
                        $features_list[] = [
                            'id'    => $feat->feature_id,
                            'name'  => $feat->feature_name,
                            'image' => !empty($feat->feature_image) ? base_url('public/uploads/feature/' . $feat->feature_image) : ''
                        ];
                    }
                }
            }

            $response = [
                'status'        => 'success',
                'selected_date' => date('d M Y', strtotime($selected_date)),
                'room' => [
                    'id'            => $room->rooms_id,
                    'name'          => $room->rooms_name,
                    'building_id'   => $room->building_id ?? $room->rooms_building,
                    'building_name' => $room->building_name ?? 'Hostel Building',
                    'type_id'       => $room->rooms_type ?? $room->room_type_id,
                    'type_name'     => $room->room_type_name ?? 'Standard Room',
                    'ac_type'       => ($room->rooms_ac_type === 'AC') ? 'AC' : '',
                    'capacity'      => $capacity,
                    'occupied'      => $occupied_count,
                    'available'     => $available_count,
                    'occupancy_pct' => $occupancy_pct,
                    'description'   => $room->rooms_description ?? '',
                    'features'      => $features_list,
                    'status'        => $room->rooms_status ?? 'available'
                ],
                'tariff'  => $tariff_data,
                'inmates' => $inmates_list
            ];

            return $this->response->setJSON($response);
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
               
                $todayDate = date('Y-m-d');
                $hasCheckout = (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date != '0000-00-00');
                $isFutureCheckout = ($hasCheckout && $inmate->inmates_check_out_date > $todayDate);
                $isCheckedOut = ($inmate->inmates_status === 'checked_out' || ($hasCheckout && $inmate->inmates_check_out_date <= $todayDate));
                $isShortTerm = ((int)($inmate->inmates_duration_of_stay ?? 0) === 1);
                $checkInDate = (!empty($inmate->inmates_check_in_date) && $inmate->inmates_check_in_date != '0000-00-00') ? $inmate->inmates_check_in_date : null;
                $oneMonthDate = (!$isShortTerm && $checkInDate) ? date('Y-m-d', strtotime($checkInDate . ' + 1 month')) : null;
                $canCheckoutToday = $isShortTerm ? (empty($checkInDate) || $todayDate >= $checkInDate) : (empty($oneMonthDate) || ($todayDate >= $oneMonthDate));
                $roomName = !empty($inmate->rooms_name) ? $inmate->rooms_name : (!empty($inmate->inmates_rooms) ? 'Room ' . $inmate->inmates_rooms : 'Assigned Room');
                $coDate = $hasCheckout ? strtotime($inmate->inmates_check_out_date) : 0;
                $coYear = $hasCheckout ? (int)date('Y', $coDate) : 0;
                $coMonth = $hasCheckout ? (int)date('m', $coDate) : 0;

                $response['year_html'] .="<tr";
                if ($isCheckedOut) {
                    $response['year_html'] .= ' class="row-vacated"';
                }
                $response['year_html'] .=">";

                    $checkoutBtnHtml = '';
                    if ($isCheckedOut) {
                        $checkoutBtnHtml = '<br/><span style="font-size:11.5px;color:#dc2626;font-weight:600;"><i class="fa fa-sign-out"></i> Out: ' . date('d-M-Y', strtotime($inmate->inmates_check_out_date)) . '</span>';
                    } elseif ($isFutureCheckout) {
                        $checkoutBtnHtml = '<br/><div style="display:inline-flex;align-items:center;gap:4px;margin-top:3px;">
                            <span style="font-size:11px;background:#e0f2fe;color:#0369a1;padding:2px 6px;border-radius:4px;font-weight:600;" title="Scheduled Upcoming Check Out">
                                <i class="fa fa-calendar-check-o"></i> ' . date('d-M-Y', strtotime($inmate->inmates_check_out_date)) . ' (Upcoming)
                            </span>
                            <button type="button" class="btn-checkout-trigger"
                                data-inmate-id="' . $inmate->inmates_id . '"
                                data-inmate-name="' . htmlspecialchars($inmate->inmates_name, ENT_QUOTES, 'UTF-8') . '"
                                data-inmate-uid="' . htmlspecialchars($inmate->inmates_uid, ENT_QUOTES, 'UTF-8') . '"
                                data-inmate-room="' . htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8') . '"
                                data-is-short-term="' . ($isShortTerm ? '1' : '0') . '"
                                data-checkin-date="' . (!empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-') . '"
                                data-checkin-raw="' . ($inmate->inmates_check_in_date ?? '') . '"
                                data-one-month="' . ($oneMonthDate ?: '') . '"
                                data-one-month-fmt="' . ($oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : '') . '"
                                data-can-today="' . ($canCheckoutToday ? '1' : '0') . '"
                                data-current-checkout="' . $inmate->inmates_check_out_date . '"
                                title="Reschedule departure date"
                                style="border:1px solid #0284c7;background:#fff;color:#0284c7;border-radius:4px;padding:1px 5px;font-size:11px;cursor:pointer;">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </div>';
                    } else {
                        $checkoutBtnHtml = '<br/><button type="button" class="btn-checkout-trigger"
                            data-inmate-id="' . $inmate->inmates_id . '"
                            data-inmate-name="' . htmlspecialchars($inmate->inmates_name, ENT_QUOTES, 'UTF-8') . '"
                            data-inmate-uid="' . htmlspecialchars($inmate->inmates_uid, ENT_QUOTES, 'UTF-8') . '"
                            data-inmate-room="' . htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8') . '"
                            data-is-short-term="' . ($isShortTerm ? '1' : '0') . '"
                            data-checkin-date="' . (!empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-') . '"
                            data-checkin-raw="' . ($inmate->inmates_check_in_date ?? '') . '"
                            data-one-month="' . ($oneMonthDate ?: '') . '"
                            data-one-month-fmt="' . ($oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : '') . '"
                            data-can-today="' . ($canCheckoutToday ? '1' : '0') . '"
                            data-current-checkout=""
                            style="font-size:12px;color:#fff;background:#e74c3c;padding:3px 10px;border-radius:4px;border:none;cursor:pointer;display:inline-block;margin-top:3px;font-weight:500;">
                            <i class="fa fa-sign-out"></i> Check Out
                        </button>';
                    }

                    $response['year_html'] .= "<td><strong>" . htmlspecialchars($inmate->inmates_name) . "</strong><br/><small class=\"text-muted\">" . htmlspecialchars($inmate->inmates_uid) . "</small>" . $checkoutBtnHtml . "</td>";

                    $invoiceMonths = [];

                    foreach($inmate->invoice as $inv){ 

                        $parts = explode('-', $inv->invoice_payment_month);
                        $month = (int)$parts[1]; 
                        $year  = (int)$parts[0]; 
                        $invoiceMonths[$month] = [
                            'month'  => $inv->invoice_payment_month,
                            'amount' => (float)$inv->invoice_paid_amount,
                            'rent'   => (float)$inv->invoice_rent,
                            'status' => (int)$inv->invoice_status, 
                        ];

                    }

                    $currentMonth = (int)date('m');

                    $currentYear  = (int)date('Y');

                    $yearToShow = (int)$current_year;

                    $ciDate = strtotime($inmate->inmates_check_in_date);

                    $ciYear = (int)date('Y', $ciDate);

                    $ciMonth = (int)date('m', $ciDate);

                    $ciDay = (int)date('j', $ciDate);

                    $stayRent = 0.0;
                    if ($ciDay >= 21) {
                        $daysInCiMonth = cal_days_in_month(CAL_GREGORIAN, $ciMonth, $ciYear);
                        $stayDays = $daysInCiMonth - $ciDay + 1;
                        $tariffPrice = !empty($inmate->tariffs_price) ? (float)$inmate->tariffs_price : 0.0;
                        if ($tariffPrice <= 0 && isset($invoiceMonths[$ciMonth + 1])) {
                            $invRent = (float)$invoiceMonths[$ciMonth + 1]['rent'];
                            $tariffPrice = $invRent / (1 + ($stayDays / $daysInCiMonth));
                        }
                        $stayRent = round($stayDays * ($tariffPrice / $daysInCiMonth), 2);
                    }

                    $upToNow = function($m) use ($yearToShow, $currentYear, $currentMonth){
                        return $yearToShow < $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth);
                    };

                    for ($m = 1; $m <= 12; $m++) {

                        if($yearToShow < $ciYear || ($yearToShow == $ciYear && $m < $ciMonth)){

                            $response['year_html'] .='<td></td>';

                            continue;

                        }

                        $invData = null;
                        $cellTitle = '';

                        if ($ciDay >= 21 && $yearToShow == $ciYear && $m == $ciMonth) {
                            $nextM = ($ciMonth == 12) ? 1 : ($ciMonth + 1);
                            if (isset($invoiceMonths[$nextM])) {
                                $invData = [
                                    'amount' => number_format($stayRent, 2, '.', ''),
                                    'status' => $invoiceMonths[$nextM]['status']
                                ];
                                $cellTitle = 'title="Stay Rent: ₹' . number_format($stayRent, 2) . ' (Paid with next month)"';
                            }
                        } elseif ($ciDay >= 21 && $yearToShow == $ciYear && $m == ($ciMonth + 1) && isset($invoiceMonths[$m])) {
                            $inv = $invoiceMonths[$m];
                            $remAmount = max(0, $inv['amount'] - $stayRent);
                            $invData = [
                                'amount' => number_format($remAmount, 2, '.', ''),
                                'status' => $inv['status']
                            ];
                            $cellTitle = 'title="Monthly Rent & Fees: ₹' . number_format($remAmount, 2) . '"';
                        } elseif (isset($invoiceMonths[$m])) {
                            $invData = $invoiceMonths[$m];
                        }

                        $isAfterCheckout = false;
                        if ($hasCheckout && $isCheckedOut) {
                            if ($yearToShow > $coYear || ($yearToShow == $coYear && $m > $coMonth)) {
                                $isAfterCheckout = true;
                            }
                        }

                        if(!empty($invData)) {

                            if($invData['status'] == 1){
               
                                $response['year_html'] .='<td class="paid"><a ' . $cellTitle . ' href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';

                            }
            
                            elseif($invData['status'] == 2){
                
                                $response['year_html'] .='<td class="partial"><a ' . $cellTitle . ' href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';
               
                            }
                            elseif($invData['status'] == 3){
                
                                $response['year_html'] .='<td class="advance"><a ' . $cellTitle . ' href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';
               
                            }
                            else{

                                if ($isAfterCheckout) {
                                    $response['year_html'] .='<td class="vacated" title="Checked Out on ' . date('d-M-Y', $coDate) . '">---</td>';
                                } elseif($upToNow($m)){

                                    $response['year_html'] .='<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>';

                                }else{

                                    $response['year_html'] .='<td></td>';
                                }
                            }
                          
                        }
                        else{

                            if ($isAfterCheckout) {
                                $response['year_html'] .='<td class="vacated" title="Checked Out on ' . date('d-M-Y', $coDate) . '">---</td>';
                            } elseif ($upToNow($m)) {

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

            $cond = [];
            if (!empty($building) && $building !== 'all') {
                $cond['saiyoojyam_inmates.inmates_building'] = $building;
            }

            $inmates = $this->common_model->inmatesBuilding($month, $year, $cond, $statusFilter);

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

                    $todayDate = date('Y-m-d');
                    $hasCheckout = (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date != '0000-00-00');
                    $isFutureCheckout = ($hasCheckout && $inmate->inmates_check_out_date > $todayDate);
                    $isCheckedOut = ($inmate->inmates_status === 'checked_out' || ($hasCheckout && $inmate->inmates_check_out_date <= $todayDate));
                    $isShortTerm = ((int)($inmate->inmates_duration_of_stay ?? 0) === 1);
                    $checkInDate = (!empty($inmate->inmates_check_in_date) && $inmate->inmates_check_in_date != '0000-00-00') ? $inmate->inmates_check_in_date : null;
                    $oneMonthDate = (!$isShortTerm && $checkInDate) ? date('Y-m-d', strtotime($checkInDate . ' + 1 month')) : null;
                    $canCheckoutToday = $isShortTerm ? (empty($checkInDate) || $todayDate >= $checkInDate) : (empty($oneMonthDate) || ($todayDate >= $oneMonthDate));

                    $statusBadge = '';
                    if ($isCheckedOut) {
                        $statusBadge = '<span class="badge" style="background:#e2e8f0; color:#334155; padding:6px 13px; border-radius:50px; font-weight:700; border:1px solid #94a3b8; font-size:11.5px;"><i class="fa fa-sign-out me-1"></i> Checked Out</span>';
                    } elseif ($inmate->payment_status == 1) {
                        $paidCount++;
                        $statusBadge = '<span class="badge" style="background:#dcfce7; color:#15803d; padding:6px 13px; border-radius:50px; font-weight:700; border:1px solid #86efac; font-size:11.5px;"><i class="fa fa-check-circle me-1"></i> Paid</span>';
                    } elseif ($inmate->payment_status == 2) {
                        $partialCount++;
                        $statusBadge = '<span class="badge" style="background:#fef9c3; color:#a16207; padding:6px 13px; border-radius:50px; font-weight:700; border:1px solid #fde047; font-size:11.5px;"><i class="fa fa-clock-o me-1"></i> Partial</span>';
                    } elseif ($inmate->payment_status == 3) {
                        $advanceCount++;
                        $statusBadge = '<span class="badge" style="background:#e0f2fe; color:#0369a1; padding:6px 13px; border-radius:50px; font-weight:700; border:1px solid #7dd3fc; font-size:11.5px;"><i class="fa fa-rocket me-1"></i> Advance</span>';
                    } else {
                        $unpaidCount++;
                        $statusBadge = '<span class="badge" style="background:#fee2e2; color:#b91c1c; padding:6px 13px; border-radius:50px; font-weight:700; border:1px solid #fca5a5; font-size:11.5px;"><i class="fa fa-exclamation-circle me-1"></i> Unpaid</span>';
                    }

                    $roomName     = !empty($inmate->rooms_name) ? $inmate->rooms_name : (!empty($inmate->inmates_rooms) ? 'Room ' . $inmate->inmates_rooms : '-');
                    $roomType     = !empty($inmate->room_type_name) ? $inmate->room_type_name : '-';
                    $rent         = number_format((float)$inmate->rent_amount, 2);
                    $paidAmt      = number_format((float)$inmate->paid_amount, 2);
                    $balanceAmt   = number_format((float)$inmate->balance_amount, 2);
                    $phone        = !empty($inmate->inmates_phone_no) ? $inmate->inmates_phone_no : '-';
                    $uid          = !empty($inmate->inmates_uid) ? "<br/><small class='text-muted font-monospace'>UID: ".$inmate->inmates_uid."</small>" : "";
                    $bldLabel     = !empty($inmate->building_name) ? "<br/><small class='text-muted'><i class='fa fa-building-o'></i> " . htmlspecialchars($inmate->building_name) . "</small>" : "";

                    $checkoutBtn = '';
                    if ($isCheckedOut) {
                        $checkoutBtn = '<span style="font-size:11px;color:#dc2626;font-weight:600;display:block;margin-top:3px;"><i class="fa fa-sign-out"></i> Out: ' . date('d-M-Y', strtotime($inmate->inmates_check_out_date)) . '</span>';
                    } elseif ($isFutureCheckout) {
                        $checkoutBtn = '<div style="display:inline-flex;align-items:center;gap:3px;margin-top:3px;">
                            <span style="font-size:10.5px;background:#e0f2fe;color:#0369a1;padding:2px 6px;border-radius:5px;font-weight:600;border:1px solid #bae6fd;" title="Scheduled Upcoming Check Out">
                                <i class="fa fa-calendar-check-o"></i> ' . date('d-M-Y', strtotime($inmate->inmates_check_out_date)) . '
                            </span>
                            <button type="button" class="btn-checkout-trigger"
                                data-inmate-id="' . $inmate->inmates_id . '"
                                data-inmate-name="' . htmlspecialchars($inmate->inmates_name, ENT_QUOTES, 'UTF-8') . '"
                                data-inmate-uid="' . htmlspecialchars($inmate->inmates_uid, ENT_QUOTES, 'UTF-8') . '"
                                data-inmate-room="' . htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8') . '"
                                data-is-short-term="' . ($isShortTerm ? '1' : '0') . '"
                                data-checkin-date="' . (!empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-') . '"
                                data-checkin-raw="' . ($inmate->inmates_check_in_date ?? '') . '"
                                data-one-month="' . ($oneMonthDate ?: '') . '"
                                data-one-month-fmt="' . ($oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : '') . '"
                                data-can-today="' . ($canCheckoutToday ? '1' : '0') . '"
                                data-current-checkout="' . $inmate->inmates_check_out_date . '"
                                title="Reschedule departure date"
                                style="border:1px solid #0284c7;background:#fff;color:#0284c7;border-radius:4px;padding:1px 5px;font-size:10px;cursor:pointer;">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </div>';
                    } else {
                        $checkoutBtn = '<button type="button" class="btn-checkout-trigger"
                            data-inmate-id="' . $inmate->inmates_id . '"
                            data-inmate-name="' . htmlspecialchars($inmate->inmates_name, ENT_QUOTES, 'UTF-8') . '"
                            data-inmate-uid="' . htmlspecialchars($inmate->inmates_uid, ENT_QUOTES, 'UTF-8') . '"
                            data-inmate-room="' . htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8') . '"
                            data-is-short-term="' . ($isShortTerm ? '1' : '0') . '"
                            data-checkin-date="' . (!empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-') . '"
                            data-checkin-raw="' . ($inmate->inmates_check_in_date ?? '') . '"
                            data-one-month="' . ($oneMonthDate ?: '') . '"
                            data-one-month-fmt="' . ($oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : '') . '"
                            data-can-today="' . ($canCheckoutToday ? '1' : '0') . '"
                            data-current-checkout=""
                            style="padding:3px 9px; font-size:11px; margin-top:3px; display:inline-block; background:#dc2626; color:#fff; border:none; border-radius:5px; cursor:pointer; font-weight:600;">
                            <i class="fa fa-sign-out"></i> Check Out
                        </button>';
                    }

                    $actionBtn = '<div style="display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'" class="btn btn-sm" style="background:#ff561c; color:#fff; padding:4px 12px; font-size:11.5px; font-weight:600; border-radius:6px; text-decoration:none; box-shadow:0 2px 6px rgba(255,86,28,0.2);"><i class="fa fa-file-text-o me-1"></i> Receipt</a>
                        ' . $checkoutBtn . '
                    </div>';

                    $rowVacatedClass = $isCheckedOut ? " class='row-vacated'" : "";
                    $response['inmates_details'] .= "<tr" . $rowVacatedClass . ">
                        <td class='text-center'>".$sl++."</td>
                        <td><strong>".htmlspecialchars($inmate->inmates_name)."</strong>".$uid."</td>
                        <td>".htmlspecialchars($roomName)." <small class='text-muted'>(".htmlspecialchars($roomType).")</small>".$bldLabel."</td>
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

            return $this->response->setJSON($response);
        }
    }


    
}
