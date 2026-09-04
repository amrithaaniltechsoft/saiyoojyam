<?php

namespace App\Controllers;

class Gallery extends BaseController
{
    public function index()
    {   
        
        $data['category']= $this->common_model->CategoryProduct();

        $data['galleryies'] = $this->common_model->FetchAllOrder('saiyoojyam_gallery','gallery_id','DESC');

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 6));

        return view('user/gallery',$data);
    }
}
