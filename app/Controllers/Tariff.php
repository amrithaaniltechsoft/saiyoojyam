<?php

namespace App\Controllers;

class Tariff extends BaseController
{
    public function index(): string
    {   
        $joins = array(
            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'tariffs_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'tariffs_room_types',
            ),
           
            

        );

        //$data['tariffs'] = $this->common_model->FetchJoins('saiyoojyam_tariffs','tariffs_id','DESC',$joins);

        $data['tariffs'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => 13));

        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo',array('id' => 4));

        return view('user/tariff',$data);
    }
}
