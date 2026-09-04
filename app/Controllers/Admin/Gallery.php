<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use CodeIgniter\Images\Image;

class Gallery extends BaseController
{
    public function index(){
        
        $data['pagedata'] = $this->common_model->FetchAllOrder('saiyoojyam_gallery','gallery_id','DESC');

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        return view('admin/view_gallery',$data);
    }


    
    

    public function Add()
    {
        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        if ($this->request->getMethod() === 'POST') {
            $photo = $this->request->getFile('gallery_path');
            $photoName = null;

            $uploadPath = FCPATH . 'uploads/gallery/';
            $thumbPath  = FCPATH . 'uploads/gallery/thumbs/';

            // Create directories if not exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!is_dir($thumbPath)) {
                mkdir($thumbPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);

               
                \Config\Services::image()
                    ->withFile($uploadPath . $photoName)
                    ->fit(300, 200, 'center') 
                    ->save($thumbPath . $photoName); 
            }

            $data = [
                'gallery_category'   => $this->request->getPost('category'),
                'gallery_path'       => $photoName,
                'gallery_created_at' => date('Y-m-d'),
            ];

            $this->common_model->InsertData('saiyoojyam_gallery', $data);

            $response['status'] = true;
            $response['msg'] = 'Data Added Successfully';

            echo json_encode($response);
            return;
        }

        return view('admin/add_gallery', $data);
    }

    public function Edit($id){

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        $data['gallery'] = $this->common_model->SingleRow('saiyoojyam_gallery',array('gallery_id' => $id));

       

        if($this->request->getMethod() === 'POST'){

            $photo = $this->request->getFile('gallery_path');
            $photoName = $data['gallery']->gallery_path; 

            //print_r($photoName ); exit();

            $uploadPath = FCPATH . 'uploads/gallery/';
            $thumbPath  = FCPATH . 'uploads/gallery/thumbs/';

        
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!is_dir($thumbPath)) {
                mkdir($thumbPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // Delete old files
                if (!empty($data['gallery']->gallery_path)) {
                    @unlink($uploadPath . $data['gallery']->gallery_path);
                    @unlink($thumbPath . $data['gallery']->gallery_path);
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
                'gallery_category'   => $this->request->getPost('category'),
                'gallery_path'       => $photoName,
                'gallery_updated_at' => date('Y-m-d'),
            ];

            $this->common_model->EditData($data,array('gallery_id' => $id),'saiyoojyam_gallery');

             $flashdata = array(
                'type' => 'success',
                'msg' => 'Gallery Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Gallery/Edit/'.$id));
            

        }

        return view('admin/edit_gallery',$data);
    
    }


    public function Delete($id){

        $gallery = $this->common_model->SingleRow('saiyoojyam_gallery',array('gallery_id' => $id));

        @unlink(ROOTPATH.'public/uploads/gallery/'.$gallery->gallery_path);

        @unlink(ROOTPATH.'public/uploads/gallery/thumbs/'.$gallery->gallery_path);

        $this->common_model->DeleteData('saiyoojyam_gallery',array('gallery_id' => $id));

        $flashdata = array(
            'type' => 'success',
            'msg' => 'Date Deleted Successfully',
        );

        $this->session->setFlashdata('alert',$flashdata);

        return redirect()->to(site_url().'Admin/Gallery');

    }
    




   
}
