<?php

namespace App\Controllers;

class Terms extends BaseController
{
    public function index()
    {   
      

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 8));

        $data['terms'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 12));

        return view('user/terms',$data);

    }

    
}
