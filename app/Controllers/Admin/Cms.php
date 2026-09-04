<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Cms extends BaseController
{
    public function index(){

       // $data['facilities'] = $this->common_model->SingleRow('saiyoojyam_cms',array('facilities_id' => 1));

       $data['pagedata'] = $this->common_model->FetchAllOrder('saiyoojyam_cms','id','DESC');

        return view('admin/view_cms',$data);
    }

    public function Edit($id){

        $data['cms_data'] = $this->common_model->SingleRow('saiyoojyam_cms',array('id' => $id));

        if($this->request->getMethod() === 'POST'){

            $photo = $this->request->getFile('image');
            $photoName = $data['cms_data']->cms_img	; 

            //print_r($photoName ); exit();

            $uploadPath = FCPATH . 'uploads/cms/';
            $thumbPath  = FCPATH . 'uploads/cms/thumbs/';

        
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!is_dir($thumbPath)) {
                mkdir($thumbPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // Delete old files
                if (!empty($data['cms_data']->cms_img)) {
                    @unlink($uploadPath . $data['cms_data']->cms_img);
                    @unlink($thumbPath . $data['cms_data']->cms_img	);
                }

                // Upload new file
                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);

                // Create thumbnail
                \Config\Services::image()
                    ->withFile($uploadPath . $photoName)
                    ->fit(300, 200, 'center')
                    ->save($thumbPath . $photoName);
            }

            // Update data
            $data = [
                'page'       => $this->request->getPost('page'),
                'cms_tittle' => $this->request->getPost('title'),
                'cms_desc'   => $this->request->getPost('description'),
                'cms_img'    => $photoName,
            ];

            $this->common_model->EditData($data,array('id' => $id),'saiyoojyam_cms');

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'CMS Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Cms/Edit/'.$id));
            

        }

        return view('admin/edit_cms',$data);
    }


   
}
