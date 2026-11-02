<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class About extends BaseController
{
    private function ensureTable()
    {
        $db = Database::connect();
        if (!$db->tableExists('saiyoojyam_about')) {
            $db->query("CREATE TABLE IF NOT EXISTS `saiyoojyam_about` (
              `about_id` int(11) NOT NULL AUTO_INCREMENT,
              `about_subtitle` varchar(255) DEFAULT NULL,
              `about_title` varchar(255) DEFAULT NULL,
              `about_description` text DEFAULT NULL,
              `about_image` varchar(255) DEFAULT NULL,
              `network_subtitle` varchar(255) DEFAULT NULL,
              `network_title` varchar(255) DEFAULT NULL,
              `network_description` text DEFAULT NULL,
              `network_images` text DEFAULT NULL,
              `mission_subtitle` varchar(255) DEFAULT NULL,
              `mission_title` varchar(255) DEFAULT NULL,
              `mission_description` text DEFAULT NULL,
              `vision_title` varchar(255) DEFAULT NULL,
              `vision_description` text DEFAULT NULL,
              `mission_image` varchar(255) DEFAULT NULL,
              `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`about_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        $fields = $db->getFieldNames('saiyoojyam_about');

        $neededColumns = [
            'about_subtitle'            => 'VARCHAR(255) NULL',
            'about_title'               => 'VARCHAR(255) NULL',
            'about_description'         => 'TEXT NULL',
            'about_image'               => 'VARCHAR(255) NULL',
            'network_subtitle'          => 'VARCHAR(255) NULL',
            'network_title'             => 'VARCHAR(255) NULL',
            'network_description'       => 'TEXT NULL',
            'network_images'            => 'TEXT NULL',
            'mission_subtitle'          => 'VARCHAR(255) NULL',
            'mission_title'             => 'VARCHAR(255) NULL',
            'mission_description'       => 'TEXT NULL',
            'vision_title'              => 'VARCHAR(255) NULL',
            'vision_description'        => 'TEXT NULL',
            'mission_image'             => 'VARCHAR(255) NULL',
            'specialities_subtitle'     => 'VARCHAR(255) NULL',
            'specialities_title'        => 'VARCHAR(255) NULL',
            'specialities_items'        => 'LONGTEXT NULL',
            'neighbourhood_subtitle'    => 'VARCHAR(255) NULL',
            'neighbourhood_title'       => 'VARCHAR(255) NULL',
            'neighbourhood_description' => 'TEXT NULL',
            'neighbourhood_landmarks'   => 'TEXT NULL',
            'cta_title'                   => 'VARCHAR(255) NULL',
            'cta_description'             => 'TEXT NULL',
            'cta_image'                   => 'VARCHAR(255) NULL',
            'cta_whatsapp_number'         => 'VARCHAR(50) NULL',
            'cta_whatsapp_button_text'    => 'VARCHAR(100) NULL',
            'cta_secondary_button_text'   => 'VARCHAR(100) NULL',
            'cta_secondary_button_link'   => 'VARCHAR(255) NULL',
        ];

        foreach ($neededColumns as $colName => $colDef) {
            if (!in_array($colName, $fields)) {
                $db->query("ALTER TABLE `saiyoojyam_about` ADD COLUMN `{$colName}` {$colDef};");
            }
        }

        $defaultSpecialities = [
            [
                'title' => 'Healthy Living Environment',
                'icon'  => 'Sparkles',
                'desc'  => 'Saiyoojyam provides a healthy living with homely food, hygienic environment, clean drinking water (well water with RO plant and 24 hrs boiled drinking water) and conducive environment for the overall individual development',
            ],
            [
                'title' => 'Water Supply',
                'icon'  => 'Droplets',
                'desc'  => 'Wells attached with modern purification plant provide clean water for drinking and other requirements. There is also provision for full-time supply of hot water to the bathrooms.',
            ],
            [
                'title' => 'Security',
                'icon'  => 'ShieldCheck',
                'desc'  => 'The whole complex and surroundings is equipped with modern CCTV cameras, in addition to experienced staff, all staying in the same building providing round-the-clock security.',
            ],
        ];

        $defaultNeighbourhoodDesc = '<p>Saiyoojyam Towers are located at close proximity to the Collectorate, Info Park, Sunrise Hospital, Wonderla Amusement Park, Rajagiri College and Hospital, Thrikkakara Temple, and few kilometers from Kadambrayar Boating Center and Eco Village.</p><p>Saiyoooyam Premeir and Saiyoojyam Annex are also ladies hostels situated in the same locality, Kuzhikattumoola, Kusumagiri P.O., Kakkanad.</p>';

        $defaultLandmarks = 'Collectorate Kakkanad, Infopark & SmartCity, Sunrise Hospital, Wonderla Amusement Park, Rajagiri College & Hospital, Thrikkakara Temple, Kadambrayar Boating Center, Eco Village';

        // Check if initial row exists
        $row = $db->table('saiyoojyam_about')->get()->getRow();
        if (empty($row)) {
            $db->table('saiyoojyam_about')->insert([
                'about_subtitle'            => 'Role of Hostel Accommodation',
                'about_title'               => '...A Second Home for Innovators & Professionals',
                'about_description'         => '<p>Hostel accommodation plays a major role in society by supporting economic growth and development. An acceptable level of operation, and facilities with hygienic environment and homely food is essential for the young and innovative minds of both educational institutions and IT sector, who consider hostels as their second home.</p><p>Saiyoojyam accommodates female working professionals, mainly from the IT sector, finance sector, medical professionals and students from educational institutions of Rajagiri, Jain University.</p>',
                'about_image'               => '',
                'network_subtitle'          => 'Our Properties',
                'network_title'             => 'Saiyoojyam Hostels Network',
                'network_description'       => '<p>Saiyoojyam Hostels consists of Saiyoojyam Towers, Saiyoojyam Premier and Saiyoojyam Annex. Saiyoojyam Towers are currently fully occupied by the female students of Indian Institute of Management Kochi (IIMK). It is a multi-storeyed complex with elevator and modern facilities. It is situated in a very peaceful location in Kusumagiri, Kakkanad, adjacent to Noel Greenature Apartments. The complex is fully furnished with modern high quality imported furniture and toilet accessories of European standard. It has both A/C and non-A/C rooms.</p><p>Saiyoojyam Premier is a leased apartment building converted to facilitate hostel operation, fully furnished and fully operational from 2026. Saiyoojyam Annex is a budget friendly hostel for ladies.</p>',
                'network_images'            => json_encode([]),
                'mission_subtitle'          => 'Purpose & Commitment',
                'mission_title'             => 'Mission',
                'mission_description'       => '<p>To provide a healthy, hygienic, safe and secure living environment, to stimulate the innovative youngsters to achieve their academic excellence and for working women to explore and develop their skills, potential, talent and attributes to the maximum extent and climb their career ladder.</p>',
                'vision_title'              => 'Vision',
                'vision_description'        => '<p>Getting admission to the best educational institution alone will not guarantee best result or academic excellence unless their accommodation is also supportive for them to reach their full potential. Saiyoojyam also offers accommodation to the skilful employees of the multinational firms who are hired from outside the region.</p>',
                'mission_image'             => '',
                'specialities_subtitle'     => 'Why Residents Trust Us',
                'specialities_title'        => 'Specialities',
                'specialities_items'        => json_encode($defaultSpecialities),
                'neighbourhood_subtitle'    => 'Prime Location',
                'neighbourhood_title'       => 'Neighbourhood Facilities',
                'neighbourhood_description' => $defaultNeighbourhoodDesc,
                'neighbourhood_landmarks'   => $defaultLandmarks,
                'cta_title'                   => 'Looking for a comfortable home in Kakkanad?',
                'cta_description'             => 'Connect with our team to inquire about room availability, schedule a campus visit, or book your accommodation.',
                'cta_image'                   => '',
                'cta_whatsapp_number'         => '917034111368',
                'cta_whatsapp_button_text'    => 'Enquire via WhatsApp',
                'cta_secondary_button_text'   => 'Explore Rooms',
                'cta_secondary_button_link'   => '/search',
            ]);
        } else {
            $updateDefaults = [];
            if (empty($row->network_title)) {
                $updateDefaults['network_subtitle'] = 'Our Properties';
                $updateDefaults['network_title'] = 'Saiyoojyam Hostels Network';
                $updateDefaults['network_description'] = '<p>Saiyoojyam Hostels consists of Saiyoojyam Towers, Saiyoojyam Premier and Saiyoojyam Annex. Saiyoojyam Towers are currently fully occupied by the female students of Indian Institute of Management Kochi (IIMK). It is a multi-storeyed complex with elevator and modern facilities. It is situated in a very peaceful location in Kusumagiri, Kakkanad, adjacent to Noel Greenature Apartments. The complex is fully furnished with modern high quality imported furniture and toilet accessories of European standard. It has both A/C and non-A/C rooms.</p><p>Saiyoojyam Premier is a leased apartment building converted to facilitate hostel operation, fully furnished and fully operational from 2026. Saiyoojyam Annex is a budget friendly hostel for ladies.</p>';
            }
            if (empty($row->mission_title)) {
                $updateDefaults['mission_subtitle'] = 'Purpose & Commitment';
                $updateDefaults['mission_title'] = 'Mission';
                $updateDefaults['mission_description'] = '<p>To provide a healthy, hygienic, safe and secure living environment, to stimulate the innovative youngsters to achieve their academic excellence and for working women to explore and develop their skills, potential, talent and attributes to the maximum extent and climb their career ladder.</p>';
                $updateDefaults['vision_title'] = 'Vision';
                $updateDefaults['vision_description'] = '<p>Getting admission to the best educational institution alone will not guarantee best result or academic excellence unless their accommodation is also supportive for them to reach their full potential. Saiyoojyam also offers accommodation to the skilful employees of the multinational firms who are hired from outside the region.</p>';
            }
            if (empty($row->about_subtitle)) {
                $updateDefaults['about_subtitle'] = 'Role of Hostel Accommodation';
            }
            if (empty($row->specialities_title)) {
                $updateDefaults['specialities_subtitle'] = 'Why Residents Trust Us';
                $updateDefaults['specialities_title']    = 'Specialities';
                $updateDefaults['specialities_items']    = json_encode($defaultSpecialities);
            }
            if (empty($row->neighbourhood_title)) {
                $updateDefaults['neighbourhood_subtitle']    = 'Prime Location';
                $updateDefaults['neighbourhood_title']       = 'Neighbourhood Facilities';
                $updateDefaults['neighbourhood_description'] = $defaultNeighbourhoodDesc;
                $updateDefaults['neighbourhood_landmarks']   = $defaultLandmarks;
            }
            if (empty($row->cta_title)) {
                $updateDefaults['cta_title']                 = 'Looking for a comfortable home in Kakkanad?';
                $updateDefaults['cta_description']           = 'Connect with our team to inquire about room availability, schedule a campus visit, or book your accommodation.';
                $updateDefaults['cta_image']                 = '';
                $updateDefaults['cta_whatsapp_number']       = '917034111368';
                $updateDefaults['cta_whatsapp_button_text']  = 'Enquire via WhatsApp';
                $updateDefaults['cta_secondary_button_text'] = 'Explore Rooms';
                $updateDefaults['cta_secondary_button_link'] = '/search';
            }
            if (!empty($updateDefaults)) {
                $idCol = isset($row->about_id) ? 'about_id' : 'id';
                $db->table('saiyoojyam_about')->where($idCol, $row->{$idCol})->update($updateDefaults);
            }
        }
    }

    public function index()
    {
        $this->ensureTable();
        $db = Database::connect();
        $data['about'] = $db->table('saiyoojyam_about')->get()->getRow();
        return view('admin/view_about', $data);
    }

    public function View()
    {
        return $this->index();
    }

    public function Edit($id = 1)
    {
        $this->ensureTable();
        $db = Database::connect();
        $fields = $db->getFieldNames('saiyoojyam_about');
        $idCol = in_array('about_id', $fields) ? 'about_id' : (in_array('id', $fields) ? 'id' : $fields[0]);

        $row = $db->table('saiyoojyam_about')->where($idCol, $id)->get()->getRow();
        if (empty($row)) {
            $row = $db->table('saiyoojyam_about')->get()->getRow();
        }

        if (empty($row)) {
            return redirect()->to(site_url('Admin/About/View'));
        }

        $currentId = $row->{$idCol};

        if ($this->request->getMethod() === 'POST') {
            $uploadPath = FCPATH . 'uploads/about/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // 1. Section 1 Image
            $aboutPhoto = $this->request->getFile('about_image');
            $aboutPhotoName = $row->about_image ?? '';
            if ($aboutPhoto && $aboutPhoto->isValid() && !$aboutPhoto->hasMoved()) {
                if (!empty($aboutPhotoName) && file_exists($uploadPath . $aboutPhotoName)) {
                    @unlink($uploadPath . $aboutPhotoName);
                }
                $aboutPhotoName = $aboutPhoto->getRandomName();
                $aboutPhoto->move($uploadPath, $aboutPhotoName);
            }

            // 2. Section 3 (Mission) Image
            $missionPhoto = $this->request->getFile('mission_image');
            $missionPhotoName = $row->mission_image ?? '';
            if ($missionPhoto && $missionPhoto->isValid() && !$missionPhoto->hasMoved()) {
                if (!empty($missionPhotoName) && file_exists($uploadPath . $missionPhotoName)) {
                    @unlink($uploadPath . $missionPhotoName);
                }
                $missionPhotoName = $missionPhoto->getRandomName();
                $missionPhoto->move($uploadPath, $missionPhotoName);
            }

            // 2b. Section 6 (CTA) Background Image
            $ctaPhoto = $this->request->getFile('cta_image');
            $ctaPhotoName = $row->cta_image ?? '';
            if ($ctaPhoto && $ctaPhoto->isValid() && !$ctaPhoto->hasMoved()) {
                if (!empty($ctaPhotoName) && file_exists($uploadPath . $ctaPhotoName)) {
                    @unlink($uploadPath . $ctaPhotoName);
                }
                $ctaPhotoName = $ctaPhoto->getRandomName();
                $ctaPhoto->move($uploadPath, $ctaPhotoName);
            }

            // 3. Section 2 Multiple Images (Network)
            $existingNetworkImages = $this->request->getPost('existing_network_images') ?? [];
            if (!is_array($existingNetworkImages)) {
                $existingNetworkImages = [];
            }

            // Delete removed images from disk
            $oldNetworkImages = !empty($row->network_images) ? json_decode($row->network_images, true) : [];
            if (is_array($oldNetworkImages)) {
                foreach ($oldNetworkImages as $oldImg) {
                    $imgFilename = is_array($oldImg) ? ($oldImg['image'] ?? '') : $oldImg;
                    if (!empty($imgFilename) && !in_array($imgFilename, $existingNetworkImages)) {
                        if (file_exists($uploadPath . $imgFilename)) {
                            @unlink($uploadPath . $imgFilename);
                        }
                    }
                }
            }

            // Upload new multiple images via CI4 FileCollection
            $uploadedNetworkFiles = $this->request->getFileMultiple('network_images');
            if (!empty($uploadedNetworkFiles)) {
                foreach ($uploadedNetworkFiles as $file) {
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move($uploadPath, $newName);
                        $existingNetworkImages[] = $newName;
                    }
                }
            }

            // Also check PHP native $_FILES fallback for multi-upload reliability
            if (!empty($_FILES['network_images']['name'])) {
                $fCount = is_array($_FILES['network_images']['name']) ? count($_FILES['network_images']['name']) : 0;
                for ($fi = 0; $fi < $fCount; $fi++) {
                    if (!empty($_FILES['network_images']['name'][$fi]) && !empty($_FILES['network_images']['tmp_name'][$fi])) {
                        $tmp = $_FILES['network_images']['tmp_name'][$fi];
                        if (is_uploaded_file($tmp)) {
                            $origName = $_FILES['network_images']['name'][$fi];
                            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                                $newName = 'about_net_' . time() . '_' . $fi . '.' . $ext;
                                if (move_uploaded_file($tmp, $uploadPath . $newName)) {
                                    $existingNetworkImages[] = $newName;
                                }
                            }
                        }
                    }
                }
            }

            // Section 4: Specialities
            $specTitles = $this->request->getPost('speciality_title') ?? [];
            $specIcons  = $this->request->getPost('speciality_icon') ?? [];
            $specDescs  = $this->request->getPost('speciality_desc') ?? [];
            $specList = [];
            if (!empty($specTitles) && is_array($specTitles)) {
                for ($s = 0; $s < count($specTitles); $s++) {
                    $st = trim($specTitles[$s] ?? '');
                    if ($st !== '') {
                        $specList[] = [
                            'title' => $st,
                            'icon'  => trim($specIcons[$s] ?? 'Sparkles'),
                            'desc'  => trim($specDescs[$s] ?? ''),
                        ];
                    }
                }
            }

            $update_data = [
                // Section 1: Saiyoojyam Ladies Hostels
                'about_subtitle'            => $this->request->getPost('about_subtitle'),
                'about_title'               => $this->request->getPost('about_title'),
                'about_description'         => $this->request->getPost('about_description'),
                'about_image'               => $aboutPhotoName,

                // Section 2: Saiyoojyam Hostels Network
                'network_subtitle'          => $this->request->getPost('network_subtitle'),
                'network_title'             => $this->request->getPost('network_title'),
                'network_description'       => $this->request->getPost('network_description'),
                'network_images'            => json_encode(array_values(array_filter(array_unique($existingNetworkImages)))),

                // Section 3: Mission & Vision
                'mission_subtitle'          => $this->request->getPost('mission_subtitle'),
                'mission_title'             => $this->request->getPost('mission_title'),
                'mission_description'       => $this->request->getPost('mission_description'),
                'vision_title'              => $this->request->getPost('vision_title'),
                'vision_description'        => $this->request->getPost('vision_description'),
                'mission_image'             => $missionPhotoName,

                // Section 4: Specialities
                'specialities_subtitle'     => $this->request->getPost('specialities_subtitle'),
                'specialities_title'        => $this->request->getPost('specialities_title'),
                'specialities_items'        => json_encode($specList),

                // Section 5: Neighbourhood Facilities
                'neighbourhood_subtitle'    => $this->request->getPost('neighbourhood_subtitle'),
                'neighbourhood_title'       => $this->request->getPost('neighbourhood_title'),
                'neighbourhood_description' => $this->request->getPost('neighbourhood_description'),
                'neighbourhood_landmarks'   => $this->request->getPost('neighbourhood_landmarks'),

                // Section 6: Call To Action
                'cta_title'                   => $this->request->getPost('cta_title'),
                'cta_description'             => $this->request->getPost('cta_description'),
                'cta_image'                   => $ctaPhotoName,
                'cta_whatsapp_number'         => $this->request->getPost('cta_whatsapp_number') ?? ($row->cta_whatsapp_number ?? '917034111368'),
                'cta_whatsapp_button_text'    => $this->request->getPost('cta_whatsapp_button_text'),
                'cta_secondary_button_text'   => $this->request->getPost('cta_secondary_button_text'),
                'cta_secondary_button_link'   => $this->request->getPost('cta_secondary_button_link'),
            ];

            // If table also has about_desc legacy column, mirror it
            if (in_array('about_desc', $fields)) {
                $update_data['about_desc'] = $this->request->getPost('about_description');
            }

            $db->table('saiyoojyam_about')->where($idCol, $currentId)->update($update_data);

            $flashdata = [
                'type' => 'success',
                'msg'  => 'About Us Sections Updated Successfully',
            ];
            $this->session->setFlashdata('alert', $flashdata);

            return redirect()->to(site_url('Admin/About/Edit/' . $currentId));
        }

        $data['about'] = $row;
        $data['idCol'] = $idCol;
        return view('admin/edit_about', $data);
    }

    public function DeleteNetworkImage($imgParam = '')
    {
        $this->ensureTable();
        $db = Database::connect();
        $fields = $db->getFieldNames('saiyoojyam_about');
        $idCol = in_array('about_id', $fields) ? 'about_id' : (in_array('id', $fields) ? 'id' : $fields[0]);

        $imgName = $this->request->getGet('img') ?? $this->request->getPost('img') ?? $imgParam;

        $row = $db->table('saiyoojyam_about')->get()->getRow();
        if (!empty($row) && !empty($imgName)) {
            $currentId = $row->{$idCol};
            $uploadPath = FCPATH . 'uploads/about/';

            $list = !empty($row->network_images) ? json_decode($row->network_images, true) : [];
            $newList = [];
            if (is_array($list)) {
                foreach ($list as $item) {
                    $filename = is_array($item) ? ($item['image'] ?? '') : $item;
                    if ($filename === $imgName) {
                        if (file_exists($uploadPath . $filename)) {
                            @unlink($uploadPath . $filename);
                        }
                    } else {
                        $newList[] = $item;
                    }
                }
            }

            $db->table('saiyoojyam_about')->where($idCol, $currentId)->update([
                'network_images' => json_encode(array_values($newList)),
            ]);

            $this->session->setFlashdata('alert', [
                'type' => 'success',
                'msg'  => 'Image deleted successfully',
            ]);
            return redirect()->to(site_url('Admin/About/Edit/' . $currentId . '#network_title'));
        }

        return redirect()->to(site_url('Admin/About/View'));
    }

    public function DeleteSectionImage($section = 'about')
    {
        $this->ensureTable();
        $db = Database::connect();
        $fields = $db->getFieldNames('saiyoojyam_about');
        $idCol = in_array('about_id', $fields) ? 'about_id' : (in_array('id', $fields) ? 'id' : $fields[0]);

        $row = $db->table('saiyoojyam_about')->get()->getRow();
        if (!empty($row)) {
            $currentId = $row->{$idCol};
            $uploadPath = FCPATH . 'uploads/about/';

            $col = ($section === 'mission') ? 'mission_image' : 'about_image';
            if (!empty($row->{$col}) && file_exists($uploadPath . $row->{$col})) {
                @unlink($uploadPath . $row->{$col});
            }

            $db->table('saiyoojyam_about')->where($idCol, $currentId)->update([$col => '']);

            $this->session->setFlashdata('alert', [
                'type' => 'success',
                'msg'  => 'Photo removed successfully',
            ]);
            return redirect()->to(site_url('Admin/About/Edit/' . $currentId));
        }

        return redirect()->to(site_url('Admin/About/View'));
    }
}
