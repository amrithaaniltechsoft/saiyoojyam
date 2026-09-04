<?php

namespace App\Controllers;

class Rules extends BaseController
{
    public function index()
    {   
    
        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 9));

        $data['rules'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 14));

        return view('user/rules',$data);

    }

    
}
