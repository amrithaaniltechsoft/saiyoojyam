<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Cms extends BaseController
{
    public function proprietor()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db = Database::connect();

        // Find proprietor record in saiyoojyam_cms
        // 1. Try finding by id = 4 (default proprietor record)
        $item = $db->table('saiyoojyam_cms')->where('id', 4)->get()->getRow();

        // 2. Try by title containing 'Sasidharan' or page = 'proprietor' or page = 'Home'
        if (empty($item)) {
            $item = $db->table('saiyoojyam_cms')
                ->groupStart()
                    ->like('cms_tittle', 'Sasidharan')
                    ->orLike('page', 'proprietor')
                    ->orWhere('page', 'Home')
                ->groupEnd()
                ->get()
                ->getRow();
        }

        // 3. Fallback to first available record
        if (empty($item)) {
            $item = $db->table('saiyoojyam_cms')->get()->getRow();
        }

        if (empty($item)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'No CMS record found',
                'data'    => null,
            ]);
        }

        $baseUrl = base_url();
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        $imageUrl = '';
        $thumbUrl = '';
        if (!empty($item->cms_img)) {
            $imageUrl = $baseUrl . 'uploads/cms/' . $item->cms_img;
            $thumbUrl = $baseUrl . 'uploads/cms/thumbs/' . $item->cms_img;
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'id'          => (int) $item->id,
                'page'        => $item->page ?? '',
                'title'       => $item->cms_tittle ?? '',
                'description' => strip_tags($item->cms_desc ?? ''),
                'raw_desc'    => $item->cms_desc ?? '',
                'image'       => $imageUrl,
                'thumb'       => $thumbUrl,
                'image_name'  => $item->cms_img ?? '',
            ],
        ]);
    }

    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db   = Database::connect();
        $page = $this->request->getGet('page');
        $id   = $this->request->getGet('id');

        $baseUrl = base_url();
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        $builder = $db->table('saiyoojyam_cms');
        if (!empty($id)) {
            $builder->where('id', (int) $id);
        }
        if (!empty($page)) {
            $builder->where('page', $page);
        }

        $items = $builder->get()->getResult();

        $data = [];
        if (!empty($items)) {
            foreach ($items as $item) {
                $imageUrl = '';
                $thumbUrl = '';
                if (!empty($item->cms_img)) {
                    $imageUrl = $baseUrl . 'uploads/cms/' . $item->cms_img;
                    $thumbUrl = $baseUrl . 'uploads/cms/thumbs/' . $item->cms_img;
                }

                $data[] = [
                    'id'          => (int) $item->id,
                    'page'        => $item->page ?? '',
                    'title'       => $item->cms_tittle ?? '',
                    'description' => strip_tags($item->cms_desc ?? ''),
                    'raw_desc'    => $item->cms_desc ?? '',
                    'image'       => $imageUrl,
                    'thumb'       => $thumbUrl,
                    'image_name'  => $item->cms_img ?? '',
                ];
            }
        }

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($data),
            'data'   => $data,
        ]);
    }
}
