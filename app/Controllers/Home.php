<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {   
        $data['gallery'] = $this->common_model->FetchAllOrder('saiyoojyam_gallery','gallery_id','DESC');

        $data['Proprietor'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 4));

        $data['vision'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 9));

        $data['mission'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 10));

        $data['about'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 11));

        $data['cms_data'] = $this->common_model->FetchAllOrder('saiyoojyam_cms','id','asc');

        $data['building'] = $this->common_model->RoomsCategory();

        $data['rooms'] = $this->common_model->FetchAllOrder('saiyoojyam_rooms','rooms_id','asc');

        $data['room_types'] = $this->common_model->FetchAllOrder('saiyoojyam_room_type','room_type_id','asc');

        return view('user/index',$data);
    }
}
