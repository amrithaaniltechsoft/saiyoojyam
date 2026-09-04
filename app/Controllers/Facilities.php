<?php

namespace App\Controllers;

class Facilities extends BaseController
{
    public function index()
    {   
         

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 3));

        $data['facilities'] = $this->common_model->SingleRow('saiyoojyam_facilities',array('facilities_id ' => 1));

        return view('user/facilities',$data);
    }
}
