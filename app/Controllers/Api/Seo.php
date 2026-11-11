<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Seo extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db   = Database::connect();
        $page = $this->request->getGet('page');
        $id   = $this->request->getGet('id');

        $builder = $db->table('saiyoojyam_seo');

        if (!empty($id)) {
            $builder->where('id', (int) $id);
            $item = $builder->get()->getRow();
            return $this->formatSingle($item);
        }

        if (!empty($page)) {
            $normalized = strtolower(trim(str_replace(['-', '_'], ' ', $page)));

            $item = $builder->where('LOWER(page)', strtolower($page))->get()->getRow();

            if (empty($item)) {
                $item = $db->table('saiyoojyam_seo')->where('LOWER(page)', $normalized)->get()->getRow();
            }

            if (empty($item)) {
                if ($normalized === 'dashboard') {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Dashboard')->get()->getRow();
                    if (empty($item)) {
                        $item = $db->table('saiyoojyam_seo')->where('page', 'Profile')->get()->getRow();
                    }
                } elseif ($normalized === 'profile') {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Profile')->get()->getRow();
                } elseif (in_array($normalized, ['monthly payment', 'monthly-payment', 'rent', 'rent payment'])) {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Monthly Payment')->get()->getRow();
                } elseif (in_array($normalized, ['payment history', 'payment-history', 'receipts', 'receipt'])) {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Payment History')->get()->getRow();
                } elseif (in_array($normalized, ['terms', 'profile terms', 'terms & conditions', 'rules'])) {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Profile Terms')->get()->getRow();
                    if (empty($item)) {
                        $item = $db->table('saiyoojyam_seo')->where('page', 'Terms and condition')->get()->getRow();
                    }
                }
            }

            if (empty($item)) {
                $item = $db->table('saiyoojyam_seo')->like('LOWER(page)', $normalized)->get()->getRow();
            }

            if (empty($item)) {
                $item = $db->table('saiyoojyam_seo')->where('id', 1)->get()->getRow();
            }
            return $this->formatSingle($item);
        }

        $items = $builder->orderBy('id', 'ASC')->get()->getResult();
        $data  = [];
        if (!empty($items)) {
            foreach ($items as $row) {
                $data[] = [
                    'id'            => (int) $row->id,
                    'page'          => $row->page,
                    'meta_title'    => $row->meta_title ?? '',
                    'meta_desc'     => $row->meta_desc ?? '',
                    'meta_key_word' => $row->meta_key_word ?? '',
                    'updated_at'    => $row->updated_at ?? '',
                ];
            }
        }

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($data),
            'data'   => $data,
        ]);
    }

    public function page($pageName = 'Home')
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db = Database::connect();

        if (is_numeric($pageName)) {
            $item = $db->table('saiyoojyam_seo')->where('id', (int) $pageName)->get()->getRow();
            if (!empty($item)) {
                return $this->formatSingle($item);
            }
        }

        $normalized = strtolower(trim(str_replace(['-', '_'], ' ', $pageName)));

        $item = $db->table('saiyoojyam_seo')->where('LOWER(page)', strtolower($pageName))->get()->getRow();

        if (empty($item)) {
            $item = $db->table('saiyoojyam_seo')->where('LOWER(page)', $normalized)->get()->getRow();
        }

        if (empty($item)) {
            if ($normalized === 'dashboard') {
                $item = $db->table('saiyoojyam_seo')->where('page', 'Dashboard')->get()->getRow();
                if (empty($item)) {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Profile')->get()->getRow();
                }
            } elseif ($normalized === 'profile') {
                $item = $db->table('saiyoojyam_seo')->where('page', 'Profile')->get()->getRow();
            } elseif (in_array($normalized, ['monthly payment', 'monthly-payment', 'rent', 'rent payment'])) {
                $item = $db->table('saiyoojyam_seo')->where('page', 'Monthly Payment')->get()->getRow();
            } elseif (in_array($normalized, ['payment history', 'payment-history', 'receipts', 'receipt'])) {
                $item = $db->table('saiyoojyam_seo')->where('page', 'Payment History')->get()->getRow();
            } elseif (in_array($normalized, ['terms', 'profile terms', 'terms & conditions', 'rules'])) {
                $item = $db->table('saiyoojyam_seo')->where('page', 'Profile Terms')->get()->getRow();
                if (empty($item)) {
                    $item = $db->table('saiyoojyam_seo')->where('page', 'Terms and condition')->get()->getRow();
                }
            }
        }

        if (empty($item)) {
            $item = $db->table('saiyoojyam_seo')->like('LOWER(page)', $normalized)->get()->getRow();
        }

        if (empty($item) && strtolower($pageName) === 'home') {
            $item = $db->table('saiyoojyam_seo')->where('id', 1)->get()->getRow();
        }

        return $this->formatSingle($item);
    }

    private function formatSingle($item)
    {
        if (empty($item)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'SEO record not found',
                'data'    => null,
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'id'            => (int) $item->id,
                'page'          => $item->page,
                'meta_title'    => $item->meta_title ?? '',
                'meta_desc'     => $item->meta_desc ?? '',
                'meta_key_word' => $item->meta_key_word ?? '',
                'updated_at'    => $item->updated_at ?? '',
            ],
        ]);
    }
}
