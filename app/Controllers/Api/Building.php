<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Building extends BaseController
{
    private function setCorsHeaders()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function index()
    {
        $this->setCorsHeaders();

        $buildings = $this->common_model->FetchAllOrder('saiyoojyam_building', 'building_id', 'ASC');
        $baseUrl = rtrim(base_url(), '/') . '/';

        $data = [];
        if (!empty($buildings)) {
            foreach ($buildings as $b) {
                $item = $this->formatBuildingData($b, $baseUrl);
                $data[] = $item;
            }
        }

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($data),
            'data'   => $data,
        ]);
    }

    public function detail($slug = '')
    {
        $this->setCorsHeaders();

        if (empty($slug)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Slug is required',
            ]);
        }

        $db = \Config\Database::connect();
        $slugClean = strtolower(trim($slug));

        // 1. Direct slug match
        $building = $db->table('saiyoojyam_building')
            ->where('LOWER(building_slug)', $slugClean)
            ->get()
            ->getRow();

        // 2. Try prefixed or name-matched or numeric ID
        if (empty($building)) {
            $builder = $db->table('saiyoojyam_building');
            if (is_numeric($slugClean)) {
                $builder->where('building_id', (int) $slugClean);
            } else {
                $builder->where('building_slug', 'saiyoojyam-' . $slugClean)
                        ->orLike('LOWER(building_name)', $slugClean);
            }
            $building = $builder->get()->getRow();
        }

        if (empty($building)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'Building not found',
            ]);
        }

        $baseUrl = rtrim(base_url(), '/') . '/';
        $formatted = $this->formatBuildingData($building, $baseUrl, $slugClean);

        return $this->response->setJSON([
            'status' => true,
            'data'   => $formatted,
        ]);
    }

    private function formatBuildingData($b, $baseUrl, $requestedSlug = '')
    {
        $dbSlug = strtolower(trim($b->building_slug ?? ''));
        $cleanSlug = trim(preg_replace('/^saiyoojyam[-_]/i', '', $dbSlug));

        if (!empty($cleanSlug)) {
            $slug = $cleanSlug;
        } elseif (!empty($dbSlug)) {
            $slug = $dbSlug;
        } elseif (!empty($requestedSlug)) {
            $slug = $requestedSlug;
        } else {
            $nameLower = strtolower(trim($b->building_name ?? ''));
            $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(str_replace('saiyoojyam', '', $nameLower)));
            $slug = trim($slug, '-');
            if (empty($slug)) {
                $slug = 'b-' . $b->building_id;
            }
        }

        $defaultConfig = $this->getDefaultBuildingData($slug);
        if (!$defaultConfig && (strpos($slug, 'tower') !== false || strpos(strtolower($b->building_name ?? ''), 'tower') !== false)) {
            $defaultConfig = $this->getDefaultBuildingData('towers');
        } elseif (!$defaultConfig && (strpos($slug, 'annex') !== false || strpos(strtolower($b->building_name ?? ''), 'annex') !== false)) {
            $defaultConfig = $this->getDefaultBuildingData('annex');
        }

        $moreImages = $this->common_model->FetchWhere('saiyoojyam_building_more_image', ['more_image_building_id' => $b->building_id]);

        $moreUrls = [];
        if (!empty($moreImages)) {
            foreach ($moreImages as $m) {
                if (!empty($m->more_image_name)) {
                    $moreUrls[] = $baseUrl . 'public/uploads/buildings/' . $m->more_image_name;
                }
            }
        }

        $mainImage = '';
        if (!empty($b->building_image)) {
            $mainImage = $baseUrl . 'public/uploads/buildings/' . $b->building_image;
        }

        // Parse key amenities from saiyoojyam_building.building_key_amenities
        $amenitiesGrid = [];
        if (!empty($b->building_key_amenities)) {
            $raw = trim($b->building_key_amenities);
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $amenitiesGrid = $decoded;
            } elseif (!empty($raw)) {
                $lines = preg_split('/[\r\n,]+/', $raw);
                foreach ($lines as $line) {
                    $item = trim($line, " \t\n\r\0\x0B-•*\"'[]{}");
                    if (!empty($item)) {
                        $amenitiesGrid[] = [
                            'title'    => $item,
                            'subtitle' => '',
                            'icon'     => 'Building',
                        ];
                    }
                }
            }
        }
        if (empty($amenitiesGrid) && !empty($defaultConfig['amenitiesGrid'])) {
            $amenitiesGrid = $defaultConfig['amenitiesGrid'];
        }

        // Parse living facilities from saiyoojyam_building.building_living_facilities
        $featuresList = [];
        if (!empty($b->building_living_facilities)) {
            $raw = trim($b->building_living_facilities);
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $featuresList = $decoded;
            } elseif (!empty($raw)) {
                $lines = preg_split('/[\r\n,]+/', $raw);
                foreach ($lines as $line) {
                    $item = trim($line, " \t\n\r\0\x0B-•*\"'[]{}");
                    if (!empty($item)) {
                        $featuresList[] = $item;
                    }
                }
            }
        }
        if (empty($featuresList) && !empty($defaultConfig['featuresList'])) {
            $featuresList = $defaultConfig['featuresList'];
        }

        // Clean map embed
        $mapEmbed = $b->building_map ?? '';
        if (!empty($mapEmbed) && preg_match('/src=["\']([^"\']+)["\']/', $mapEmbed, $matches)) {
            $mapEmbed = $matches[1];
        }
        if (empty($mapEmbed) && !empty($defaultConfig['mapEmbedUrl'])) {
            $mapEmbed = $defaultConfig['mapEmbedUrl'];
        }

        $tagline = $b->building_tagline ?? '';
        if (empty($tagline) || stripos($tagline, 'sfsdfsd') !== false) {
            $tagline = !empty($defaultConfig['tagline']) ? $defaultConfig['tagline'] : '';
        }
        $bName = trim(preg_replace('/\s*\(?\b(?:sfsdfsd)\b\)?/i', '', $b->building_name ?? ''));
        if (empty($bName)) {
            $bName = $b->building_name ?? '';
        }
        $address = !empty($b->building_address) ? $b->building_address : ($defaultConfig['address'] ?? '');
        $mapDirectUrl = !empty($b->building_map_link) ? $b->building_map_link : ($defaultConfig['mapDirectUrl'] ?? '');
        $whatsapp = !empty($b->building_whatsapp) ? trim($b->building_whatsapp) : '';
        if (empty($whatsapp)) {
            $db = Database::connect();
            if ($db->tableExists('saiyoojyam_contact')) {
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
                    $whatsapp = $clean;
                }
            }
        }
        if (empty($whatsapp)) {
            $whatsapp = !empty($defaultConfig['whatsapp']) ? $defaultConfig['whatsapp'] : '918129339122';
        }
        $description = !empty($b->building_description) ? $b->building_description : ($defaultConfig['description'] ?? '');

        // Combined images array for home page cards and carousels
        $imagesList = [];
        if (!empty($mainImage)) {
            $imagesList[] = $mainImage;
        }
        if (!empty($moreUrls)) {
            $imagesList = array_merge($imagesList, $moreUrls);
        }
        if (empty($imagesList) && !empty($defaultConfig['images'])) {
            $imagesList = $defaultConfig['images'];
            if (empty($mainImage) && !empty($imagesList[0])) {
                $mainImage = $imagesList[0];
            }
        }

        $location = 'Kakkanad, Kochi';
        if (!empty($b->building_address)) {
            $parts = array_filter(array_map('trim', explode(',', $b->building_address)));
            if (count($parts) >= 2) {
                $location = implode(', ', array_slice($parts, -2));
            } else {
                $location = $b->building_address;
            }
        }

        return [
            'id'                        => (int) $b->building_id,
            'building_id'               => (int) $b->building_id,
            'slug'                      => $slug,
            'name'                      => $bName,
            'building_name'             => $bName,
            'location'                  => $location,
            'tagline'                   => $tagline,
            'building_tagline'          => $tagline,
            'address'                   => $address,
            'building_address'          => !empty($b->building_address) ? $b->building_address : $address,
            'description'               => $description,
            'building_description'      => $description,
            'bookingFormWhatsappNumber' => $whatsapp,
            'mapEmbedUrl'               => $mapEmbed,
            'mapDirectUrl'              => $mapDirectUrl,
            'mainImage'                 => $mainImage,
            'building_image'            => $mainImage,
            'moreImages'                => $moreUrls,
            'images'                    => $imagesList,
            'amenitiesGrid'             => $amenitiesGrid,
            'building_key_amenities'    => $amenitiesGrid,
            'featuresList'              => $featuresList,
            'building_living_facilities'=> $featuresList,
            'metaTitle'                 => $b->building_meta_title ?? '',
            'metaDescription'           => $b->building_meta_description ?? '',
            'metaKeywords'              => $b->building_meta_keywords ?? '',
        ];
    }

    private function getDefaultBuildingData($slug)
    {
        $defaults = [
            'premier' => [
                'location' => 'Infopark Road, Kakkanad',
                'images' => [
                    '/buildings/saiyoojyam-premier/s1.png',
                    '/buildings/saiyoojyam-premier/s2.webp',
                    '/buildings/saiyoojyam-premier/s3.jpg',
                    '/buildings/saiyoojyam-premier/s4.webp',
                    '/buildings/saiyoojyam-premier/s5.webp',
                ],
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
                'location' => 'Kuzhikkattumoola, Kakkanad',
                'images' => [
                    '/buildings/saiyoojyam-annex/s1.png',
                    '/buildings/saiyoojyam-annex/s2.webp',
                    '/buildings/saiyoojyam-annex/s3.webp',
                    '/buildings/saiyoojyam-annex/s4.webp',
                    '/buildings/saiyoojyam-annex/s5.webp',
                ],
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
                'location' => 'Painakkil Jn, Kusumagiri',
                'images' => [
                    '/buildings/saiyoojyam-towers/s1.png',
                    '/buildings/saiyoojyam-towers/s2.webp',
                    '/buildings/saiyoojyam-towers/s3.webp',
                    '/buildings/saiyoojyam-towers/s4.webp',
                ],
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
}
