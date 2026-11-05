<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class TermsConditions extends BaseController
{
    private function ensureTable()
    {
        $db = Database::connect();
        if (!$db->tableExists('saiyoojyam_terms_conditions')) {
            $db->query("CREATE TABLE IF NOT EXISTS `saiyoojyam_terms_conditions` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(255) DEFAULT 'Hostel Rules, Terms & Conditions',
              `small_description` text DEFAULT NULL,
              `pdf_file` varchar(255) DEFAULT NULL,
              `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    public function index()
    {
        $this->ensureTable();
        $this->session->set('manage', 'website');

        $data['terms_list'] = $this->common_model->FetchAllOrder('saiyoojyam_terms_conditions', 'id', 'DESC');

        return view('admin/view_terms_conditions', $data);
    }

    public function View()
    {
        return $this->index();
    }

    public function Add()
    {
        $this->ensureTable();
        $this->session->set('manage', 'website');

        if (strtolower($this->request->getMethod()) === 'post') {
            $title            = trim((string) $this->request->getPost('title'));
            $smallDescription = trim((string) $this->request->getPost('small_description'));

            $uploadPath = FCPATH . 'uploads/terms/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $pdfName = null;
            $pdfFile = $this->request->getFile('pdf_file');
            if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
                $ext = strtolower($pdfFile->getExtension());
                if ($ext !== 'pdf') {
                    $flashdata = [
                        'type' => 'error',
                        'msg'  => 'Only PDF files (.pdf) are allowed.',
                    ];
                    $this->session->setFlashdata('alert', $flashdata);
                    return redirect()->to(site_url('Admin/TermsConditions/Add'));
                }

                if ($pdfFile->getSizeByUnit('mb') > 25) {
                    $flashdata = [
                        'type' => 'error',
                        'msg'  => 'The PDF file size exceeds the maximum limit of 25MB.',
                    ];
                    $this->session->setFlashdata('alert', $flashdata);
                    return redirect()->to(site_url('Admin/TermsConditions/Add'));
                }

                $pdfName = $pdfFile->getRandomName();
                $pdfFile->move($uploadPath, $pdfName);
            }

            $insertData = [
                'title'             => $title,
                'small_description' => $smallDescription,
                'pdf_file'          => $pdfName,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            $this->common_model->InsertData('saiyoojyam_terms_conditions', $insertData);

            $flashdata = [
                'type' => 'success',
                'msg'  => 'Terms and Conditions Added Successfully',
            ];
            $this->session->setFlashdata('alert', $flashdata);

            return redirect()->to(site_url('Admin/TermsConditions'));
        }

        return view('admin/add_terms_conditions');
    }

    public function Edit($id = null)
    {
        $this->ensureTable();
        $this->session->set('manage', 'website');

        $terms = null;
        if (!empty($id)) {
            $terms = $this->common_model->SingleRow('saiyoojyam_terms_conditions', ['id' => $id]);
        }
        if (empty($terms)) {
            // Fallback to first row
            $db = Database::connect();
            $terms = $db->table('saiyoojyam_terms_conditions')->get()->getRow();
        }

        if (empty($terms)) {
            return redirect()->to(site_url('Admin/TermsConditions/Add'));
        }

        $id = $terms->id;

        if (strtolower($this->request->getMethod()) === 'post') {
            $title            = trim((string) $this->request->getPost('title'));
            $smallDescription = trim((string) $this->request->getPost('small_description'));

            $uploadPath = FCPATH . 'uploads/terms/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $currentPdf = $terms->pdf_file ?? null;
            $newPdfName = $currentPdf;

            // Handle removal
            if ($this->request->getPost('remove_pdf') === '1') {
                if (!empty($currentPdf) && file_exists($uploadPath . $currentPdf)) {
                    @unlink($uploadPath . $currentPdf);
                }
                $newPdfName = null;
            }

            // Handle new PDF
            $pdfFile = $this->request->getFile('pdf_file');
            if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
                $ext = strtolower($pdfFile->getExtension());
                if ($ext !== 'pdf') {
                    $flashdata = [
                        'type' => 'error',
                        'msg'  => 'Only PDF files (.pdf) are allowed.',
                    ];
                    $this->session->setFlashdata('alert', $flashdata);
                    return redirect()->to(site_url('Admin/TermsConditions/Edit/' . $id));
                }

                if ($pdfFile->getSizeByUnit('mb') > 25) {
                    $flashdata = [
                        'type' => 'error',
                        'msg'  => 'The PDF file size exceeds the maximum limit of 25MB.',
                    ];
                    $this->session->setFlashdata('alert', $flashdata);
                    return redirect()->to(site_url('Admin/TermsConditions/Edit/' . $id));
                }

                if (!empty($currentPdf) && file_exists($uploadPath . $currentPdf)) {
                    @unlink($uploadPath . $currentPdf);
                }

                $newPdfName = $pdfFile->getRandomName();
                $pdfFile->move($uploadPath, $newPdfName);
            }

            $updateData = [
                'title'             => $title,
                'small_description' => $smallDescription,
                'pdf_file'          => $newPdfName,
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            $this->common_model->EditData($updateData, ['id' => $id], 'saiyoojyam_terms_conditions');

            $flashdata = [
                'type' => 'success',
                'msg'  => 'Terms and Conditions Updated Successfully',
            ];
            $this->session->setFlashdata('alert', $flashdata);

            return redirect()->to(site_url('Admin/TermsConditions'));
        }

        $data['terms'] = $terms;

        return view('admin/edit_terms_conditions', $data);
    }

    public function Delete($id)
    {
        $this->ensureTable();
        $terms = $this->common_model->SingleRow('saiyoojyam_terms_conditions', ['id' => $id]);

        if (!empty($terms)) {
            if (!empty($terms->pdf_file)) {
                $filePath = FCPATH . 'uploads/terms/' . $terms->pdf_file;
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            $this->common_model->DeleteData('saiyoojyam_terms_conditions', ['id' => $id]);

            $flashdata = [
                'type' => 'success',
                'msg'  => 'Terms and Conditions Deleted Successfully',
            ];
            $this->session->setFlashdata('alert', $flashdata);
        }

        return redirect()->to(site_url('Admin/TermsConditions'));
    }

    public function DeletePdf($id = null)
    {
        $this->ensureTable();
        $terms = null;
        if (!empty($id)) {
            $terms = $this->common_model->SingleRow('saiyoojyam_terms_conditions', ['id' => $id]);
        }
        if (empty($terms)) {
            $db = Database::connect();
            $terms = $db->table('saiyoojyam_terms_conditions')->get()->getRow();
        }

        if (!empty($terms) && !empty($terms->pdf_file)) {
            $filePath = FCPATH . 'uploads/terms/' . $terms->pdf_file;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $this->common_model->EditData(['pdf_file' => null, 'updated_at' => date('Y-m-d H:i:s')], ['id' => $terms->id], 'saiyoojyam_terms_conditions');

            $flashdata = [
                'type' => 'success',
                'msg'  => 'Terms and Conditions PDF removed successfully.',
            ];
            $this->session->setFlashdata('alert', $flashdata);
        }

        $redirectUrl = !empty($terms) ? ('Admin/TermsConditions/Edit/' . $terms->id) : 'Admin/TermsConditions';
        return redirect()->to(site_url($redirectUrl));
    }
}
