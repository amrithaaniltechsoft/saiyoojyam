<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class FoodQuality extends BaseController
{
    public function ensureTable()
    {
        $db = Database::connect();
        if (!$db->tableExists('saiyoojyam_food_quality')) {
            $db->query("CREATE TABLE IF NOT EXISTS `saiyoojyam_food_quality` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `hero_subtitle` varchar(255) DEFAULT 'Hygienic • Nutritious • Homely Meals',
              `hero_title` varchar(255) DEFAULT 'Wholesome & Homely Food Quality',
              `hero_description` text DEFAULT NULL,
              `hero_image` varchar(255) DEFAULT NULL,
              `pillars_subtitle` varchar(255) DEFAULT 'Our Food Commitment',
              `pillars_title` varchar(255) DEFAULT 'Quality Food You Can Truly Trust Every Day',
              `pillars_description` text DEFAULT NULL,
              `pillars_items` longtext DEFAULT NULL,
              `menu_subtitle` varchar(255) DEFAULT 'Daily Routine',
              `menu_title` varchar(255) DEFAULT 'Our Daily Meal Schedule & Menu',
              `menu_description` text DEFAULT NULL,
              `menu_schedule` longtext DEFAULT NULL,
              `gallery_subtitle` varchar(255) DEFAULT 'Campus Dining Experience',
              `gallery_title` varchar(255) DEFAULT 'Glimpse of Our Dining & Kitchen Spaces',
              `gallery_description` text DEFAULT NULL,
              `gallery_images` longtext DEFAULT NULL,
              `faq_subtitle` varchar(255) DEFAULT 'Dining FAQ',
              `faq_title` varchar(255) DEFAULT 'Frequently Asked Questions',
              `faq_description` text DEFAULT NULL,
              `faq_items` longtext DEFAULT NULL,
              `cta_title` varchar(255) DEFAULT 'Have Special Dietary Questions?',
              `cta_description` text DEFAULT NULL,
              `cta_whatsapp_number` varchar(50) DEFAULT '917034111368',
              `cta_whatsapp_button_text` varchar(100) DEFAULT 'Chat on WhatsApp',
              `cta_secondary_button_text` varchar(100) DEFAULT 'Explore Rooms',
              `cta_secondary_button_link` varchar(255) DEFAULT '/search',
              `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        $row = $db->table('saiyoojyam_food_quality')->get()->getRow();
        if (empty($row)) {
            $defaultPillars = [
                [
                    'title' => '100% Homely & Healthy Cooking',
                    'subtitle' => 'Just like home, never commercialized',
                    'description' => 'We prepare meals with fresh daily vegetables, high-grade spices, and optimal oil levels. We completely avoid MSG, tasting powders, or artificial food colorings, ensuring easy digestion and consistent well-being.',
                    'icon' => 'Heart'
                ],
                [
                    'title' => 'Punctual Morning Routine (7:30 AM)',
                    'subtitle' => 'Hot breakfast & packed lunch ready early',
                    'description' => 'We understand corporate shifts at Infopark, SmartCity, and college lecture schedules. Both warm breakfast and packed tiffin lunchboxes are ready by 7:30 AM sharp, so you never rush on an empty stomach.',
                    'icon' => 'Clock'
                ],
                [
                    'title' => '24/7 Pure Boiled Water & RO Plant',
                    'subtitle' => 'Zero compromise on hydration & purity',
                    'description' => 'Our hostels feature advanced multi-stage RO water treatment plants along with warm, boiled herbal drinking water available 24 hours a day, safeguarding residents against water-borne illnesses.',
                    'icon' => 'Droplets'
                ],
                [
                    'title' => 'Hygienic Dining & Clean Cookware',
                    'subtitle' => 'Sanitized preparation and dining halls',
                    'description' => 'Cooking areas and stainless-steel cookware are thoroughly sterilized after every meal session. Spacious, well-ventilated dining halls offer a clean, relaxed environment to dine with your fellow hostel mates.',
                    'icon' => 'Sparkles'
                ]
            ];

            $defaultMenuSchedule = [
                [
                    'meal' => 'Morning Breakfast',
                    'time' => '7:00 AM – 9:00 AM',
                    'readyNote' => 'Fresh & piping hot',
                    'badge' => 'Energizing Start',
                    'icon' => 'Sun',
                    'menuItems' => [
                        'Steamed Idli with fresh Coconut Chutney & Kerala Sambar',
                        'Crispy Dosa with Tomato Onion Chutney & Podi',
                        'Traditional Kerala Puttu paired with aromatic Kadala Curry',
                        'Soft Appam with vegetable or egg stew',
                        'Fluffy Poori served with lightly spiced Potato Masala',
                        'Semolina Vegetable Upma with ripe bananas'
                    ]
                ],
                [
                    'meal' => 'Packed Lunch Tiffin',
                    'time' => 'Ready by 7:30 AM',
                    'readyNote' => 'Convenient for office & college',
                    'badge' => 'Office Ready',
                    'icon' => 'Soup',
                    'menuItems' => [
                        'Fragrant Kuruva/Matta rice or Ponni white rice',
                        'Flavourful Kerala Sambar, Moru Curry, or Dal Fry',
                        'Seasonal Vegetable Thoran (Cabbage, Beans, Carrot, Beetroot)',
                        'Crisp Vegetable Mezhukkupuratti & Papadam',
                        'Tangy homemade lemon / mango pickles',
                        'Nutritious Curd or spiced Butter Milk on select days'
                    ]
                ],
                [
                    'meal' => 'Evening Tea & Snacks',
                    'time' => '5:30 PM – 6:30 PM',
                    'readyNote' => 'Post-work refreshment',
                    'badge' => 'Relaxation',
                    'icon' => 'Coffee',
                    'menuItems' => [
                        'Freshly brewed hot Tea (Chai) and South Indian Filter Coffee',
                        'Light evening snacks (Biscuits, Banana Fritters, Veg Cutlets, or Sundal)',
                        'Refreshing and quiet break in the hostel dining area',
                        'Electric kettle & hot water available for late arrivals'
                    ]
                ],
                [
                    'meal' => 'Wholesome Dinner',
                    'time' => '8:00 PM – 9:30 PM',
                    'readyNote' => 'Served warm till gate closing',
                    'badge' => 'Nutritious & Light',
                    'icon' => 'Moon',
                    'menuItems' => [
                        'Soft, whole wheat handmade Chapatis / Rotis',
                        'Paneer Butter Masala, Mixed Veg Kurma, or Dal Tadka',
                        'Non-Veg specials on scheduled weekly nights (Chicken curry/fish fry)',
                        'Light boiled rice with nourishing rasam for light digestion',
                        'Clean dining setup with reheating facilities if needed'
                    ]
                ]
            ];

            $defaultGallery = [
                [
                    'image' => '/why-us/food-quality.png',
                    'title' => 'Nutritious Homely Cooking',
                    'caption' => 'Prepared with top-quality grains, fresh seasonal vegetables, and genuine home recipes.'
                ],
                [
                    'image' => '/why-us/dining.png',
                    'title' => 'Spacious & Clean Dining Hall',
                    'caption' => 'A bright, well-organized communal dining hall fostering friendly interactions among residents.'
                ],
                [
                    'image' => '/why-us/dining2.png',
                    'title' => 'Hygienic Modern Kitchen Facility',
                    'caption' => 'Clean countertops, separate wash area, food storage refrigerator, and strict daily maintenance.'
                ],
                [
                    'image' => '/home-hero/h1.png',
                    'title' => 'Pure Drinking Water & Refreshments',
                    'caption' => '24/7 boiled herbal drinking water and advanced multi-stage RO water purification plant.'
                ]
            ];

            $defaultFaqs = [
                [
                    'q' => 'What time are morning breakfast and packed lunch tiffins ready?',
                    'a' => 'Both fresh breakfast and packed lunch tiffin boxes are ready by 7:30 AM every morning. This ensures that working women catching office cabs to Infopark / SmartCity or students attending early lectures at Rajagiri or Jain University never miss their meals.'
                ],
                [
                    'q' => 'What kind of drinking water is provided?',
                    'a' => 'We provide clean, purified drinking water from multi-stage RO filtration plants. Additionally, boiled warm drinking water is available 24/7 for residents.'
                ],
                [
                    'q' => 'Do you accommodate both North Indian and South Indian food preferences?',
                    'a' => 'Yes! Our menu features a wholesome combination of Kerala traditional dishes (such as Puttu, Appam, Idli, Dosa, Sambar, Moru curry) and North Indian staples (warm whole-wheat Chapatis, Rotis, Dal Tadka, and mixed vegetable curries).'
                ],
                [
                    'q' => 'Can I store my personal snacks or beverages?',
                    'a' => 'Yes. Every property provides common refrigerators and pantry counters in the dining area where inmates can keep labeled personal fruits, juices, or dairy items.'
                ],
                [
                    'q' => 'What if I get delayed at office and miss dinner time?',
                    'a' => 'Dinner is served between 8:00 PM and 9:30 PM, and food is kept warm. Inmates returning close to gate closure (10:00 PM) can still enjoy their warm dinner in the dining hall.'
                ]
            ];

            $db->table('saiyoojyam_food_quality')->insert([
                'hero_subtitle'             => 'Hygienic • Nutritious • Homely Meals',
                'hero_title'                => 'Wholesome & Homely Food Quality',
                'hero_description'          => 'Good health begins with pure, comforting food. At Saiyoojyam Hostels, our meals are freshly cooked with motherly care, zero artificial taste enhancers, and delivered punctually to match the demanding schedules of IT professionals and students near Kakkanad.',
                'hero_image'                => '',
                'pillars_subtitle'          => 'Our Food Commitment',
                'pillars_title'             => 'Quality Food You Can Truly Trust Every Day',
                'pillars_description'       => 'For working women living away from family, healthy food is the biggest concern. We take personal pride in serving home-style meals that bring energy, comfort, and peace of mind.',
                'pillars_items'             => json_encode($defaultPillars),
                'menu_subtitle'             => 'Daily Routine',
                'menu_title'                => 'Our Daily Meal Schedule & Menu',
                'menu_description'          => 'Enjoy a balanced combination of traditional Kerala home cooking and popular North Indian staples, thoughtfully portioned to provide clean, healthy fuel throughout the day.',
                'menu_schedule'             => json_encode($defaultMenuSchedule),
                'gallery_subtitle'          => 'Campus Dining Experience',
                'gallery_title'             => 'Glimpse of Our Dining & Kitchen Spaces',
                'gallery_description'       => 'Take a look inside our clean dining environments and food preparation areas maintained daily across our Kakkanad hostel properties.',
                'gallery_images'            => json_encode($defaultGallery),
                'faq_subtitle'              => 'Dining FAQ',
                'faq_title'                 => 'Frequently Asked Questions',
                'faq_description'           => 'Everything you need to know about dining routines, food quality, and kitchen facilities.',
                'faq_items'                 => json_encode($defaultFaqs),
                'cta_title'                 => 'Have Special Dietary Questions?',
                'cta_description'           => 'Reach out to our hostel team anytime on WhatsApp. We are happy to walk you through our weekly menu, food hygiene standards, and room tariffs.',
                'cta_whatsapp_number'       => '917034111368',
                'cta_whatsapp_button_text'  => 'Chat on WhatsApp',
                'cta_secondary_button_text' => 'Explore Rooms',
                'cta_secondary_button_link' => '/search'
            ]);
        }
    }

    public function index()
    {
        $this->ensureTable();
        $db = Database::connect();
        $data['food'] = $db->table('saiyoojyam_food_quality')->get()->getRow();
        return view('admin/edit_food_quality', $data);
    }

    public function View()
    {
        return $this->index();
    }

    public function Edit($id = 1)
    {
        $this->ensureTable();
        $db = Database::connect();
        $row = $db->table('saiyoojyam_food_quality')->get()->getRow();

        if ($this->request->getMethod() === 'POST') {
            $uploadPath = FCPATH . 'uploads/food/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // 1. Hero Image
            $heroPhoto = $this->request->getFile('hero_image');
            $heroPhotoName = $row->hero_image ?? '';
            if ($heroPhoto && $heroPhoto->isValid() && !$heroPhoto->hasMoved()) {
                if (!empty($heroPhotoName) && file_exists($uploadPath . $heroPhotoName)) {
                    @unlink($uploadPath . $heroPhotoName);
                }
                $heroPhotoName = $heroPhoto->getRandomName();
                $heroPhoto->move($uploadPath, $heroPhotoName);
            }

            // 2. Pillars items
            $pillarTitles = $this->request->getPost('pillar_title') ?? [];
            $pillarSubtitles = $this->request->getPost('pillar_subtitle') ?? [];
            $pillarDescs = $this->request->getPost('pillar_desc') ?? [];
            $pillarIcons = $this->request->getPost('pillar_icon') ?? [];
            $pillars = [];
            for ($i = 0; $i < count($pillarTitles); $i++) {
                if (!empty(trim($pillarTitles[$i]))) {
                    $pillars[] = [
                        'title' => trim($pillarTitles[$i]),
                        'subtitle' => trim($pillarSubtitles[$i] ?? ''),
                        'description' => trim($pillarDescs[$i] ?? ''),
                        'icon' => trim($pillarIcons[$i] ?? 'Sparkles'),
                    ];
                }
            }

            // 3. Menu items
            $mealNames = $this->request->getPost('meal_name') ?? [];
            $mealTimes = $this->request->getPost('meal_time') ?? [];
            $mealNotes = $this->request->getPost('meal_note') ?? [];
            $mealBadges = $this->request->getPost('meal_badge') ?? [];
            $mealIcons = $this->request->getPost('meal_icon') ?? [];
            $mealItemsRaw = $this->request->getPost('meal_items') ?? [];
            $meals = [];
            for ($i = 0; $i < count($mealNames); $i++) {
                if (!empty(trim($mealNames[$i]))) {
                    $rawLines = explode("\n", str_replace("\r", "", $mealItemsRaw[$i] ?? ''));
                    $cleanLines = [];
                    foreach ($rawLines as $line) {
                        $trimmed = trim($line);
                        if (!empty($trimmed)) {
                            $cleanLines[] = ltrim($trimmed, '-• ');
                        }
                    }
                    $meals[] = [
                        'meal' => trim($mealNames[$i]),
                        'time' => trim($mealTimes[$i] ?? ''),
                        'readyNote' => trim($mealNotes[$i] ?? ''),
                        'badge' => trim($mealBadges[$i] ?? ''),
                        'icon' => trim($mealIcons[$i] ?? 'Utensils'),
                        'menuItems' => $cleanLines
                    ];
                }
            }

            // 4. Gallery Images (update captions, titles, and replacement images)
            $existingGallery = !empty($row->gallery_images) ? json_decode($row->gallery_images, true) : [];
            if (!is_array($existingGallery)) {
                $existingGallery = [];
            }

            // Update captions/titles and replacement image for existing gallery items
            $gTitles = $this->request->getPost('gallery_item_title') ?? [];
            $gCaptions = $this->request->getPost('gallery_item_caption') ?? [];
            foreach ($existingGallery as $gIdx => &$gItem) {
                if (isset($gTitles[$gIdx])) {
                    $gItem['title'] = trim($gTitles[$gIdx]);
                }
                if (isset($gCaptions[$gIdx])) {
                    $gItem['caption'] = trim($gCaptions[$gIdx]);
                }

                // Check if user uploaded a replacement image for this specific gallery item
                $replacementFile = $this->request->getFile("gallery_item_file_{$gIdx}");
                if ($replacementFile && $replacementFile->isValid() && !$replacementFile->hasMoved()) {
                    $oldImg = $gItem['image'] ?? '';
                    if (!empty($oldImg) && !str_starts_with($oldImg, '/') && !str_starts_with($oldImg, 'http')) {
                        $oldPath = $uploadPath . $oldImg;
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }
                    $newImgName = $replacementFile->getRandomName();
                    $replacementFile->move($uploadPath, $newImgName);
                    $gItem['image'] = $newImgName;
                }
            }
            unset($gItem);

            // 5. FAQ items
            $faqQs = $this->request->getPost('faq_q') ?? [];
            $faqAs = $this->request->getPost('faq_a') ?? [];
            $faqs = [];
            for ($i = 0; $i < count($faqQs); $i++) {
                if (!empty(trim($faqQs[$i]))) {
                    $faqs[] = [
                        'q' => trim($faqQs[$i]),
                        'a' => trim($faqAs[$i] ?? '')
                    ];
                }
            }

            // Build update array
            $updateData = [
                'hero_subtitle'             => $this->request->getPost('hero_subtitle'),
                'hero_title'                => $this->request->getPost('hero_title'),
                'hero_description'          => $this->request->getPost('hero_description'),
                'hero_image'                => $heroPhotoName,
                'pillars_subtitle'          => $this->request->getPost('pillars_subtitle'),
                'pillars_title'             => $this->request->getPost('pillars_title'),
                'pillars_description'       => $this->request->getPost('pillars_description'),
                'pillars_items'             => json_encode($pillars),
                'menu_subtitle'             => $this->request->getPost('menu_subtitle'),
                'menu_title'                => $this->request->getPost('menu_title'),
                'menu_description'          => $this->request->getPost('menu_description'),
                'menu_schedule'             => json_encode($meals),
                'gallery_subtitle'          => $this->request->getPost('gallery_subtitle'),
                'gallery_title'             => $this->request->getPost('gallery_title'),
                'gallery_description'       => $this->request->getPost('gallery_description'),
                'gallery_images'            => json_encode($existingGallery),
                'faq_subtitle'              => $this->request->getPost('faq_subtitle'),
                'faq_title'                 => $this->request->getPost('faq_title'),
                'faq_description'           => $this->request->getPost('faq_description'),
                'faq_items'                 => json_encode($faqs),
                'cta_title'                 => $this->request->getPost('cta_title'),
                'cta_description'           => $this->request->getPost('cta_description'),
                'cta_whatsapp_number'       => $this->request->getPost('cta_whatsapp_number'),
                'cta_whatsapp_button_text'  => $this->request->getPost('cta_whatsapp_button_text'),
                'cta_secondary_button_text' => $this->request->getPost('cta_secondary_button_text'),
                'cta_secondary_button_link' => $this->request->getPost('cta_secondary_button_link'),
                'updated_at'                => date('Y-m-d H:i:s'),
            ];

            $db->table('saiyoojyam_food_quality')->where('id', $row->id)->update($updateData);

            $this->session->setFlashdata('alert', [
                'type' => 'success',
                'msg'  => 'Food Quality page updated successfully!'
            ]);

            return redirect()->to(site_url('Admin/FoodQuality'));
        }

        $data['food'] = $row;
        return view('admin/edit_food_quality', $data);
    }

    public function DeleteGalleryImage($index = null)
    {
        $this->ensureTable();
        $db = Database::connect();
        $row = $db->table('saiyoojyam_food_quality')->get()->getRow();

        if (!empty($row) && $index !== null) {
            $gallery = !empty($row->gallery_images) ? json_decode($row->gallery_images, true) : [];
            if (isset($gallery[$index])) {
                $imgName = $gallery[$index]['image'] ?? '';
                $uploadPath = FCPATH . 'uploads/food/';
                if (!empty($imgName) && file_exists($uploadPath . $imgName)) {
                    @unlink($uploadPath . $imgName);
                }
                array_splice($gallery, $index, 1);
                $db->table('saiyoojyam_food_quality')->where('id', $row->id)->update([
                    'gallery_images' => json_encode(array_values($gallery))
                ]);
                $this->session->setFlashdata('alert', [
                    'type' => 'success',
                    'msg'  => 'Gallery image deleted successfully.'
                ]);
            }
        }

        return redirect()->to(site_url('Admin/FoodQuality#section_gallery'));
    }

    public function DeleteHeroImage()
    {
        $this->ensureTable();
        $db = Database::connect();
        $row = $db->table('saiyoojyam_food_quality')->get()->getRow();

        if (!empty($row) && !empty($row->hero_image)) {
            $uploadPath = FCPATH . 'uploads/food/';
            if (file_exists($uploadPath . $row->hero_image)) {
                @unlink($uploadPath . $row->hero_image);
            }
            $db->table('saiyoojyam_food_quality')->where('id', $row->id)->update([
                'hero_image' => ''
            ]);
            $this->session->setFlashdata('alert', [
                'type' => 'success',
                'msg'  => 'Hero image reset.'
            ]);
        }

        return redirect()->to(site_url('Admin/FoodQuality#section_hero'));
    }
}
