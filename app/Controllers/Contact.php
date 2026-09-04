<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {   
        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 7));

        $data['contact'] = $this->common_model->SingleRow('saiyoojyam_contact',array('contact_id' => 1));

        return view('user/contact',$data);
    }
}
