<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Building extends BaseController
{
    public function index(){

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');
        
        return view('admin/view_building',$data);
    }

    public function Add(){
        
        if ($this->request->getMethod() === 'POST') {

            $insert_data = $this->request->getPost();

            $insert_data['building_name'] = preg_replace('/\s+/', ' ', trim($insert_data['building_name']));

            $existing = $this->common_model->SingleRowTrimmed('saiyoojyam_building','building_name',$insert_data['building_name']);

            if(!empty($existing)){

                $response['status'] = "false";

                $response['msg'] = "Building name already exists";

                echo json_encode($response);

                return;
                
            }

            $insert_data['building_slug'] = $this->common_model->CreateSlug($insert_data['building_name'],'building_name','saiyoojyam_building');
            
            $insert_data['building_created_at'] = date('Y-m-d'); 

            $id = $this->common_model->InsertData('saiyoojyam_building',$insert_data);

            $response['status'] = "true";

            $response['msg'] = "Data Added Successfully";

            echo json_encode($response);

            return;

        }
 

        return view('admin/add_building');


    }


    public function Edit($id){

        if ($this->session->get('manage') == 'website') {
            return $this->EditWeb($id);
        }

        $data['building'] = $this->common_model->SingleRow('saiyoojyam_building',array('building_id' => $id));

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $update_data['building_name'] = preg_replace('/\s+/', ' ', trim($update_data['building_name']));

            $existing = $this->common_model->SingleRowTrimmed('saiyoojyam_building','building_name',$update_data['building_name']);

            if(!empty($existing) && $existing->building_id != $id){

                $flashdata = array(
                    'type' => 'error',
                    'msg'  => 'Building name already exists',
                );

                $this->session->setFlashdata('alert',$flashdata);

                return redirect()->to(site_url('Admin/Building/Edit/'.$id));

            }

              
            if($data['building']->building_slug==$this->request->getPost('building_name'))
            {
                $slug = $data['building']->building_slug;
            }
            else
            {
                $slug = $this->common_model->CreateSlug($update_data['building_name'],'building_name','saiyoojyam_building');
            }

            $update_data['building_slug'] = $slug;
            $update_data['building_updated_at'] = date('Y-m-d'); 

            $this->common_model->EditData($update_data,array('building_id' => $id),'saiyoojyam_building');

             $flashdata = array(
                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Building/Edit/'.$id));

        }

        return view('admin/edit_building',$data);
    }

    public function EditWeb($id){

        $this->ensureWebsiteBuildingSchema();

        $data['building'] = $this->common_model->SingleRow('saiyoojyam_building', array('building_id' => $id));
        if (empty($data['building'])) {
            return redirect()->to(site_url('Admin/Building'));
        }

        $data['more_image'] = $this->common_model->FetchWhere('saiyoojyam_building_more_image', array('more_image_building_id' => $id));

        // Fallback default values from static configs if database fields are not set yet
        $bSlug = strtolower(trim($data['building']->building_slug ?? ''));
        $cleanSlug = trim(preg_replace('/^saiyoojyam[-_]/i', '', $bSlug));
        $defaultConfig = $this->getDefaultBuildingData($cleanSlug ?: $bSlug);
        if (!$defaultConfig && (strpos($bSlug, 'tower') !== false || strpos(strtolower($data['building']->building_name ?? ''), 'tower') !== false)) {
            $defaultConfig = $this->getDefaultBuildingData('towers');
        }
        $data['default_config'] = $defaultConfig;

        if ($this->request->getMethod() === 'POST') {

            $photo = $this->request->getFile('building_image');
            $photoName = $data['building']->building_image ?? '';

            $uploadPath = ROOTPATH . 'public/uploads/buildings/';
            $thumbPath  = ROOTPATH . 'public/uploads/buildings/thumbs/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            if (!is_dir($thumbPath)) {
                mkdir($thumbPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                if (!empty($data['building']->building_image)) {
                    @unlink($uploadPath . $data['building']->building_image);
                    @unlink($thumbPath . $data['building']->building_image);
                }

                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);

                try {
                    \Config\Services::image()
                        ->withFile($uploadPath . $photoName)
                        ->fit(600, 400, 'center')
                        ->save($thumbPath . $photoName);
                } catch (\Exception $e) {
                    // fallback if thumbnail generation fails
                }
            }

            // Key facilities & amenities
            $amenities_titles = $this->request->getPost('amenities_title') ?? [];
            $amenities_subtitles = $this->request->getPost('amenities_subtitle') ?? [];
            $amenities_icons = $this->request->getPost('amenities_icon') ?? [];

            $amenitiesGrid = [];
            if (!empty($amenities_titles) && is_array($amenities_titles)) {
                for ($k = 0; $k < count($amenities_titles); $k++) {
                    $t = trim($amenities_titles[$k] ?? '');
                    if ($t !== '') {
                        $amenitiesGrid[] = [
                            'title'    => $t,
                            'subtitle' => trim($amenities_subtitles[$k] ?? ''),
                            'icon'     => trim($amenities_icons[$k] ?? 'Building'),
                        ];
                    }
                }
            }

            // Hostel Amenities & Living Facilities
            $features_input = $this->request->getPost('living_facilities');
            $featuresList = [];
            if (is_array($features_input)) {
                foreach ($features_input as $feat) {
                    $f = trim($feat);
                    if ($f !== '') $featuresList[] = $f;
                }
            } elseif (is_string($features_input)) {
                $lines = explode("\n", $features_input);
                foreach ($lines as $line) {
                    $trimmed = trim($line, " \t\n\r\0\x0B-•*");
                    if ($trimmed !== '') {
                        $featuresList[] = $trimmed;
                    }
                }
            }

            $bName = trim($this->request->getPost('building_name') ?? '');
            if (empty($bName)) {
                $bName = $data['building']->building_name;
            }

            $update_data = [
                'building_name'              => $bName,
                'building_tagline'           => trim($this->request->getPost('building_tagline') ?? ''),
                'building_address'           => trim($this->request->getPost('building_address') ?? ''),
                'building_map'               => trim($this->request->getPost('building_map') ?? ''),
                'building_map_link'          => trim($this->request->getPost('building_map_link') ?? ''),
                'building_key_amenities'     => json_encode($amenitiesGrid, JSON_UNESCAPED_UNICODE),
                'building_living_facilities' => json_encode($featuresList, JSON_UNESCAPED_UNICODE),
                'building_image'             => $photoName,
                'building_updated_at'        => date('Y-m-d H:i:s'),
            ];

            if ($this->request->getPost('building_whatsapp') !== null) {
                $update_data['building_whatsapp'] = trim($this->request->getPost('building_whatsapp'));
            }
            if ($this->request->getPost('building_description') !== null) {
                $update_data['building_description'] = trim($this->request->getPost('building_description'));
            }
            if ($this->request->getPost('building_meta_title') !== null) {
                $update_data['building_meta_title'] = trim($this->request->getPost('building_meta_title'));
            }
            if ($this->request->getPost('building_meta_description') !== null) {
                $update_data['building_meta_description'] = trim($this->request->getPost('building_meta_description'));
            }
            if ($this->request->getPost('building_meta_keywords') !== null) {
                $update_data['building_meta_keywords'] = trim($this->request->getPost('building_meta_keywords'));
            }

            $this->common_model->EditData($update_data, array('building_id' => $id), 'saiyoojyam_building');

            // Handle More Images Upload
            if (!empty($_FILES["document_more"]["name"])) {
                $count = count($_FILES["document_more"]["name"]);
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($_FILES["document_more"]["name"][$i])) {
                        $originalName = $_FILES["document_more"]["name"][$i];
                        $tmpName      = $_FILES["document_more"]["tmp_name"][$i];

                        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                            $gallery = 'buildingmore_' . time() . '_' . $i . '.' . $ext;
                            $fullPath = $uploadPath . $gallery;

                            if (move_uploaded_file($tmpName, $fullPath)) {
                                try {
                                    \Config\Services::image()
                                        ->withFile($fullPath)
                                        ->fit(400, 300, 'center')
                                        ->save($thumbPath . $gallery);
                                } catch (\Exception $e) {}

                                $more_img = [
                                    'more_image_building_id' => $id,
                                    'more_image_name'        => $gallery,
                                    'created_at'             => date('Y-m-d'),
                                ];
                                $this->common_model->InsertData('saiyoojyam_building_more_image', $more_img);
                            }
                        }
                    }
                }
            }

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Building website details updated successfully',
            );
            $this->session->setFlashdata('alert', $flashdata);

            return redirect()->to(site_url('Admin/Building/EditWeb/'.$id));
        }

        return view('admin/edit_web_building', $data);
    }

    public function Deletemore($id){
        $this->ensureWebsiteBuildingSchema();
        $cond = array('more_image_id' => $id);
        $unlink_img = $this->common_model->SingleRow('saiyoojyam_building_more_image', $cond);
        if(!empty($unlink_img)){
            $buildingId = $unlink_img->more_image_building_id;
            @unlink(ROOTPATH . 'public/uploads/buildings/' . $unlink_img->more_image_name);
            @unlink(ROOTPATH . 'public/uploads/buildings/thumbs/' . $unlink_img->more_image_name);
            $this->common_model->DeleteData('saiyoojyam_building_more_image', $cond);

            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Image deleted successfully',
            );
            $this->session->setFlashdata('alert', $flashdata);
            return redirect()->to(base_url() . 'Admin/Building/EditWeb/' . $buildingId);
        }
        return redirect()->to(base_url() . 'Admin/Building');
    }

    private function ensureWebsiteBuildingSchema(){
        try {
            $db = \Config\Database::connect();
            $forge = \Config\Database::forge();

            $columns = [
                'building_tagline'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'building_address'           => ['type' => 'TEXT', 'null' => true],
                'building_map'               => ['type' => 'TEXT', 'null' => true],
                'building_map_link'          => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
                'building_image'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'building_key_amenities'     => ['type' => 'LONGTEXT', 'null' => true],
                'building_living_facilities' => ['type' => 'LONGTEXT', 'null' => true],
                'building_description'       => ['type' => 'TEXT', 'null' => true],
                'building_whatsapp'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
                'building_meta_title'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'building_meta_description'  => ['type' => 'TEXT', 'null' => true],
                'building_meta_keywords'     => ['type' => 'TEXT', 'null' => true],
            ];

            foreach ($columns as $columnName => $colDef) {
                if (!$db->fieldExists($columnName, 'saiyoojyam_building')) {
                    $forge->addColumn('saiyoojyam_building', [$columnName => $colDef]);
                }
            }

            if (!$db->tableExists('saiyoojyam_building_more_image')) {
                $forge->addField([
                    'more_image_id' => [
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => true,
                        'auto_increment' => true,
                    ],
                    'more_image_building_id' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'null'       => false,
                    ],
                    'more_image_name' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 255,
                        'null'       => false,
                    ],
                    'created_at' => [
                        'type' => 'DATE',
                        'null' => true,
                    ],
                ]);
                $forge->addKey('more_image_id', true);
                $forge->createTable('saiyoojyam_building_more_image', true);
            }
        } catch (\Exception $e) {
            log_message('error', 'Schema update error: ' . $e->getMessage());
        }
    }

    private function getDefaultBuildingData($slug){
        $defaults = [
            'premier' => [
                'tagline' => '5 Residential Floors · 35,000 Sq.ft Premier Living Near Infopark',
                'address' => 'Opposite Solace Kids, Painakkil Junction, 1st left from Noel Palmdale Lane, Kakkanad, Kochi',
                'mapEmbedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.0549486153086!2d76.3566499!3d10.0123201!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080d0057e2d5bb%3A0x3b2d558eacccde6e!2sSaiyoojyam%20Premier!5e0!3m2!1sen!2sin!4v1791888241388!5m2!1sen!2sin',
                'mapDirectUrl' => 'https://www.google.com/maps/place/Saiyoojyam+Premier/@10.0123201,76.3566499,17z/data=!3m1!4b1!4m6!3m5!1s0x3b080d0057e2d5bb:0x3b2d558eacccde6e!8m2!3d10.0123201!4d76.3566499',
                'whatsapp' => '917034111368',
                'description' => 'The building has 5 residential floors measuring an area of 35,000 Sq.ft offering premium safety, comfort, and convenient facilities.',
                'amenitiesGrid' => [
                    ['title' => 'Elevator Facility', 'subtitle' => 'All floors & Basement-1', 'icon' => 'Building'],
                    ['title' => 'Biometric Door', 'subtitle' => 'Access with guardian consent', 'icon' => 'Lock'],
                    ['title' => 'Homely Food', 'subtitle' => 'North & South Indian combo', 'icon' => 'Utensils'],
                    ['title' => 'Cab Service', 'subtitle' => 'Available at fixed timings', 'icon' => 'Car'],
                    ['title' => 'Generator Backup', 'subtitle' => 'For emergency situations', 'icon' => 'Zap'],
                    ['title' => '24/7 Wi-Fi', 'subtitle' => 'With inverter backup', 'icon' => 'Wifi'],
                ],
                'featuresList' => [
                    "The building has 5 residential floors measuring an area of 35,000 Sq.ft",
                    "24/7 Wi-Fi with inverter backup",
                    "2 days/week floor & toilet cleaning",
                    "Homely food; North & South Indian combo menu",
                    "Each apartment has 1 AC room, 1 Non-AC room & 1 toilet",
                    "Separate study area & covered small balcony area in each apartment",
                    "Each floor corridor has common study and sitting space",
                    "Common refrigerator & ironing facility on each floor",
                    "Basement-1: Dining, wash area, pantry, extra toilets & showers",
                    "Two-wheeler free parking & staff accommodation in Basement-1",
                    "Basement-2: Exclusively for car parking",
                    "Covered terrace study area / open space",
                    "Washing machines, washing stone & cloth drying lines on terrace",
                    "Breakfast & lunch tiffin ready by 7:30 AM",
                    "RO treated normal and boiled drinking water",
                    "Hot water facility available in all bathrooms",
                    "Cab service available at fixed timings",
                    "Biometric door access for late entry (with guardian consent)",
                    "Generator backup for emergency situations",
                    "Elevator facility to all residential floors and Basement-1",
                ]
            ],
            'annex' => [
                'tagline' => 'Comfortable Stay & Good Food At Reasonable Rates Near Infopark Kochi',
                'address' => 'Near Kuzhikkattumoola Petrol Pump, beside Excel Homes, Kakkanad, Kochi',
                'mapEmbedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.0296112684823!2d76.3551892!3d10.0144127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080ddf06400e79%3A0x18d8e9444f9094bb!2sSaiyoojyam%20Annex!5e0!3m2!1sen!2sin!4v1791888317353!5m2!1sen!2sin',
                'mapDirectUrl' => 'https://www.google.com/maps/place/Saiyoojyam+Annex/@10.0144127,76.3551892,17z/data=!3m1!4b1!4m6!3m5!1s0x3b080ddf06400e79:0x18d8e9444f9094bb!8m2!3d10.0144127!4d76.3551892',
                'whatsapp' => '917034111368',
                'description' => 'Comfortable Stay and Good Food at reasonable rates near Infopark Kochi.',
                'amenitiesGrid' => [
                    ['title' => '24/7 Wi-Fi', 'subtitle' => 'With inverter backup', 'icon' => 'Wifi'],
                    ['title' => 'Cleaning', 'subtitle' => '2 days/week floor & toilet', 'icon' => 'Building'],
                    ['title' => 'Homely Food', 'subtitle' => 'North & South Indian combo', 'icon' => 'Utensils'],
                    ['title' => 'Tiffin Ready', 'subtitle' => 'B/F & Lunch by 7:30 AM', 'icon' => 'Utensils'],
                    ['title' => 'Bus Stop Walkable', 'subtitle' => 'Just 250 meters away', 'icon' => 'Car'],
                ],
                'featuresList' => [
                    "24/7 Wi-Fi with inverter back up",
                    "2 days/week floor & toilet cleaning",
                    "Homely food; North & South Indian combo menu",
                    "Each floor has 3 rooms with attached toilets",
                    "4 beds, 1 table, 1 chair in each room",
                    "Basement-1: Dining, wash area, pantry & staff accommodation",
                    "Common refrigerator & ironing facility",
                    "Covered terrace with washing machines, washing stone & cloth drying lines",
                    "Breakfast & lunch tiffin ready by 7:30 AM",
                    "Boiled water provided for drinking purpose",
                    "Hot water for bathing can be fetched from terrace if needed",
                    "Bus stop at walkable distance, just 250 meters",
                ]
            ],
            'towers' => [
                'tagline' => 'Prathibha Layout · Second Cross Road, Kakkanad',
                'address' => 'Prathibha Layout, Second Cross Road, Block Panchayath Office Road, Kusumagiri P.O, Kakkanad, Kerala 682030',
                'mapEmbedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.0344879248346!2d76.34960057376456!3d10.01400997279611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080d42064f8335%3A0xda4cdedd9ad56ec7!2sSAIYOOJYAM%20-%20Ladies%20Hostel%20in%20Kakkanad%20%7C%20Women\'s%20Hostel%20near%20Infopark%20and%20CSEZ!5e0!3m2!1sen!2sin!4v1791888413434!5m2!1sen!2sin',
                'mapDirectUrl' => 'https://www.google.com/maps/place/SAIYOOJYAM+-+Ladies+Hostel+in+Kakkanad+%7C+Women\'s+Hostel+near+Infopark+and+CSEZ/@10.0140099,76.3496005,17z/data=!3m1!4b1!4m6!3m5!1s0x3b080d42064f8335:0xda4cdedd9ad56ec7!8m2!3d10.0140099!4d76.3496005',
                'whatsapp' => '917034111368',
                'description' => 'Saiyoojyam TOWERS 1 & 2 located at Prathibha Layout, Kusumagiri, Kakkanad offer comfortable coliving spaces and modern amenities near Infopark.',
                'amenitiesGrid' => [
                    ['title' => 'Twin Elevators', 'subtitle' => 'Servicing both towers', 'icon' => 'Building'],
                    ['title' => 'Homely Dining', 'subtitle' => 'Nutritious homely meals', 'icon' => 'Utensils'],
                    ['title' => 'Wi-Fi & Lounges', 'subtitle' => 'High speed connectivity', 'icon' => 'Wifi'],
                    ['title' => 'CCTV & Security', 'subtitle' => 'Monitored premises', 'icon' => 'Lock'],
                    ['title' => 'Tech Park Cab', 'subtitle' => 'Convenient transit access', 'icon' => 'Car'],
                ],
                'featuresList' => [
                    "Twin tower residential complex in Prathibha Layout, Kusumagiri, Kakkanad",
                    "High-speed 24/7 Wi-Fi connectivity throughout the property",
                    "Twin elevator facility servicing residential floors",
                    "Nutritious homely food menu for working professionals and students",
                    "Regular housekeeping and sanitation maintenance",
                    "Secure gate access timings from 6:00 AM to 10:00 PM",
                ]
            ]
        ];

        return $defaults[strtolower($slug)] ?? null;
    }


    public function Delete($id){
       
        $room_type = $this->common_model->SingleRow('saiyoojyam_room_type',array('room_type_building_id' => $id));

        $gallery = $this->common_model->SingleRow('saiyoojyam_gallery',array('gallery_category' => $id));

        
        if(empty($room_type) && empty($gallery)){
        
            $this->common_model->DeleteData('saiyoojyam_building',array('building_id' => $id));

            $flashdata = array(
                'type' => 'success',
                'msg' => 'Data Deleted Successfully',
            );

            $this->session->setFlashdata('alert',$flashdata);

        }
        else{

            $flashdata = array(
                'type' => 'error',
                'msg' => 'Cannot delete: Data is currently in use',
            );

            $this->session->setFlashdata('alert',$flashdata);
        }

        return redirect()->to(site_url('Admin/Building'));

    }

   


    
}
