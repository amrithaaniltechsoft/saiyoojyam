<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Tariff extends BaseController
{
    public function index(){

        if(!empty($this->request->getGet('building'))){
            
            $building = $this->request->getGet('building');
        }
        else{

            $building = "";
        }

       

        if(!empty($this->request->getGet('room_type'))){

            $room_type = $this->request->getGet('room_type');
        }
        else{

            $room_type = "";
        }

        $joins = array(

            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'tariffs_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'tariffs_room_types',
            ),

        );

        $data['tariffs'] = $this->common_model->buildingSearch('saiyoojyam_tariffs','tariffs_id','Desc',$joins,$building,$room_type);

        $usedTariffs = [];
        if (!empty($data['tariffs'])) {
            foreach ($data['tariffs'] as $t) {
                $usage = $this->getTariffUsage($t);
                if ($usage) {
                    $usedTariffs[$t->tariffs_id] = $usage['uid_text'];
                }
            }
        }
        $data['used_tariffs'] = $usedTariffs;

        if (!empty($building)) {
            $data['rooms_types'] = $this->common_model->FetchWhereOrderby('saiyoojyam_room_type', array('room_type_building_id' => $building), 'room_type_name', 'ASC');
        } else {
            $data['rooms_types'] = $this->common_model->FetchAllOrder('saiyoojyam_room_type', 'room_type_name', 'ASC');
        }

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building', 'building_name', 'ASC');

        return view('admin/view_tariff',$data);
    }

    public function Add(){
        
        if ($this->request->getMethod() === 'POST') {

            $buildings  = $this->request->getPost('tariffs_building');
            $room_types = $this->request->getPost('tariffs_room_types');
            $prices     = $this->request->getPost('tariffs_price');

            if (!is_array($room_types)) {
                $buildings  = array($buildings);
                $room_types = array($room_types);
                $prices     = array($prices);
            }

            $added_count = 0;
            $errors = array();

            foreach ($room_types as $index => $room_type_id) {
                if (empty($room_type_id)) continue;

                $building_id  = isset($buildings[$index]) ? $buildings[$index] : '';
                $price        = isset($prices[$index]) ? $prices[$index] : 0;

                // Check if tariff already exists for this building & room type
                $tariff_avaliable = $this->common_model->FetchWhere('saiyoojyam_tariffs', array(
                    'tariffs_building'   => $building_id,
                    'tariffs_room_types' => $room_type_id
                ));

                if (!empty($tariff_avaliable)) {
                    $rt_info = $this->common_model->SingleRow('saiyoojyam_room_type', array('room_type_id' => $room_type_id));
                    $rt_name = $rt_info ? $rt_info->room_type_name : "Room Type #$room_type_id";
                    $errors[] = "$rt_name already exists for this building";
                } else {
                    $insert_data = array(
                        'tariffs_building'   => $building_id,
                        'tariffs_room_types' => $room_type_id,
                        'tariffs_rooms'      => null,
                        'tariffs_price'      => $price,
                        'tariffs_created_at' => date('Y-m-d')
                    );

                    $building_fees = $this->common_model->SingleRow('saiyoojyam_building', array('building_id' => $building_id));

                    if (!empty($building_fees)) {
                        $insert_data['tariffs_admission_fees'] = $building_fees->building_admission_fees;
                        $insert_data['tariffs_caution_deposit'] = $building_fees->building_caution_deposit;
                    }

                    $this->common_model->InsertData('saiyoojyam_tariffs', $insert_data);
                    $added_count++;
                }
            }

            if ($added_count > 0) {
                $response['status'] = "true";
                $msg = "$added_count Tariff(s) Added Successfully";
                if (!empty($errors)) {
                    $msg .= ". Skipped: " . implode(', ', $errors);
                }
                $response['msg'] = $msg;
            } else {
                $response['status'] = "false";
                $response['msg'] = !empty($errors) ? implode(', ', $errors) : "Please select valid room type(s) to add tariff";
            }

            echo json_encode($response);
            return;

        }

        $selected_building_id = $this->request->getGet('building_id');
        $selected_type_id     = $this->request->getGet('room_type_id');

        $data['selected_building_id'] = $selected_building_id;
        $data['selected_type_id']     = $selected_type_id;

        $data['buildings'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_name','ASC');

        if (!empty($selected_building_id)) {
            $data['preselected_room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type', array('room_type_building_id' => $selected_building_id));
        } else {
            $data['preselected_room_types'] = [];
        }

        return view('admin/add_tariff', $data);

    }

    
    public function Edit($id){
        
        $joins = array(

            array(
                'table' => 'saiyoojyam_building',
                'pk'    => 'building_id',
                'fk'    => 'tariffs_building',
            ),
            array(
                'table' => 'saiyoojyam_room_type',
                'pk'    => 'room_type_id',
                'fk'    => 'tariffs_room_types',
            ),

         );
        $data['tariff'] = $this->common_model->SingleRowJoin('saiyoojyam_tariffs',array('tariffs_id' => $id),$joins); 

        $data['building'] = $this->common_model->FetchAllOrder('saiyoojyam_building','building_id','DESC');

        $data['room_types'] = $this->common_model->FetchWhere('saiyoojyam_room_type',array('room_type_building_id' => $data['tariff']->tariffs_building));

        $data['history'] = $this->common_model->FetchWhereOrderby('saiyoojyam_tariff_history',array('tariff_history_tariff_id' => $id),'tariff_history_id','DESC');

        if($this->request->getMethod() === 'POST'){

            $update_data = $this->request->getPost();

            $old_price = $data['tariff']->tariffs_price;

            $building_fees = $this->common_model->SingleRow('saiyoojyam_building',array('building_id' => $this->request->getPost('tariffs_building')));

            if(!empty($building_fees)){

                $update_data['tariffs_admission_fees'] = $building_fees->building_admission_fees;

                $update_data['tariffs_caution_deposit'] = $building_fees->building_caution_deposit;

            }

            $update_data['tariffs_updated_at'] = date('Y-m-d'); 

            $this->common_model->EditData($update_data,array('tariffs_id' => $id),'saiyoojyam_tariffs');

            $new_price = $this->request->getPost('tariffs_price');

            if($new_price != $old_price){

                $history_data = array(
                    'tariff_history_tariff_id'    => $id,
                    'tariff_history_old_price'    => $old_price,
                    'tariff_history_new_price'    => $new_price,
                    'tariff_history_effective_month' => date('Y-m'),
                    'tariff_history_created_at'   => date('Y-m-d H:i:s'),
                );

                $this->common_model->InsertData('saiyoojyam_tariff_history',$history_data);

            }

            $flashdata = array(

                'type' => 'success',
                'msg'  => 'Data Updated Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

            return redirect()->to(site_url('Admin/Tariff/Edit/'.$id));


        }

        return view('admin/edit_tariff',$data);

    }


    private function getTariffUsage($tariff)
    {
        if (empty($tariff)) {
            return null;
        }

        $db = \Config\Database::connect();
        $tariffId   = (int) $tariff->tariffs_id;
        $buildingId = (int) ($tariff->tariffs_building ?? 0);
        $roomTypeId = (int) ($tariff->tariffs_room_types ?? 0);

        $usedInmates = [];

        // 1. Direct tariff assignment in inmates
        $inmatesByTariff = $db->table('saiyoojyam_inmates')
            ->where('inmates_tariffs', $tariffId)
            ->get()
            ->getResult();
        foreach ($inmatesByTariff as $inm) {
            $usedInmates[$inm->inmates_id] = $inm;
        }

        // 2. Inmates occupying rooms of this building & room type
        if ($buildingId > 0 && $roomTypeId > 0) {
            $inmatesByType = $db->table('saiyoojyam_inmates')
                ->where('inmates_building', $buildingId)
                ->where('inmates_room_type', $roomTypeId)
                ->get()
                ->getResult();
            foreach ($inmatesByType as $inm) {
                $usedInmates[$inm->inmates_id] = $inm;
            }
        }

        // 3. Invoices check for linked inmates
        $hasInvoices = false;
        if (!empty($usedInmates) && $db->tableExists('saiyoojyam_invoice')) {
            $inmateIds = array_keys($usedInmates);
            $invCount = $db->table('saiyoojyam_invoice')
                ->whereIn('invoice_inmates', $inmateIds)
                ->countAllResults();
            if ($invCount > 0) {
                $hasInvoices = true;
            }
        }

        if (empty($usedInmates) && !$hasInvoices) {
            return null;
        }

        $uids = [];
        foreach ($usedInmates as $inm) {
            $uids[] = !empty($inm->inmates_uid) ? $inm->inmates_uid : ('#' . $inm->inmates_id);
        }

        return [
            'count'    => count($usedInmates),
            'inmates'  => $usedInmates,
            'uid_text' => implode(', ', array_slice($uids, 0, 3)) . (count($uids) > 3 ? ' and ' . (count($uids) - 3) . ' more' : ''),
        ];
    }

    public function Delete($id){

        $tariff = $this->common_model->SingleRow('saiyoojyam_tariffs', array('tariffs_id' => $id));

        if (empty($tariff)) {
            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Tariff not found',
            );
            $this->session->setFlashdata('alert', $flashdata);
            return redirect()->to(site_url('Admin/Tariff'));
        }

        $usage = $this->getTariffUsage($tariff);

        if (!empty($usage)) {
            $uidStr = !empty($usage['uid_text']) ? ' (' . $usage['uid_text'] . ')' : '';
            $flashdata = array(
                'type' => 'error',
                'msg'  => 'Cannot delete: This tariff price is currently used by inmate(s)' . $uidStr . '.',
            );

            $this->session->setFlashdata('alert', $flashdata);

            return redirect()->to(site_url('Admin/Tariff'));
        }

        $this->common_model->DeleteData('saiyoojyam_tariff_history', array('tariff_history_tariff_id' => $id));

        $this->common_model->DeleteData('saiyoojyam_tariffs', array('tariffs_id' => $id));

        $flashdata = array(
            'type' => 'success',
            'msg'  => 'Tariff Deleted Successfully',
        );

        $this->session->setFlashdata('alert', $flashdata);

        return redirect()->to(site_url('Admin/Tariff'));

    }


    /**
     * Download Sample Excel Template for Tariff Import
     */
    public function DownloadSample()
    {
        $db = \Config\Database::connect();
        $buildings = $db->table('saiyoojyam_building')->orderBy('building_name', 'ASC')->get()->getResult();
        $roomTypes = $db->table('saiyoojyam_room_type')->orderBy('room_type_name', 'ASC')->get()->getResult();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Sheet 1: Template with exactly 3 columns: building, room type, monthly rent
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tariff Import Template');

        $headers = [
            'A1' => 'Building Name',
            'B1' => 'Room Type Name',
            'C1' => 'Monthly Rent'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFF1F5F9');
        }

        // Add prefilled sample rows from actual database
        $rowIndex = 2;
        $sampleCount = 0;
        foreach ($buildings as $b) {
            $bTypes = array_filter($roomTypes, function($rt) use ($b) {
                return (int)$rt->room_type_building_id === (int)$b->building_id;
            });

            foreach ($bTypes as $rt) {
                $sheet->setCellValue('A' . $rowIndex, $b->building_name);
                $sheet->setCellValue('B' . $rowIndex, $rt->room_type_name);
                $sheet->setCellValue('C' . $rowIndex, 6000 + ($sampleCount * 500));
                $rowIndex++;
                $sampleCount++;
                if ($sampleCount >= 6) break 2;
            }
        }

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 2: Reference Guide
        $refSheet = $spreadsheet->createSheet();
        $refSheet->setTitle('Reference Guide');
        $refSheet->setCellValue('A1', 'Building Name');
        $refSheet->setCellValue('B1', 'Available Room Type');
        $refSheet->setCellValue('C1', 'Building ID');
        $refSheet->setCellValue('D1', 'Room Type ID');

        foreach (range('A', 'D') as $col) {
            $refSheet->getStyle($col . '1')->getFont()->setBold(true);
            $refSheet->getStyle($col . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE2E8F0');
        }

        $refRow = 2;
        foreach ($buildings as $b) {
            $bTypes = array_filter($roomTypes, function($rt) use ($b) {
                return (int)$rt->room_type_building_id === (int)$b->building_id;
            });

            if (empty($bTypes)) {
                $refSheet->setCellValue('A' . $refRow, $b->building_name);
                $refSheet->setCellValue('B' . $refRow, '(No room types created)');
                $refSheet->setCellValue('C' . $refRow, $b->building_id);
                $refSheet->setCellValue('D' . $refRow, '-');
                $refRow++;
            } else {
                foreach ($bTypes as $rt) {
                    $refSheet->setCellValue('A' . $refRow, $b->building_name);
                    $refSheet->setCellValue('B' . $refRow, $rt->room_type_name);
                    $refSheet->setCellValue('C' . $refRow, $b->building_id);
                    $refSheet->setCellValue('D' . $refRow, $rt->room_type_id);
                    $refRow++;
                }
            }
        }

        foreach (range('A', 'D') as $col) {
            $refSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Tariff_Import_Template_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }


    /**
     * Import Tariffs from Excel / CSV file
     */
    public function Import()
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Invalid request method.'
            ]);
        }

        $file = $this->request->getFile('excel_file');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Please select a valid Excel or CSV file to upload.'
            ]);
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Invalid file format (' . $ext . '). Supported formats: .xlsx, .xls, .csv'
            ]);
        }

        $updateExisting = ($this->request->getPost('update_existing') == '1');

        $tempPath = $file->getTempName();
        $rawRows = [];

        try {
            if ($ext === 'csv') {
                $handle = fopen($tempPath, 'r');
                if ($handle !== false) {
                    $bom = fread($handle, 3);
                    if ($bom !== "\xEF\xBB\xBF") {
                        rewind($handle);
                    }
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        $rawRows[] = $data;
                    }
                    fclose($handle);
                }
            } else {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tempPath);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($tempPath);
                $sheet = $spreadsheet->getActiveSheet();
                $sheetData = $sheet->toArray(null, true, true, false);
                $rawRows = $sheetData;
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Error reading file: ' . $e->getMessage()
            ]);
        }

        if (empty($rawRows) || count($rawRows) < 2) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'The uploaded spreadsheet contains no data rows.'
            ]);
        }

        $db = \Config\Database::connect();
        $buildings = $db->table('saiyoojyam_building')->get()->getResult();
        $roomTypes = $db->table('saiyoojyam_room_type')->get()->getResult();

        $buildingMap = [];
        foreach ($buildings as $b) {
            $buildingMap[(int)$b->building_id] = $b;
            $cleanName = strtolower(trim($b->building_name));
            $buildingMap[$cleanName] = $b;
            if (!empty($b->building_slug)) {
                $buildingMap[strtolower(trim($b->building_slug))] = $b;
            }
        }

        $roomTypeMap = [];
        foreach ($roomTypes as $rt) {
            $roomTypeMap[(int)$rt->room_type_id] = $rt;
            $compositeKey = (int)$rt->room_type_building_id . '_' . strtolower(trim($rt->room_type_name));
            $roomTypeMap[$compositeKey] = $rt;
        }

        // Header detection (default: 3 columns: 0=Building, 1=Room Type, 2=Monthly Rent)
        $headerRow = array_shift($rawRows);
        $colBuilding  = 0;
        $colRoomType  = 1;
        $colPrice     = 2;
        $colAdmission = null;
        $colCaution   = null;

        $hasDetectedHeader = false;
        foreach ($headerRow as $cIdx => $cVal) {
            $colName = strtolower(trim((string)$cVal));
            if (str_contains($colName, 'building') || str_contains($colName, 'property') || str_contains($colName, 'hostel')) {
                $colBuilding = $cIdx;
                $hasDetectedHeader = true;
            } elseif (str_contains($colName, 'room') || str_contains($colName, 'sharing') || str_contains($colName, 'type')) {
                $colRoomType = $cIdx;
                $hasDetectedHeader = true;
            } elseif (str_contains($colName, 'rent') || str_contains($colName, 'price') || str_contains($colName, 'tariff') || str_contains($colName, 'amount')) {
                $colPrice = $cIdx;
                $hasDetectedHeader = true;
            } elseif (str_contains($colName, 'admission')) {
                $colAdmission = $cIdx;
            } elseif (str_contains($colName, 'caution') || str_contains($colName, 'deposit') || str_contains($colName, 'security')) {
                $colCaution = $cIdx;
            }
        }

        if (!$hasDetectedHeader && is_numeric($headerRow[$colPrice] ?? '')) {
            array_unshift($rawRows, $headerRow);
        }

        $addedCount   = 0;
        $updatedCount = 0;
        $skippedCount = 0;
        $logs         = [];

        $rowNum = 1;
        foreach ($rawRows as $row) {
            $rowNum++;

            $nonEmpty = array_filter($row, function($v) { return trim((string)$v) !== ''; });
            if (empty($nonEmpty)) continue;

            $rawBuilding   = trim((string)($row[$colBuilding] ?? ''));
            $rawRoomType   = trim((string)($row[$colRoomType] ?? ''));
            $rawPrice      = trim((string)($row[$colPrice] ?? ''));
            $rawAdmission  = ($colAdmission !== null && isset($row[$colAdmission])) ? trim((string)$row[$colAdmission]) : '';
            $rawCaution    = ($colCaution !== null && isset($row[$colCaution])) ? trim((string)$row[$colCaution]) : '';

            if ($rawBuilding === '' || $rawRoomType === '' || $rawPrice === '') {
                $skippedCount++;
                $logs[] = [
                    'row'     => $rowNum,
                    'status'  => 'skipped',
                    'message' => "Row $rowNum: Missing required field(s) (Building: '{$rawBuilding}', Room Type: '{$rawRoomType}', Price: '{$rawPrice}')."
                ];
                continue;
            }

            // Resolve Building
            $matchedBuilding = null;
            if (is_numeric($rawBuilding) && isset($buildingMap[(int)$rawBuilding])) {
                $matchedBuilding = $buildingMap[(int)$rawBuilding];
            } else {
                $cleanB = strtolower($rawBuilding);
                if (isset($buildingMap[$cleanB])) {
                    $matchedBuilding = $buildingMap[$cleanB];
                } else {
                    foreach ($buildings as $b) {
                        if (stripos($b->building_name, $rawBuilding) !== false || stripos($rawBuilding, $b->building_name) !== false) {
                            $matchedBuilding = $b;
                            break;
                        }
                    }
                }
            }

            if (!$matchedBuilding) {
                $skippedCount++;
                $logs[] = [
                    'row'     => $rowNum,
                    'status'  => 'skipped',
                    'message' => "Row $rowNum: Building '{$rawBuilding}' could not be found."
                ];
                continue;
            }

            $bId = (int)$matchedBuilding->building_id;

            // Resolve Room Type
            $matchedRoomType = null;
            if (is_numeric($rawRoomType) && isset($roomTypeMap[(int)$rawRoomType])) {
                $matchedRoomType = $roomTypeMap[(int)$rawRoomType];
            } else {
                $cleanRt = strtolower($rawRoomType);
                $key = $bId . '_' . $cleanRt;
                if (isset($roomTypeMap[$key])) {
                    $matchedRoomType = $roomTypeMap[$key];
                } else {
                    foreach ($roomTypes as $rt) {
                        if ((int)$rt->room_type_building_id === $bId) {
                            $dbRtName = strtolower(trim($rt->room_type_name));
                            if (stripos($dbRtName, $cleanRt) !== false || stripos($cleanRt, $dbRtName) !== false) {
                                $matchedRoomType = $rt;
                                break;
                            }
                        }
                    }
                }
            }

            if (!$matchedRoomType) {
                $skippedCount++;
                $logs[] = [
                    'row'     => $rowNum,
                    'status'  => 'skipped',
                    'message' => "Row $rowNum: Room Type '{$rawRoomType}' not found in Building '{$matchedBuilding->building_name}'."
                ];
                continue;
            }

            $rtId = (int)$matchedRoomType->room_type_id;

            // Price validation
            $cleanPrice = (float)preg_replace('/[^0-9.]/', '', $rawPrice);
            if ($cleanPrice < 0) {
                $skippedCount++;
                $logs[] = [
                    'row'     => $rowNum,
                    'status'  => 'skipped',
                    'message' => "Row $rowNum: Invalid price '{$rawPrice}'."
                ];
                continue;
            }

            $admissionFee = is_numeric($rawAdmission) && (float)$rawAdmission > 0
                ? (float)$rawAdmission
                : (float)$matchedBuilding->building_admission_fees;

            $cautionDeposit = is_numeric($rawCaution) && (float)$rawCaution > 0
                ? (float)$rawCaution
                : (float)$matchedBuilding->building_caution_deposit;

            $existing = $db->table('saiyoojyam_tariffs')
                ->where('tariffs_building', $bId)
                ->where('tariffs_room_types', $rtId)
                ->get()
                ->getRow();

            if ($existing) {
                if ($updateExisting) {
                    $oldPrice = (float)$existing->tariffs_price;
                    $db->table('saiyoojyam_tariffs')
                        ->where('tariffs_id', $existing->tariffs_id)
                        ->update([
                            'tariffs_price'           => $cleanPrice,
                            'tariffs_admission_fees'  => $admissionFee,
                            'tariffs_caution_deposit' => $cautionDeposit,
                            'tariffs_updated_at'      => date('Y-m-d H:i:s'),
                        ]);

                    if ($oldPrice != $cleanPrice) {
                        $this->common_model->InsertData('saiyoojyam_tariff_history', [
                            'tariff_history_tariff_id'       => $existing->tariffs_id,
                            'tariff_history_old_price'       => $oldPrice,
                            'tariff_history_new_price'       => $cleanPrice,
                            'tariff_history_effective_month' => date('Y-m'),
                            'tariff_history_created_at'      => date('Y-m-d H:i:s'),
                        ]);
                    }

                    $updatedCount++;
                    $logs[] = [
                        'row'       => $rowNum,
                        'status'    => 'updated',
                        'building'  => $matchedBuilding->building_name,
                        'room_type' => $matchedRoomType->room_type_name,
                        'price'     => $cleanPrice,
                        'message'   => "Row $rowNum: Updated {$matchedBuilding->building_name} - {$matchedRoomType->room_type_name} to ₹" . number_format($cleanPrice, 2)
                    ];
                } else {
                    $skippedCount++;
                    $logs[] = [
                        'row'     => $rowNum,
                        'status'  => 'skipped',
                        'message' => "Row $rowNum: Tariff for {$matchedBuilding->building_name} - {$matchedRoomType->room_type_name} already exists (Skipped)."
                    ];
                }
            } else {
                $db->table('saiyoojyam_tariffs')->insert([
                    'tariffs_building'        => $bId,
                    'tariffs_room_types'      => $rtId,
                    'tariffs_rooms'           => null,
                    'tariffs_admission_fees'  => $admissionFee,
                    'tariffs_caution_deposit' => $cautionDeposit,
                    'tariffs_price'           => $cleanPrice,
                    'tariffs_created_at'      => date('Y-m-d H:i:s'),
                    'tariffs_updated_at'      => date('Y-m-d H:i:s'),
                ]);

                $addedCount++;
                $logs[] = [
                    'row'       => $rowNum,
                    'status'    => 'added',
                    'building'  => $matchedBuilding->building_name,
                    'room_type' => $matchedRoomType->room_type_name,
                    'price'     => $cleanPrice,
                    'message'   => "Row $rowNum: Added {$matchedBuilding->building_name} - {$matchedRoomType->room_type_name} at ₹" . number_format($cleanPrice, 2)
                ];
            }
        }

        $summaryParts = [];
        if ($addedCount > 0) $summaryParts[] = "$addedCount Tariff(s) Added";
        if ($updatedCount > 0) $summaryParts[] = "$updatedCount Tariff(s) Updated";
        if ($skippedCount > 0) $summaryParts[] = "$skippedCount Row(s) Skipped";

        $summaryMsg = !empty($summaryParts) ? implode(', ', $summaryParts) : 'No tariffs were processed.';

        return $this->response->setJSON([
            'status'  => ($addedCount > 0 || $updatedCount > 0),
            'message' => $summaryMsg,
            'added'   => $addedCount,
            'updated' => $updatedCount,
            'skipped' => $skippedCount,
            'total'   => count($rawRows),
            'logs'    => $logs,
        ]);
    }

}
