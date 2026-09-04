<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class CommonModel extends Model
{
    protected $db;

  

    //Admin Authentication

    public function GetProfile($username,$password)
    {
        return $this->db
        ->table('users')
        ->where(['user_name'=>$username])
        ->where(['user_password'=>$password])
        ->get()
        ->getRow();
    }




    // add data
    public function InsertData($table, $data)
    {
        $inserted = $this->db->table($table)->insert($data);

        if (!$inserted) 
        {
            // Handle the error
            $error = $this->db->error();
            return $error; // or throw an exception, log the error, etc.
        }

        return $this->db->insertID();
    }


    
    //Edit Data 

    public function EditData($data,$cond,$table)
    {

        return $this->db
        ->table($table)
        ->where($cond)
        ->set($data)
        ->update();

    }


    //Delete Data

    public function DeleteData($table,$cond)
    {
        $this->db
        ->table($table)
        ->where($cond)
        ->delete();
    }




    //Fetch Single 

    public function SingleRowCol($table,$col,$cond)
    {
        return $this->db
        ->table($table)
        ->select($col)
        ->where($cond)
        ->get()
        ->getRow();
    }

    public function SingleRow($table,$cond)
    {
        return $this->db
        ->table($table)
        ->where($cond)
        ->get()
        ->getRow();
    }

    public function SingleRowArray($table,$cond)
    {
        return $this->db
        ->table($table)
        ->where($cond)
        ->get()
        ->getRowArray();
    }


    public function SingleRowJoin($table,$cond,$joins)
    {
        $query= $this->db->table($table)
        ->where($cond);

        if(!empty($joins))
        foreach($joins as $join)
    {
        $table2 = $table;
        if(!empty($join['table2']))
        {
        $table2 = $join['table2'];
        }
        $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table2.'.'.$join['fk'].'', 'left');
    }

        $result = $query->get()->getRow();

        return $result;

    }



    public function SingleRowAliasJoin($table,$cond,$joins)
    {
        $query= $this->db->table($table)
        ->where($cond);

        if(!empty($joins))
        foreach($joins as $join)
    {
        $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table.'.'.$join['fk'].'', 'left');
    }

        $result = $query->get()->getRow();

        return $result;

    }



    public function CountWhere($table,$cond)
    {
        $query = $this->db->table($table);
        if($cond!="")
        {
        $query->where($cond);
        }
        return $query->get()->getNumRows();

    }


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
    //Fetch Where

    public function FetchWhere($table,$cond)
    {
        $query = $this->db->table($table)
        ->where($cond)
        ->get();
        return $query->getResult();

    }


    //Fetch Sum Of Coloumn Where


    public function FetchSum($table,$column,$cond="")
    {
        $query = $this->db->table($table);

        $query->selectSum($column);

        if($cond !="")
        {
        $query->where($cond);
        }

        $result = $query->get()->getRow();

        return $result->$column;
        
    }



    public function FetchMax($table,$column,$cond="")
    {

        $query = $this->db->table($table);

        $query->selectMax($column);

        if($cond !="")
        {
            $query->where($cond);
        }

        $result = $query->get()->getRow();

        return $result->$column;

    }



    



    //Fetch where Join
    public function FetchWhereJoin($table,$cond,$joins)
    {
        $query = $this->db->table($table);


        if(!empty($joins))

        foreach($joins as $join)
        {
            $table2 = $table;
            if(!empty($join['table2']))
            {
            $table2 = $join['table2'];
            }
            $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table2.'.'.$join['fk'].'', 'left');
        }

        $query->where($cond);
       
        $result = $query->get()->getResult();
        //echo $this->db->getLastQuery(); exit();

        return $result;

    }
    
    //Fetch where limit
    public function FetchWhereLimit($id,$coloum_id,$order_key,$order,$table,$end,$start)
    {
        return $this->db
        ->table($table)
        ->select('*')
        ->where($coloum_id,$id)
        ->limit($end,$start)
        ->orderBy($order_key,$order)
        ->get()
        ->getRow();
    }



    public function FetchWhereArrayLimit($table,$order_key,$order,$where,$end,$start)
    {
        
        $query = $this->db->table($table);

        $query->select('*');
        
        if($where!="")
        {
        $query->where($where);
        }

        $query->limit($end,$start)->orderBy($order_key,$order);

        return $query->get()->getResult(); 

    }



    //Fetch All 

    public function FetchAll($table)
    {
        return $this->db
        ->table($table)
        ->get()
        ->getResult();    
    }



    //Fetch All By Order

    public function FetchAllOrder($table,$order_key,$order)
    {

        return $this->db
        ->table($table)
        ->select('*')
        ->orderBy($order_key, $order)
        ->get()
        ->getResult();
    }


    public function FetchAllOrderLimit($table,$order_key,$order,$end,$start)
    {

        return $this->db
        ->table($table)
        ->select('*')
        ->limit($end,$start)
        ->orderBy($order_key, $order)
        ->get()
        ->getResult();
    }



    //For Select 2 Dropdown

    public function FetchAllLimit($table,$order_key,$order,$term,$end,$start)
    {
      
        return $this->db
        ->table($table)
        ->select('*')
        ->like($order_key,$term)
        ->limit($end,$start)
        ->orderBy($order_key, $order)
        ->get()
        ->getResult();
        
    }

    public function FetchAllLimitData($table, $order_key, $order, $term, $start, $end, $whereColumn1, $whereColumn2)
    {
        $query =  $this->db
            ->table($table)
            ->select('*')
            ->groupStart() 
                ->where($whereColumn1)
                ->orWhere($whereColumn2) 
            ->groupEnd() 
            ->like($order_key, $term)
            ->limit($end, $start) 
            ->orderBy($order_key, $order);
            $results = $query->get()->getResult();
            return $results;
    }

    


    // create slug
    public function createSlug($name,$slug_name,$table)
    {
        helper('text'); // Load the text helper for url_title function
      
        $slug = url_title(strtolower($name), '-', true);
        
        $count = 0;
        $temp_slug = $slug;
        
        while (true) 
        {
           
            $query = $this->db
               ->table($table) 
               ->where([$slug_name =>$temp_slug])
                ->get();
                  

            if ($query->getNumRows() == 0) {
                break;
            }

            $count++;
            $temp_slug = $slug . '-' . $count;
        }
        
        return $temp_slug;
    }


    //change slug

    public function ChangeSlug($name,$id,$id_name,$slug_name,$table)
    {   
        $count = 0;
        $name = url_title($name, '-', true); // Convert spaces to dashes
        $slug_data = $name; // Create temp name
        while (true) {
            $query = $this->db->table($table)
                              ->select('*')
                              ->where($slug_name, $slug_data)
                              ->where(''.$id_name.' !=', $id) // Test temp name
                              ->get();
    
            if ($query->getNumRows() == 0) {
                break;
            }
    
            $slug_data = $name . '-' . (++$count); // Recreate new temp name
        }
        
        return $slug_data;
    }


  

    //check data alread in table

    public function CheckData($table,$coloum1,$data1)
    {
        return $this->db
        ->table($table)
        ->where($coloum1,$data1)
        ->get()
        ->getResult();
    }

    //check data alread in table expect select one
    
    public function CheckDataWhere($table,$coloum1,$data1,$id,$id_coloum)
    {
       return $this->db
       //$this->db
        ->table($table)
        ->whereNotIn($id_coloum,(array)$id)
        ->where($coloum1,$data1)
        ->get()
        //echo $this->db->getLastQuery();
        //exit();
        ->getResult();
    }
          

   
 
    /*fetch enquiry in quot*/



    public function CheckTwiceCond($table,$cond1,$cond2)
    {
        $query = $this->db->table($table)
        
        ->select('*')

        ->where($cond1)

        ->where($cond2)

        ->get();

        return $query->getRow();
 
    }



    public function CheckTwiceCond1($table,$cond1,$cond2)
    {
        $query = $this->db->table($table)
        
        ->select('*')

        ->where($cond1)

        ->where($cond2)

        ->get();

       
        return $query->getResult();
 
    }


    public function CheckTwiceCondJoin1($table, $cond1, $cond2, $joins)
    {
        $query = $this->db->table($table)
            ->select('*')
            ->where($cond1)
            ->where($cond2);

        if (!empty($joins)) {
            foreach ($joins as $join) {
                $table2 = $table;
                if (!empty($join['table2'])) {
                    $table2 = $join['table2'];
                }

                $query->join($join['table'], "{$join['table']}.{$join['pk']} = {$table2}.{$join['fk']}", 'left');
            }
        }

        $query = $query->get(); // Move get() outside the loop

        return $query->getResult();
    }


    public function TwiceCondWithJoin($table,$cond1,$cond2,$joins)
    {
        $query = $this->db->table($table)
        
        ->select('*')

        ->where($cond1)

        ->where($cond2);

        if(!empty($joins))
			
        foreach($joins as $join)
        {
            $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table.'.'.$join['fk'].'', 'left');
        }


        $result = $query->get()->getResult();

        return $result;
 
    }


    public function TwiceCondWithNot($table,$cond1,$cond2,$joins,$id_coloum,$id)
    {
        $query = $this->db->table($table)
        
        ->select('*')

        ->whereNotIn($id_coloum,(array)$id)

        ->where($cond1)

        ->where($cond2);

        if(!empty($joins))
			
        foreach($joins as $join)
        {
            $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table.'.'.$join['fk'].'', 'left');
        }

        $result = $query->get()->getRow();

        echo $this->db->getLastQuery();

        exit();


        //return $query->getRow();
    }




    public function FetchDataByGroup($table, $groupBy, $cond, $cond2, $joins)
    {
        $query = $this->db->table($table)
            ->select('*')
            ->where($cond);

        if (!empty($cond2)) {
            $query->where($cond2);
        }

        $query->groupBy($groupBy);

        if (!empty($joins)) {
            foreach ($joins as $join) {
                $query->join($join['table'], '' . $join['table'] . '.' . $join['pk'] . ' = ' . $table . '.' . $join['fk'], 'left');
            }
        }

        $result = $query->get()->getResult();
      
        return $result;
    }


     public function CheckTwiceCondCount($table,$cond1,$cond2)
    {
        $query = $this->db->table($table)
        
        ->select('COUNT(*) as total')

        ->where($cond1)

        ->where($cond2)

        ->get();

        $row = $query->getRow();
		
        $result = $row->total;

        //echo $this->db->getLastQuery(); exit();

        return $result;

    }





    public function checkWhereCount($table,$cond){


        $query = $this->db->table($table)
        
        ->select('COUNT(*) as total')

        ->where($cond)
        
        ->get();

        $row = $query->getRow();
		
        $result = $row->total;

        return $result;

    }


    public function CountInmatesInRoomOnDate($room_id,$new_check_in,$new_check_out,$capacity)
    {
        
        if (empty($new_check_out) || $new_check_out === '0000-00-00') {

            $new_check_out = '9999-12-31';
        }

        $builder = $this->db->table('saiyoojyam_inmates')
            ->where('inmates_rooms', $room_id)
            ->groupStart()
            
                ->where('inmates_check_in_date <', $new_check_out)
                ->groupStart()
                    ->where('inmates_check_out_date >', $new_check_in)
                    ->orWhere('inmates_check_out_date IS NULL')
                    ->orWhere('inmates_check_out_date', '')
                    ->orWhere('inmates_check_out_date', '0000-00-00')
                ->groupEnd()
            ->groupEnd();

        $count = $builder->countAllResults();

        return $count < $capacity; 
  
    }


    //fetch lastpayment month
    public function last_payment_month($table,$inmates_id){
        
        $query = $this->db->table($table);
        $query->selectMax('invoice_payment_month', 'last_paid_month');
        $query->where('invoice_inmates', $inmates_id);
        $result = $query->get()->getRow();
        return $result->last_paid_month;


    }


    //fetchwhereorderby
    public function FetchWhereOrderby($table,$cond,$order_key,$order,$escape = true){

        $query = $this->db->table($table)
        ->where($cond)
        ->orderBy($order_key, $order,$escape)
        ->get();
        //echo $this->db->getLastQuery(); exit();
        return $query->getResult();


    }


    //fetch total inmates
    public function FetchTotalInmates(){
        $date = date('Y-m-d');
        return $this->db->table('saiyoojyam_inmates')
        ->where('inmates_check_in_date <=', $date)
        ->groupStart()
            ->where('inmates_check_out_date >=', $date)
            ->orWhere('inmates_check_out_date IS NULL')
            ->orWhere('inmates_check_out_date', '')
        ->groupEnd()
        ->countAllResults();

    }


    public function FetchJoins($table,$order_key,$order,$joins){
        
        $query = $this->db->table($table)

        ->orderBy($order_key, $order);

        if(!empty($joins))

        foreach($joins as $join)
        {
            $table2 = $table;
            if(!empty($join['table2']))
            {
            $table2 = $join['table2'];
            }
            $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table2.'.'.$join['fk'].'', 'left');
        }

        
       
        $result = $query->get()->getResult();
       

        return $result;


    }


    public function CategoryProduct(){

        $query = $this->db->table('saiyoojyam_building')
        ->select('*')
        ->orderBy('building_id', 'DESC');
        $result = $query->get()->getResult();

        //return $result;

        $i = 0;
        foreach ($result as $res) {
            $cond_user = ['gallery_category' => $res->building_id];
            $result[$i]->cat_gallery = $this->FetchWhere('saiyoojyam_gallery',$cond_user);
            $i++;
        }

        return $result;
        
    }


    public function RoomCategory(){

        $query = $this->db->table('saiyoojyam_building')
        ->select('*')
        ->orderBy('building_id', 'DESC');
        $result = $query->get()->getResult();

        //return $result;

        $joins = array(

            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'rooms_type',
            ),
         
        );

        $i = 0;
        foreach ($result as $res) {

            $cond_user = ['rooms_building' => $res->building_id];
            $result[$i]->build_rooms = $this->FetchWhereJoin('saiyoojyam_rooms',$cond_user,$joins);
            $i++;

        }

        return $result;
        


    }


  


    /*public function CountInmatesInRoomBetweenDates($room_id, $from_date, $to_date)
    {
        return $this->db->table('saiyoojyam_inmates')
        ->where('inmates_rooms', $room_id)
        ->groupStart()
            // Case 1: inmates who have not checked out yet
            ->groupStart()
                ->where('inmates_check_out_date', '')
                ->orWhere('inmates_check_out_date IS NULL')
                ->orWhere('inmates_check_out_date', '0000-00-00')
            ->groupEnd()
            ->orGroupStart()
                // Case 2: overlap check: (inmate_in <= to_date AND inmate_out >= from_date)
                ->where('inmates_check_in_date <=', $to_date)
                ->where('inmates_check_out_date >=', $from_date)
            ->groupEnd()
        ->groupEnd()
        ->countAllResults();
    }*/


    /*public function CountInmatesInRoomBetweenDates($room_id, $check_in_date, $check_out_date = null){
        
        $builder = $this->db->table('saiyoojyam_inmates')
        ->where('inmates_rooms', $room_id)
        ->groupStart();

        if ($check_out_date) {
            // Check-in + check-out provided
            $builder->groupStart()
                ->groupStart()
                    ->where('inmates_check_out_date', '')
                    ->orWhere('inmates_check_out_date', null)
                    ->orWhere('inmates_check_out_date', '0000-00-00')
                ->groupEnd()
                ->where('inmates_check_in_date <=', $check_out_date)
            ->groupEnd()

            ->orGroupStart()
                ->where('inmates_check_in_date <=', $check_out_date)
                ->where('inmates_check_out_date >=', $check_in_date)
            ->groupEnd();
        } 
        else 
        {
            // Only check-in provided
            $builder->groupStart()
                ->groupStart()
                    ->where('inmates_check_out_date', '')
                    ->orWhere('inmates_check_out_date', null)
                    ->orWhere('inmates_check_out_date', '0000-00-00')
                ->groupEnd()
                ->where('inmates_check_in_date <=', $check_in_date)
            ->groupEnd()

            ->orGroupStart()
                ->where('inmates_check_in_date <=', $check_in_date)
                ->where('inmates_check_out_date >=', $check_in_date)
            ->groupEnd();
        }

        $builder->groupEnd();

        return $builder->countAllResults();

        //echo $builder->getCompiledSelect();
        //exit;

    }*/

    
public function CountInmatesInRoomBetweenDates($room_id, $check_in_date, $check_out_date = null)
{
    $builder = $this->db->table('saiyoojyam_inmates')
        ->where('inmates_rooms', $room_id)
        ->groupStart();

    if (!empty($check_out_date)) {
        // Main logic: Only overlapping bookings
        $builder->groupStart()
            ->where('inmates_check_in_date <', $check_out_date) // starts before user checkout
            ->where('inmates_check_out_date >', $check_in_date) // ends after user checkin
        ->groupEnd();

        // Open-ended bookings (no checkout date)
        $builder->orGroupStart()
            ->groupStart()
                ->where('inmates_check_out_date', '')
                ->orWhere('inmates_check_out_date', null)
                ->orWhere('inmates_check_out_date', '0000-00-00')
            ->groupEnd()
            ->where('inmates_check_in_date <', $check_out_date)
        ->groupEnd();

    } else{
        // Only check-in provided
        $builder->groupStart()
            ->where('inmates_check_out_date >', $check_in_date)
            ->orWhere('inmates_check_out_date', '')
            ->orWhere('inmates_check_out_date', null)
            ->orWhere('inmates_check_out_date', '0000-00-00')
        ->groupEnd();
    }

    $builder->groupEnd();

    // Test output
    echo $builder->getCompiledSelect(); exit();

    // return $builder->countAllResults();
}









public function FetchAllOrderjoins($table,$order_key,$order,$joins)
{

    $query= $this->db
    ->table($table)
    ->select('*')
    ->orderBy($order_key, $order);
        if(!empty($joins))
    
    foreach($joins as $join){

        $table2 = $table;
        if(!empty($join['table2']))
        {
        $table2 = $join['table2'];
        }
        $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table2.'.'.$join['fk'].'', 'left');
    }
    $result = $query->get()->getResult();

    return $result;
 }


public function buildingSearch($table,$order_key,$order,$joins,$building,$room_type){
    
    $query= $this->db
    ->table($table)
    ->select('*')
    ->orderBy($order_key, $order);

    if(!empty($building)){
   
        $query->where('tariffs_building',$building);

    }

    if(!empty($room_type)){
   
        $query->where('rooms_type',$room_type);

    }

    if(!empty($joins))
    
    foreach($joins as $join){

        $table2 = $table;
        if(!empty($join['table2']))
        {
        $table2 = $join['table2'];
        }
        $query->join($join['table'], ''.$join['table'].'.'.$join['pk'].' = '.$table2.'.'.$join['fk'].'', 'left');
    }

    $result = $query->get()->getResult();

    //echo $this->db->getLastQuery(); exit();

    return $result;


}


public function RoomsCategory(){

    $query = $this->db->table('saiyoojyam_building')
        ->select('*')
        ->orderBy('building_id', 'ASC');
        $result = $query->get()->getResult();

        //return $result;

       

        $i = 0;
        foreach ($result as $res) {

            $cond_user = ['room_type_building_id' => $res->building_id];
            $result[$i]->build_rooms_type = $this->FetchRoomType($cond_user);
            $i++;

        }

        return $result;


}


public function FetchRoomType($cond){

    $query = $this->db->table('saiyoojyam_room_type')
        ->where($cond)
        ->orderBy('room_type_id', 'DESC');
        $result = $query->get()->getResult();

        //return $result;

        $i = 0;
        foreach ($result as $res) {

            $cond_user = ['rooms_type' => $res->room_type_id];
            $result[$i]->rooms = $this->FetchWhere('saiyoojyam_rooms',$cond_user);
            $i++;

        }

        return $result;


}


public function fetchAvaliableRooms($room_id,$check_in_date){

    return $this->db->table('saiyoojyam_inmates')
        ->where('inmates_rooms', $room_id)
        ->where('inmates_check_in_date <=', $check_in_date)
        ->groupStart()
            ->where('inmates_check_out_date >', $check_in_date)
            ->orWhere('inmates_check_out_date IS NULL')
            ->orWhere('inmates_check_out_date', '')
        ->groupEnd()
        ->countAllResults();
}


public function inmatesMonthRent($date_start,$date_end){
    
    $currentYear = date('Y',strtotime($date_start));

    $query = $this->db->table('saiyoojyam_inmates')
    
    ->where("DATE_FORMAT(inmates_check_in_date, '%Y') <= $currentYear", NULL, FALSE)

    ->orderBy('inmates_id', 'DESC');
    
    $result = $query->get()->getResult();

    $i = 0;

    foreach ($result as $res) {

        $cond_user = ['invoice_inmates' => $res->inmates_id];
        $result[$i]->invoice = $this->MonthRent('saiyoojyam_invoice',$cond_user,$date_start,$date_end);
        $i++;

    }

    return $result;

}


public function MonthRent($table,$cond,$date_start,$date_end){

    $query = $this->db->table($table)

        ->where($cond)
        ->where('invoice_payment_month >=', $date_start) //2025-01-01
        ->where('invoice_payment_month <=', $date_end); //2025-01-31
        //->orderBy('room_type_id', 'DESC');
        $result = $query->get()->getResult();

        //echo $this->db->getLastQuery(); exit();

    return $result;

}


public function FetchLastInvoice($table,$cond){

    $query = $this->db->table($table)

    ->where($cond)
        
    ->orderBy('invoice_id', 'DESC');
    
    $result = $query->get()->getRow();

    return $result;

}

public function inmatesBuilding($month,$year,$cond){

    $date = date('Y-m-d', strtotime("$year-$month-01")); 
    
    $query = $this->db->table('saiyoojyam_inmates')

    ->where($cond)

    ->where('saiyoojyam_invoice.invoice_payment_month',$date)
        
    ->orderBy('inmates_name', 'asc')
    
    ->join('saiyoojyam_rooms', 'saiyoojyam_inmates.inmates_rooms = saiyoojyam_rooms.rooms_id', 'left')

    ->join('saiyoojyam_room_type', 'saiyoojyam_inmates.inmates_room_type = saiyoojyam_room_type.room_type_id', 'left')

    ->join('saiyoojyam_tariffs', 'saiyoojyam_inmates.inmates_rooms = saiyoojyam_tariffs.tariffs_rooms', 'left')

    ->join('saiyoojyam_invoice', 'saiyoojyam_inmates.inmates_id  = saiyoojyam_invoice.invoice_inmates', 'left');

    $result = $query->get()->getResult();

    return $result;

}


public function room_type($cond){

    
    $query = $this->db->table('saiyoojyam_room_type')
        ->where($cond)
        ->orderBy('room_type_id', 'DESC');
        $result = $query->get()->getResult();

        //return $result;

        $i = 0;
        foreach ($result as $res) {

            $cond_user = ['rooms_type' => $res->room_type_id];
            $result[$i]->rooms = $this->FetchWhere('saiyoojyam_rooms',$cond_user);
            $i++;

        }

        return $result;


}







}

