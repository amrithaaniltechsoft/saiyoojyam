<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class FoodQuality extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $adminController = new \App\Controllers\Admin\FoodQuality();
        $adminController->ensureTable();

        $db = Database::connect();
        if (!$db->tableExists('saiyoojyam_food_quality')) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => null,
            ]);
        }

        $row = $db->table('saiyoojyam_food_quality')->get()->getRow();
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

        $formatImage = function($imageVal) use ($baseUrl) {
            if (empty($imageVal)) return '';
            if (str_starts_with($imageVal, 'http://') || str_starts_with($imageVal, 'https://') || str_starts_with($imageVal, '/')) {
                return $imageVal;
            }
            return $baseUrl . 'uploads/food/' . $imageVal;
        };

        // 1. Hero
        $heroImage = $formatImage($row->hero_image ?? '');
        if (empty($heroImage)) {
            $heroImage = '/why-us/food-quality.png';
        }

        $hero = [
            'subtitle'    => $row->hero_subtitle ?? 'Hygienic • Nutritious • Homely Meals',
            'title'       => $row->hero_title ?? 'Wholesome & Homely Food Quality',
            'description' => $row->hero_description ?? '',
            'image'       => $heroImage,
            'image_name'  => $row->hero_image ?? '',
        ];

        // 2. Pillars
        $rawPillars = !empty($row->pillars_items) ? json_decode($row->pillars_items, true) : [];
        if (!is_array($rawPillars)) {
            $rawPillars = [];
        }

        $pillars = [
            'subtitle'    => $row->pillars_subtitle ?? 'Our Food Commitment',
            'title'       => $row->pillars_title ?? 'Quality Food You Can Truly Trust Every Day',
            'description' => $row->pillars_description ?? '',
            'items'       => $rawPillars,
        ];

        // 3. Menu Schedule & Weekly Timetable
        $rawSchedule = !empty($row->menu_schedule) ? json_decode($row->menu_schedule, true) : [];
        if (!is_array($rawSchedule)) {
            $rawSchedule = [];
        }

        $rawWeeklySchedule = !empty($row->weekly_schedule) ? json_decode($row->weekly_schedule, true) : [];
        if (!is_array($rawWeeklySchedule)) {
            $rawWeeklySchedule = [];
        }

        $menu = [
            'subtitle'        => $row->menu_subtitle ?? 'Weekly Food Routine',
            'title'           => $row->menu_title ?? 'Weekly Food Menu & Timetable',
            'description'     => $row->menu_description ?? '',
            'schedule'        => $rawSchedule,
            'weeklySchedule'  => $rawWeeklySchedule,
        ];

        // 4. Gallery
        $rawGallery = !empty($row->gallery_images) ? json_decode($row->gallery_images, true) : [];
        if (!is_array($rawGallery)) {
            $rawGallery = [];
        }
        $formattedGallery = [];
        foreach ($rawGallery as $g) {
            $imgSrc = $formatImage($g['image'] ?? '');
            if (!empty($imgSrc)) {
                $formattedGallery[] = [
                    'image'   => $imgSrc,
                    'title'   => $g['title'] ?? 'Campus Dining Space',
                    'caption' => $g['caption'] ?? '',
                ];
            }
        }

        $gallery = [
            'subtitle'    => $row->gallery_subtitle ?? 'Campus Dining Experience',
            'title'       => $row->gallery_title ?? 'Glimpse of Our Dining & Kitchen Spaces',
            'description' => $row->gallery_description ?? '',
            'items'       => $formattedGallery,
        ];

        // 5. FAQs
        $rawFaqs = !empty($row->faq_items) ? json_decode($row->faq_items, true) : [];
        if (!is_array($rawFaqs)) {
            $rawFaqs = [];
        }

        $faqs = [
            'subtitle'    => $row->faq_subtitle ?? 'Dining FAQ',
            'title'       => $row->faq_title ?? 'Frequently Asked Questions',
            'description' => $row->faq_description ?? '',
            'items'       => $rawFaqs,
        ];

        // 6. CTA
        $foodQualityWhatsapp = trim($row->cta_whatsapp_number ?? '');
        if (empty($foodQualityWhatsapp) || $foodQualityWhatsapp === '917034111368') {
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
                $foodQualityWhatsapp = $clean;
            }
        }
        if (empty($foodQualityWhatsapp)) {
            $foodQualityWhatsapp = '918129339122';
        }

        $cta = [
            'title'                 => $row->cta_title ?? 'Have Special Dietary Questions?',
            'description'           => $row->cta_description ?? '',
            'whatsapp_number'       => $foodQualityWhatsapp,
            'whatsapp_button_text'  => $row->cta_whatsapp_button_text ?? 'Chat on WhatsApp',
            'secondary_button_text' => $row->cta_secondary_button_text ?? 'Explore Rooms',
            'secondary_button_link' => $row->cta_secondary_button_link ?? '/search',
        ];

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'hero'     => $hero,
                'pillars'  => $pillars,
                'menu'     => $menu,
                'gallery'  => $gallery,
                'faqs'     => $faqs,
                'cta'      => $cta,
            ],
        ]);
    }
}
