<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use \Mpdf\Mpdf;

use DateTime;

class Inmates extends BaseController
{
    public function index(){

        $data['pagedata'] = $this->common_model->FetchAllOrder('saiyoojyam_inmates','inmates_id','ASC');

        $data['rooms_data'] = $this->common_model->FetchAll('saiyoojyam_rooms');

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        
        return view('admin/view_inmates',$data);
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
            
            
            $data = [
                
                'inmates_name'             => $this->request->getPost('inmates_name'),
                'inmates_age'              => $this->request->getPost('inmates_age'),
                'inmates_building'         => $this->request->getPost('inmates_building'),
                'inmates_room_type'        => $this->request->getPost('inmates_room_type'),
                'inmates_rooms'            => $this->request->getPost('inmates_rooms'),
                'inmates_check_in_date'    => date('Y-m-d',strtotime($check_in_date)),
                'inmates_check_out_date'   => date('Y-m-d',strtotime($check_out_date)),
                'inmates_duration_of_stay' => $this->request->getPost('inmates_duration_of_stay'),
                'inmates_phone_no'         => $this->request->getPost('inmates_phone_no'),
                'inmates_whats_app_number' => $this->request->getPost('inmates_whats_app_number'),
                'inmates_guardian_name'    => $this->request->getPost('inmates_guardian_name'),
                'inmates_relation'         => $this->request->getPost('inmates_relation'),
                'inmates_guardian_contact' => $this->request->getPost('inmates_guardian_contact'),
                'inmates_id_proof'         => $idProofName,
                'inmates_photo'            => $photoName,
                'inmates_place_of_work'    => $this->request->getPost('place_of_work'),
                'inmates_created_at'       => date('Y-m-d'),
            ]; 

            

    

            $id = $this->common_model->InsertData('saiyoojyam_inmates',$data);

            $inmates_id = new_booking_id($id, 'IN');

            $this->common_model->EditData(array('inmates_uid' =>  $inmates_id),array('inmates_id' => $id),'saiyoojyam_inmates');


            $response['status'] = true;
            $response['msg'] = 'Data Added Successfully';

            echo json_encode($response);
            return;
        
        }

        $data['duration'] = $this->common_model->FetchAllOrder('saiyoojyam_duration_of_stay','duration_stay','ASC');

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        return view('admin/add_inmates',$data);
    }
    


    public function Receipt($id){
        
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

        $data['tariffs'] = $this->common_model->CheckTwiceCond('saiyoojyam_tariffs',array('tariffs_building' => $data['inmates']->inmates_building),array('tariffs_rooms' => $data['inmates']->inmates_rooms));
        
        if(empty($data['tariffs'])){

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Please Add Tariffs',
            );

            $this->session->setFlashdata('alert',$flashdata);


            return redirect()->to(site_url().'Admin/Inmates');


        }

        $data['invoices'] = $this->common_model->FetchWhereOrderby('saiyoojyam_invoice',['invoice_inmates' => $id],'invoice_payment_month','DESC');
        
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

               
                $data['payment_month'] = $data['inmates']->inmates_check_in_date;

                $year = date('Y', strtotime($data['payment_month']));

                $month = date('m', strtotime($data['payment_month']));

                $days_in_a_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            
                //$monthly_rent = $data['tariffs']->tariffs_price * $days_in_a_month;

                $monthly_rent = $data['tariffs']->tariffs_price;

                $total_rent_month  = $monthly_rent + $data['tariffs']->tariffs_caution_deposit + $data['tariffs']->tariffs_admission_fees;

                $data['total_rent_month'] = number_format($total_rent_month, 2, '.', ',');

            }

        }else{
           

            if($data['last_paid_amount']!=$check_date){

                $date = new \DateTime($data['last_paid_amount']);

                $final = $date->modify('+1 month');

                $data['payment_month'] = $final->format('Y-m-1');

               

                $year = date('Y', strtotime($data['payment_month']));

                $month = date('m', strtotime($data['payment_month']));

                $days_in_a_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);

                //$monthly_rent = $data['tariffs']->tariffs_price * $days_in_a_month;
                
                $monthly_rent = $data['tariffs']->tariffs_price;

                //second month rent calculate

                if($invoice_count == 1){

                    $parts = explode('-',$data['inmates']->inmates_check_in_date);

                    $day = $parts[2];

                    if($day > 5){

                        //$stay_days = 30 - ($day - 1);

                        $stay_days =  30 - $day + 1;

                        //print_r($stay_days); exit();

                        $per_day   = $monthly_rent / 30;

                        $monthly_rent = round($stay_days * $per_day, 2);

                    }

                }

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


        return view('admin/view_receipt',$data);
    }


    public function AddReceipt(){

        if ($this->request->getMethod() === 'POST') {

            $current_date = date('Y-m-d');

            $single_invoice = $this->common_model->SingleRow('saiyoojyam_invoice',array('invoice_inmates' => $this->request->getPost('inmates_id')));

            $inmates = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $this->request->getPost('inmates_id')));

            // check first payment or not
            if(empty($single_invoice)){
                
                
                $payment_month = date('Y-m-01', strtotime($inmates->inmates_check_in_date));

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


                if (!empty($last_paid_amount)) {

                    $date = new \DateTime($last_paid_amount); 
                    $final = $date->modify('+1 month');
                    $payment_month = $final->format('Y-m-1');
 
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
               
                if($last_paid_amount1 == $check_date){

                    $response['payment'] = 1;
                     
                    $response['payment_month1'] = "";

                    $response['rent_per_day'] = "";

                    $response['monthly rent'] = "";

                }
                else{

                    $oldDate = $inmates->inmates_check_out_date;

                    $date = new DateTime($oldDate);

                    $date->setDate($date->format('Y'), $date->format('m'), 01);

                    $newCheckDate = $date->format('Y-m-d');


                    if($last_paid_amount1 == $newCheckDate){

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

                        
                        $inmates = $this->common_model->SingleRow('saiyoojyam_tariffs',array('tariffs_rooms' => $inmates->inmates_rooms));

                        $response['payment_month1'] = date('M-Y',strtotime($payment_month1));

                        $response['rent_per_day'] = $inmates->tariffs_price;

                        //$monthly_rent = $inmates->tariffs_price * $days_in_a_month;

                        $monthly_rent = $inmates->tariffs_price;
                        
                        //check invoice count
                        $invoice_count =  $this->common_model->checkWhereCount('saiyoojyam_invoice',array('invoice_inmates' => $this->request->getPost('inmates_id')));

                        if($invoice_count == 1){

                            $inmates_details = $this->common_model->SingleRow('saiyoojyam_inmates',array('inmates_id' => $this->request->getPost('inmates_id')));

                            $parts = explode('-',$inmates_details->inmates_check_in_date);

                            $day = $parts[2];

                            if($day > 5){
    
                                //$stay_days = 30 - ($day - 1);

                                $stay_days =  30 - $day + 1;
                                
                                //print_r($stay_days); exit();

                                $per_day   = $monthly_rent / 30;

                                $monthly_rent = round($stay_days * $per_day, 2);

                            }

                        }


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

            foreach($invoices as $invoice){

                $response['payment_data'] .= "<tr>
                        <td>".date('M-Y',strtotime($invoice->invoice_payment_month))."</td>
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


    public function Print()
    {
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        // Dynamic data
        $guestName = 'Athira Raj';
        $joinDate = '2025-06-01';
        $paymentMonth = '2025-06-01';
        $building = 'Block A';
        $room = 'Room 101';
        $rentPerDay = 700;
        $rentPerMonth = 21000;
        $logo = base_url('assets/admin/img/logo.png');

        $html = '
    <html>
    <head><meta charset="utf-8"></head>
    <body style="font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #2c3e50;">

    <!-- FULL BORDER WRAPPER -->
    <div style="border: 1px solid #ddd; padding: 20px; height: 100%; box-sizing: border-box;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $logo . '" style="height: 50px; margin-bottom: 8px;">
            <h2 style="margin: 4px 0; font-size: 20px;">Saiyoojyam Ladies Hostel</h2>
            <div style="font-size: 11px; color: #555;">
                Prathibha Layout, Second Cross Road,<br>
                Block Panchayath Office Road, Kusumagiri P.O, Kakkanad, Kochi<br>
                +91 98765 43210 | +91 99887 77665
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #aaa; margin-bottom: 20px;">

        <!-- Title -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px; text-transform: uppercase;">INVOICE</h3>
        </div>

        <!-- Personal Info -->
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; background-color: #f9f9f9;">
            <h4 style="margin: 0 0 10px; font-size: 14px;">Personal Details</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 5px; width: 35%; font-weight: bold;">Name</td>
                    <td style="padding: 5px;">' . $guestName . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px; font-weight: bold;">Join Date</td>
                    <td style="padding: 5px;">' . date('d M Y', strtotime($joinDate)) . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px; font-weight: bold;">Payment Month</td>
                    <td style="padding: 5px;">' . date('F Y', strtotime($paymentMonth)) . '</td>
                </tr>
            </table>
        </div>

        <!-- Room Info -->
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; background-color: #fdfdfd;">
            <h4 style="margin: 0 0 10px; font-size: 14px;">Room Details</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 5px; width: 35%; font-weight: bold;">Building</td>
                    <td style="padding: 5px;">' . $building . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px; font-weight: bold;">Room</td>
                    <td style="padding: 5px;">' . $room . '</td>
                </tr>
            </table>
        </div>

        <!-- Rent Info -->
        <div style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">
            <h4 style="margin: 0 0 10px; font-size: 14px;">Rent Details</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 5px; width: 35%; font-weight: bold;">Rent Per Day</td>
                    <td style="padding: 5px;">₹' . number_format($rentPerDay, 2) . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px; font-weight: bold;">Total Rent (Per Month)</td>
                    <td style="padding: 5px; font-weight: bold;">₹' . number_format($rentPerMonth, 2) . '</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div style="text-align: center; font-size: 12px; color: #666; margin-top: 30px;">
            <p>Thank you for staying with us.</p>
            <p>For queries, contact the hostel office.</p>
        </div>

    </div> <!-- End border wrapper -->

    </body>
    </html>';

        $mpdf->WriteHTML($html);

        return $this->response
            ->setContentType('application/pdf')
            ->setBody($mpdf->Output('invoice.pdf', 'S'));
    }


   
}
