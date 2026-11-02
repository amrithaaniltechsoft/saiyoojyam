<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class About extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db = Database::connect();
        if (!$db->tableExists('saiyoojyam_about')) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => null,
            ]);
        }

        $row = $db->table('saiyoojyam_about')->get()->getRow();
        if (empty($row)) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => null,
            ]);
        }

        $baseUrl = base_url();
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        // Helper to format image URLs
        $formatImage = function($imageVal) use ($baseUrl) {
            if (empty($imageVal)) return '';
            if (str_starts_with($imageVal, 'http://') || str_starts_with($imageVal, 'https://')) {
                return $imageVal;
            }
            return $baseUrl . 'uploads/about/' . $imageVal;
        };

        $aboutImg = $formatImage($row->about_image ?? '');
        $missionImg = $formatImage($row->mission_image ?? '');

        $introDesc = $row->about_description ?? $row->about_desc ?? '';
        $networkDesc = $row->network_description ?? '';
        $missionDesc = $row->mission_description ?? '';
        $visionDesc = $row->vision_description ?? '';

        $intro = [
            'subtitle'    => $row->about_subtitle ?? '',
            'title'       => $row->about_title ?? '',
            'description' => strip_tags($introDesc),
            'raw_desc'    => $introDesc,
            'image'       => $aboutImg,
            'image_name'  => $row->about_image ?? '',
        ];

        $networkImages = [];
        if (!empty($row->network_images)) {
            $decoded = json_decode($row->network_images, true);
            if (is_array($decoded)) {
                foreach ($decoded as $img) {
                    $imgFilename = is_array($img) ? ($img['image'] ?? '') : $img;
                    if (!empty($imgFilename)) {
                        $networkImages[] = [
                            'image'   => $formatImage($imgFilename),
                            'name'    => is_array($img) ? ($img['name'] ?? '') : '',
                            'tagline' => is_array($img) ? ($img['tagline'] ?? '') : '',
                        ];
                    }
                }
            }
        }

        $network = [
            'subtitle'    => $row->network_subtitle ?? '',
            'title'       => $row->network_title ?? '',
            'description' => strip_tags($networkDesc),
            'raw_desc'    => $networkDesc,
            'images'      => $networkImages,
        ];

        $mission = [
            'subtitle'          => $row->mission_subtitle ?? '',
            'mission_title'     => $row->mission_title ?? '',
            'mission_desc'      => strip_tags($missionDesc),
            'raw_mission_desc'  => $missionDesc,
            'vision_title'      => $row->vision_title ?? '',
            'vision_desc'       => strip_tags($visionDesc),
            'raw_vision_desc'   => $visionDesc,
            'image'             => $missionImg,
            'image_name'        => $row->mission_image ?? '',
        ];

        // 4. Specialities
        $specItems = [];
        if (!empty($row->specialities_items)) {
            $decodedSpec = json_decode($row->specialities_items, true);
            if (is_array($decodedSpec)) {
                $specItems = $decodedSpec;
            }
        }
        $specialities = [
            'subtitle' => $row->specialities_subtitle ?? '',
            'title'    => $row->specialities_title ?? '',
            'items'    => $specItems,
        ];

        // 5. Neighbourhood Facilities
        $neighbourhoodDesc = $row->neighbourhood_description ?? '';
        $landmarksRaw = $row->neighbourhood_landmarks ?? '';
        $landmarksList = [];
        if (!empty($landmarksRaw)) {
            $landmarksList = array_values(array_filter(array_map('trim', explode(',', $landmarksRaw))));
        }
        $neighbourhood = [
            'subtitle'    => $row->neighbourhood_subtitle ?? '',
            'title'       => $row->neighbourhood_title ?? '',
            'description' => strip_tags($neighbourhoodDesc),
            'raw_desc'    => $neighbourhoodDesc,
            'landmarks'   => $landmarksList,
        ];

        // 6. Call To Action (Looking for a comfortable home in Kakkanad?)
        $aboutWhatsapp = trim($row->cta_whatsapp_number ?? '');
        if (empty($aboutWhatsapp) && $db->tableExists('saiyoojyam_contact')) {
            $contactRow = $db->table('saiyoojyam_contact')->where('contact_id', 1)->get()->getRow();
            $num = !empty($contactRow->contact_whats_app) ? $contactRow->contact_whats_app : ($contactRow->contact_phone1 ?? '');
            if (!empty($num)) {
                $clean = preg_replace('/[^0-9]/', '', $num);
                if (strlen($clean) === 11 && str_starts_with($clean, '0')) {
                    $clean = substr($clean, 1);
                }
                if (strlen($clean) === 10) {
                    $clean = '91' . $clean;
                }
                $aboutWhatsapp = $clean;
            }
        }
        if (empty($aboutWhatsapp)) {
            $aboutWhatsapp = '918129339122';
        }

        $ctaImg = $formatImage($row->cta_image ?? '');
        $cta = [
            'title'                   => $row->cta_title ?? '',
            'description'             => $row->cta_description ?? '',
            'image'                   => $ctaImg,
            'image_name'              => $row->cta_image ?? '',
            'whatsapp_number'         => $aboutWhatsapp,
            'whatsapp_button_text'    => $row->cta_whatsapp_button_text ?? '',
            'secondary_button_text'   => $row->cta_secondary_button_text ?? '',
            'secondary_button_link'   => $row->cta_secondary_button_link ?? '',
        ];

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'intro'         => $intro,
                'network'       => $network,
                'mission'       => $mission,
                'specialities'  => $specialities,
                'neighbourhood' => $neighbourhood,
                'cta'           => $cta,
            ],
            // Backward compatibility array
            'intro_list' => [ $intro ],
        ]);
    }
}
