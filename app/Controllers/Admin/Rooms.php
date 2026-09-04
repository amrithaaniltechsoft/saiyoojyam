<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use CodeIgniter\Images\Image;

class Rooms extends BaseController
{
    public function index(){

        $data['pagedata'] = $this->common_model->FetchAllOrder('saiyoojyam_rooms','rooms_id','DESC');

        $data['buildings'] = $this->common_model->FetchAll('saiyoojyam_building');

        $data['room_types'] = $this->common_model->FetchAll('saiyoojyam_room_type');

        return view('admin/view_rooms',$data);
    }


   

    public function Add(){

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        $data['room_types'] = $this->common_model->FetchAllOrder('saiyoojyam_room_type','room_type_id','DESC');

        if ($this->request->getMethod() === 'POST') {

            $room_avaliable = $this->common_model->FetchWhere('saiyoojyam_rooms',array('rooms_name' => $this->request->getPost('rooms_name')));

            if(!empty($room_avaliable)){

                $response['status'] = "false";

                $response['msg'] = "This room already exists. Please choose a different name";

            }else{


                $insert_data = $this->request->getPost();

                $insert_data['rooms_slug'] = $this->common_model->CreateSlug($insert_data['rooms_name'],'rooms_name','saiyoojyam_rooms');

                $insert_data['rooms_created_at'] = date('Y-m-d'); 

                $insert_data['rooms_ac_type'] =  "";

                $id = $this->common_model->InsertData('saiyoojyam_rooms',$insert_data);

                $response['status'] = "true";

                $response['msg'] = "Data Added Successfully";

            }

            echo json_encode($response);

            return;

        }

        return view('admin/add_rooms',$data);


    }

    public function Edit($id){
        
        $data['rooms'] = $this->common_model->SingleRow('saiyoojyam_rooms',array('rooms_id' => $id)); 

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        $data['room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $data['rooms']->rooms_building));

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            //$room_avaliable = $this->common_model->CheckDataWhere('saiyoojyam_rooms',array('rooms_name' => $this->request->getPost('rooms_name')));

            $room_avaliable = $this->common_model->CheckDataWhere('saiyoojyam_rooms','rooms_name',$this->request->getPost('rooms_name'),$data['rooms']->rooms_id,'rooms_id');

            if(!empty($room_avaliable)){

                $flashdata = array(

                    'type' => 'error',
                    'msg'  => 'This room already exists. Please choose a different name',
                );
    
                $this->session->setFlashdata('alert',$flashdata);

            }else{

                if($data['rooms']->rooms_slug==$this->request->getPost('rooms_name'))
                {
                    $slug = $data['rooms']->rooms_slug;
                }
                else
                {
                
                    $slug = $this->common_model->CreateSlug($update_data['rooms_name'],'rooms_name','saiyoojyam_rooms');

                }

                $update_data['rooms_slug'] = $slug;

                $update_data['rooms_updated_at'] = date('Y-m-d'); 

                $update_data['rooms_ac_type'] = "";

                $this->common_model->EditData($update_data,array('rooms_id' => $id),'saiyoojyam_rooms');

                $flashdata = array(
                    'type' => 'success',
                    'msg'  => 'Data Updated Successfully',
                );
    
                $this->session->setFlashdata('alert',$flashdata);


            }

            return redirect()->to(site_url('Admin/Rooms/Edit/'.$id));


        }

        return view('admin/edit_rooms',$data);
    }


    public function Delete($id){

        $tariffs = $this->common_model->FetchWhere('saiyoojyam_tariffs',array('tariffs_rooms' => $id));

        if(empty($tariffs)){

            $this->common_model->DeleteData('saiyoojyam_rooms',array('rooms_id' => $id));

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Date Deleted Successfully',
            );

        }else{

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Cannot delete: Date is currently in use',
            );
        }


        $this->session->setFlashdata('alert',$flashdata);

        return redirect()->to(site_url().'Admin/Rooms');


    }


    public function WebRoom(){

        $joins = array(
            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'rooms_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'rooms_type',
            ),
           
            

        );
        
        $data['pagedata'] = $this->common_model->FetchJoins('saiyoojyam_rooms','rooms_id','DESC',$joins);

        return view('admin/view_web_rooms',$data);

    }


    public function EditWeb($id){

        $joins = array(
            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'rooms_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'rooms_type',
            ),
         
        );

        $data['rooms'] = $this->common_model->SingleRowJoin('saiyoojyam_rooms',array('rooms_id' => $id),$joins); 

        $data['features'] = $this->common_model->FetchAllOrder('saiyoojyam_room_feature','feature_id','DESC');

        $data['more_image'] = $this->common_model->FetchWhere('saiyoojyam_more_image',array('more_image_room_id	' => $data['rooms']->rooms_id ));

        if($this->request->getMethod() === 'POST'){

            $photo = $this->request->getFile('rooms_image');
            $photoName = $data['rooms']->rooms_image; 

            //print_r($photoName ); exit();

            $uploadPath = FCPATH . 'uploads/rooms/';
            $thumbPath = FCPATH . 'uploads/rooms/thumbs/';
            
            
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!is_dir($thumbPath)) {
                mkdir($thumbPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // Delete old files
                if (!empty($data['rooms']->rooms_image)) {
                    @unlink($uploadPath . $data['rooms']->rooms_image);
                    @unlink($thumbPath . $data['rooms']->rooms_image);
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
            
            if(!empty($this->request->getPost('checkbox'))){

                $checked_data = $this->request->getPost('checkbox');
                $checked_data = implode(',',$checked_data);

            }else{
                
                $checked_data ="";

            }
            

            // Update data
            $data = [
                'rooms_description'      => $this->request->getPost('rooms_description'),
                'rooms_meta_title'       => $this->request->getPost('rooms_meta_title'),
                'rooms_meta_description' => $this->request->getPost('rooms_meta_description'),
                'rooms_meta_keyword'     => $this->request->getPost('rooms_meta_keyword'),
                'rooms_features'         => $checked_data,
                'rooms_image'            => $photoName,
                
            ];

            $this->common_model->EditData($data,array('rooms_id' => $id),'saiyoojyam_rooms');


            /**/
            if (!empty($_FILES["document_more"]["name"])) {
                $count = count($_FILES["document_more"]["name"]);
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($_FILES["document_more"]["name"][$i])) {
                        $originalName = $_FILES["document_more"]["name"][$i];
                        $tmpName = $_FILES["document_more"]["tmp_name"][$i];

                        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                        $gallery = 'productmore_' . time() . '_' . $i . '.' . $ext;

                        $uploadDir = ROOTPATH . 'public/uploads/Rooms';
                        $thumbDir  = ROOTPATH . 'public/uploads/Rooms/thumbs';

                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                        if (!is_dir($thumbDir)) mkdir($thumbDir, 0755, true);

                        $fullPath = $uploadDir . '/' . $gallery;

                        if (!move_uploaded_file($tmpName, $fullPath)) {
                            echo "Failed to move uploaded file: " . $originalName;
                            continue;
                        }

                        $imageService = \Config\Services::image();
                        if (!$imageService->withFile($fullPath)->resize(300, 200, true)->save($thumbDir . '/' . $gallery)) {
                            echo "Thumbnail creation failed for: " . $gallery . "<br>";
                            echo $imageService->getError();
                            continue;
                        }

                        $more_img = [
                            'more_image_room_id' => $id,
                            'more_image_name'    => $gallery
                        ];

                        $this->common_model->InsertData('saiyoojyam_more_image', $more_img);
                    }
                }
            }

            /**/

             $flashdata = array(
                'type' => 'success',
                'msg' => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Rooms/EditWeb/'.$id));
            

        }


        return view('admin/edit_web_room',$data);
    }


    public function Deletemore($id){

        $cond		=	array('more_image_id' => $id);
        $unlink_img = 	$this->common_model->SingleRow('saiyoojyam_more_image',$cond);
        $roomId=$unlink_img->more_image_room_id;
        @unlink(ROOTPATH.'public/uploads/rooms/'.$unlink_img->product_image);
        @unlink(ROOTPATH.'public/uploads/rooms/thumbs/'.$unlink_img->product_image);
        $this->common_model->DeleteData('saiyoojyam_more_image',$cond);
        return redirect()->to(base_url().'admin/Rooms/EditWeb/'.$roomId);

    }

    
}
