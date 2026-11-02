<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Contact extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->response->setHeader('Pragma', 'no-cache');

        $db = Database::connect();
        if (!$db->tableExists('saiyoojyam_contact')) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => null,
            ]);
        }

        $row = $db->table('saiyoojyam_contact')->where('contact_id', 1)->get()->getRow();
        if (empty($row)) {
            $row = $db->table('saiyoojyam_contact')->get()->getRow();
        }

        if (empty($row)) {
            return $this->response->setJSON([
                'status' => true,
                'data'   => null,
            ]);
        }

        // WhatsApp number from contact_whats_app, fallback to contact_phone1
        $whatsapp = trim($row->contact_whats_app ?? '');
        if (empty($whatsapp)) {
            $whatsapp = trim($row->contact_phone1 ?? '');
        }

        $cleanWhatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
        if (strlen($cleanWhatsapp) === 11 && str_starts_with($cleanWhatsapp, '0')) {
            $cleanWhatsapp = substr($cleanWhatsapp, 1);
        }
        if (strlen($cleanWhatsapp) === 10) {
            $cleanWhatsapp = '91' . $cleanWhatsapp;
        }

        // Primary Phone from contact_phone1, fallback to whatsapp
        $phone1 = trim($row->contact_phone1 ?? '');
        if (empty($phone1)) {
            $phone1 = $whatsapp;
        }

        $cleanPhone1 = preg_replace('/[^0-9]/', '', $phone1);
        if (strlen($cleanPhone1) === 11 && str_starts_with($cleanPhone1, '0')) {
            $cleanPhone1 = substr($cleanPhone1, 1);
        }
        if (strlen($cleanPhone1) === 10) {
            $cleanPhone1 = '91' . $cleanPhone1;
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'phone'             => $phone1,
                'contact_phone1'    => $phone1,
                'clean_phone'       => $cleanPhone1,
                'whatsapp'          => $whatsapp,
                'contact_whats_app' => $whatsapp,
                'whatsapp_clean'    => $cleanWhatsapp,
                'email'             => trim($row->contact_email1 ?? ''),
                'contact_email1'    => trim($row->contact_email1 ?? ''),
                'instagram'         => trim($row->contact_instagram ?? ''),
                'facebook'          => trim($row->contact_facebook ?? ''),
                'youtube'           => trim($row->contact_youtube ?? ''),
            ],
        ]);
    }
}

