<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class WhyChoose extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $items = $this->common_model->FetchAllOrder('saiyoojyam_why_choose', 'why_id', 'ASC');

        $baseUrl = base_url();
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        $data = [];
        if (!empty($items)) {
            foreach ($items as $item) {
                $imageUrl = '';
                if (!empty($item->why_image)) {
                    $imageUrl = $baseUrl . 'uploads/whychoose/' . $item->why_image;
                }

                $data[] = [
                    'id'          => (int) $item->why_id,
                    'title'       => $item->why_title,
                    'description' => strip_tags($item->why_desc ?? ''),
                    'raw_desc'    => $item->why_desc ?? '',
                    'image'       => $imageUrl,
                    'image_name'  => $item->why_image ?? '',
                    'order'       => isset($item->why_order) ? (int)$item->why_order : 0,
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
