<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index()
    {   
      

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 2));

        $data['how_we_are'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 1));

        return view('user/who-we-are',$data);

    }

    public function Mission(){

         $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 2));
         
        $data['mission'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 2));

        $data['vision'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 3));

        return view('user/mission-vision',$data);

    }
}
