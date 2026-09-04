<?php

namespace App\Controllers;

class Kitchen extends BaseController
{
    public function index()
    {   
      

        $data['seo']   = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 10));

        $data['kitchen'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 15));

        return view('user/kitchen',$data);

    }

    
}
