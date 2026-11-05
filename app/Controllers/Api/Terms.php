<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Terms extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db = Database::connect();

        $baseUrl = base_url();
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        // Fetch terms and conditions for logged-in resident users from saiyoojyam_terms_conditions
        $rows = [];
        if ($db->tableExists('saiyoojyam_terms_conditions')) {
            $rows = $db->table('saiyoojyam_terms_conditions')->orderBy('id', 'ASC')->get()->getResult();
        }

        $list = [];
        foreach ($rows as $item) {
            $pdfUrl = '';
            if (!empty($item->pdf_file)) {
                $pdfUrl = $baseUrl . 'public/uploads/terms/' . $item->pdf_file;
            }

            $downloadUrl = $baseUrl . 'api/terms/download/' . $item->id;

            $list[] = [
                'id'                => (int) $item->id,
                'title'             => $item->title ?? '',
                'small_description' => $item->small_description ?? '',
                'desc'              => $item->small_description ?? '',
                'pdf_file'          => $item->pdf_file ?? null,
                'pdf_url'           => $pdfUrl,
                'download_url'      => $downloadUrl,
                'updated_at'        => $item->updated_at ?? null,
            ];
        }

        $first = !empty($list) ? $list[0] : [
            'id'                => 0,
            'title'             => 'Hostel Rules, Terms & Conditions',
            'small_description' => '',
            'desc'              => '',
            'pdf_file'          => null,
            'pdf_url'           => '',
            'download_url'      => '',
            'updated_at'        => null,
        ];

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($list),
            'data'   => $first,
            'list'   => $list,
        ]);
    }

    public function download($id = null)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        $db = Database::connect();
        $term = null;
        if (!empty($id)) {
            $term = $db->table('saiyoojyam_terms_conditions')->where('id', (int) $id)->get()->getRow();
        }
        if (!$term) {
            $term = $db->table('saiyoojyam_terms_conditions')
                ->where('pdf_file IS NOT NULL')
                ->where('pdf_file !=', '')
                ->orderBy('id', 'DESC')
                ->get()
                ->getRow();
        }

        if (!$term || empty($term->pdf_file)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'PDF document not found.',
            ]);
        }

        $filePath = FCPATH . 'uploads/terms/' . $term->pdf_file;
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'PDF file does not exist on server.',
            ]);
        }

        $downloadName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $term->title) . '.pdf';
        if (empty($downloadName) || $downloadName === '.pdf') {
            $downloadName = 'Saiyoojyam_Terms_and_Conditions.pdf';
        }

        $download = $this->response->download($filePath, null)->setFileName($downloadName);
        $download->setHeader('Access-Control-Allow-Origin', '*');
        $download->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $download->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        return $download;
    }
}

