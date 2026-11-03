<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Payments extends BaseController
{
    public function index()
    {
        return redirect()->to(base_url('Admin/Payments/View'));
    }

    public function View()
    {
        $db = \Config\Database::connect();
        
        $status_filter   = $this->request->getGet('status');
        $month_filter    = $this->request->getGet('month');
        $building_filter = $this->request->getGet('building');
        $ref_filter      = trim((string)$this->request->getGet('ref'));
        
        // Base Query joining invoices with inmates, buildings, and rooms
        $builder = $db->table('saiyoojyam_invoice inv');
        $builder->select('inv.*, i.inmates_name, i.inmates_uid, i.inmates_phone_no, i.inmates_email, i.inmates_check_in_date,
                          b.building_name, r.rooms_name, rt.room_type_name');
        $builder->join('saiyoojyam_inmates i', 'i.inmates_id = inv.invoice_inmates', 'left');
        $builder->join('saiyoojyam_building b', 'b.building_id = i.inmates_building', 'left');
        $builder->join('saiyoojyam_rooms r', 'r.rooms_id = i.inmates_rooms', 'left');
        $builder->join('saiyoojyam_room_type rt', 'rt.room_type_id = i.inmates_room_type', 'left');
        
        if ($status_filter !== null && $status_filter !== '') {
            $builder->where('inv.invoice_status', (int)$status_filter);
        }
        if (!empty($month_filter)) {
            $builder->where("DATE_FORMAT(inv.invoice_payment_month, '%Y-%m') =", date('Y-m', strtotime($month_filter)));
        }
        if (!empty($building_filter)) {
            $builder->where('i.inmates_building', (int)$building_filter);
        }
        if (!empty($ref_filter)) {
            $builder->groupStart()
                ->where('i.inmates_uid', $ref_filter)
                ->orLike('i.inmates_name', $ref_filter)
            ->groupEnd();
        }
        
        $builder->orderBy('inv.invoice_id', 'DESC');
        $data['invoices'] = $builder->get()->getResult();

        // Overall KPI Summary Statistics
        $statsBuilder = $db->table('saiyoojyam_invoice inv')
            ->select('COUNT(*) as total_count,
                      COALESCE(SUM(inv.invoice_total), 0) as total_billed,
                      COALESCE(SUM(inv.invoice_paid_amount), 0) as total_collected,
                      COALESCE(SUM(inv.invoice_balance), 0) as total_balance,
                      SUM(CASE WHEN inv.invoice_status = 1 THEN 1 ELSE 0 END) as paid_count,
                      SUM(CASE WHEN inv.invoice_status = 2 THEN 1 ELSE 0 END) as partial_count,
                      SUM(CASE WHEN inv.invoice_status = 3 THEN 1 ELSE 0 END) as advance_count,
                      SUM(CASE WHEN inv.invoice_status = 0 THEN 1 ELSE 0 END) as unpaid_count');
        $data['stats'] = $statsBuilder->get()->getRow();

        // Dropdown data for filters
        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building', 'building_name', 'ASC');
        
        // Distinct billing months from invoices
        $data['billing_months'] = $db->table('saiyoojyam_invoice')
            ->select("DISTINCT DATE_FORMAT(invoice_payment_month, '%Y-%m') as pay_month")
            ->orderBy('pay_month', 'DESC')
            ->get()->getResult();
            
        $data['status_filter']   = $status_filter;
        $data['month_filter']    = $month_filter;
        $data['building_filter'] = $building_filter;
        $data['ref_filter']      = $ref_filter;

        return view('admin/view_payments', $data);
    }

    public function PayBalance()
    {
        if ($this->request->getMethod() === 'POST') {
            $invoice_id = (int)$this->request->getPost('invoice_id');
            $paid_amount = (float)str_replace(',', '', $this->request->getPost('paid_amount'));
            
            if ($invoice_id > 0 && $paid_amount > 0) {
                $current_date = date('Y-m-d');
                $invoice_data = $this->common_model->SingleRow('saiyoojyam_invoice', ['invoice_id' => $invoice_id]);
                
                if ($invoice_data) {
                    $this->common_model->InsertData('saiyoojyam_invoice_history', [
                        'history_invoice_id'  => $invoice_id,
                        'history_paid_date'   => $current_date,
                        'history_paid_amount' => $paid_amount,
                    ]);
                    
                    $new_paid_total = (float)$invoice_data->invoice_paid_amount + $paid_amount;
                    $new_balance = max(0.00, (float)$invoice_data->invoice_total - $new_paid_total);
                    $new_status = 2; // partial
                    if ($new_paid_total >= (float)$invoice_data->invoice_total) {
                        $new_status = ($new_paid_total > (float)$invoice_data->invoice_total) ? 3 : 1;
                    }
                    
                    $this->common_model->EditData([
                        'invoice_paid_amount' => $new_paid_total,
                        'invoice_balance'     => $new_balance,
                        'invoice_status'      => $new_status,
                    ], ['invoice_id' => $invoice_id], 'saiyoojyam_invoice');
                    
                    $this->session->setFlashdata('alert', [
                        'type' => 'success',
                        'msg'  => 'Payment balance updated successfully!',
                    ]);
                }
            }
        }
        return redirect()->to(base_url('Admin/Payments/View'));
    }
}
