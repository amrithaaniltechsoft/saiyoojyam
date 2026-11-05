<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Inmates extends BaseController
{
    private function setCorsHeaders()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
        header("Access-Control-Allow-Origin: {$origin}");
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Credentials: true');

        if ($this->response) {
            $this->response->setHeader('Access-Control-Allow-Origin', $origin);
            $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
            $this->response->setHeader('Access-Control-Allow-Credentials', 'true');
        }
    }

    public function create()
    {
        $this->setCorsHeaders();

        if ($this->request->getMethod() === 'OPTIONS') {
            return $this->response->setStatusCode(200);
        }

        try {
            $db = Database::connect();

            // Support both JSON body and multipart/form-data
            $input = [];

            // 1. Read POST data first (handles multipart/form-data and standard form-urlencoded)
            $post = $this->request->getPost();
            if (is_array($post) && !empty($post)) {
                $input = array_merge($input, $post);
            }

            // 2. Safely parse JSON if content type is application/json or post is empty
            $contentTypeHeader = $this->request->header('Content-Type');
            $contentType = $contentTypeHeader ? $contentTypeHeader->getValue() : '';
            if (stripos($contentType, 'application/json') !== false) {
                try {
                    $json = $this->request->getJSON(true);
                    if (is_array($json)) {
                        $input = array_merge($input, $json);
                    }
                } catch (\Throwable $e) {
                    $raw = $this->request->getBody();
                    $decoded = json_decode((string) $raw, true);
                    if (is_array($decoded)) {
                        $input = array_merge($input, $decoded);
                    }
                }
            } elseif (empty($input)) {
                $raw = $this->request->getBody();
                if (!empty($raw)) {
                    $decoded = json_decode((string) $raw, true);
                    if (is_array($decoded)) {
                        $input = $decoded;
                    }
                }
            }

            $name = trim($input['name'] ?? $input['inmates_name'] ?? '');
            $email = trim($input['email'] ?? $input['inmates_email'] ?? '');
            $age = (int) ($input['age'] ?? $input['inmates_age'] ?? 20);
            $phone = trim($input['phone'] ?? $input['inmates_phone_no'] ?? '');
            $whatsapp = trim($input['whatsapp'] ?? $input['inmates_whats_app_number'] ?? $phone);
            $guardianName = trim($input['guardianName'] ?? $input['inmates_guardian_name'] ?? '');
            $relation = trim($input['relation'] ?? $input['inmates_relation'] ?? 'Parent');
            $guardianContact = trim($input['contactNumber'] ?? $input['inmates_guardian_contact'] ?? '');
            $placeOfWork = trim($input['placeOfWork'] ?? $input['inmates_place_of_work'] ?? 'Self/Employed');

            if (empty($name)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'Guest full name is required',
                ]);
            }

            if (empty($phone)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'Phone number is required',
                ]);
            }

            // 1. Resolve Building first so room resolution respects the building
            $rawBuilding = $input['building'] ?? $input['buildingId'] ?? $input['inmates_building'] ?? '';
            $buildingId = 0;

            if (is_numeric($rawBuilding) && (int) $rawBuilding > 0) {
                $buildingId = (int) $rawBuilding;
            } elseif (!empty($rawBuilding) && $db->tableExists('saiyoojyam_building')) {
                $bSlugClean = strtolower(trim((string) $rawBuilding));
                $bRow = $db->table('saiyoojyam_building')
                    ->where('LOWER(building_slug)', $bSlugClean)
                    ->orWhere('building_slug', 'saiyoojyam-' . $bSlugClean)
                    ->orWhere('building_slug', str_replace('lh-', '', $bSlugClean))
                    ->orLike('LOWER(building_name)', $bSlugClean)
                    ->get()
                    ->getRow();

                if (!empty($bRow)) {
                    $buildingId = (int) $bRow->building_id;
                }
            }

            // 2. Resolve Room & Room Type
            $rawRoomId = trim((string) ($input['roomId'] ?? $input['room'] ?? $input['inmates_rooms'] ?? ''));
            $cleanNum = preg_replace('/^room[-_]/i', '', $rawRoomId);

            $roomRow = null;
            if ($db->tableExists('saiyoojyam_rooms')) {
                // If numeric, check rooms_id
                if (is_numeric($cleanNum) && (int) $cleanNum > 0) {
                    $builder = $db->table('saiyoojyam_rooms')->where('rooms_id', (int) $cleanNum);
                    if ($buildingId > 0) {
                        $builder->where('rooms_building', $buildingId);
                    }
                    $roomRow = $builder->get()->getRow();

                    if (!$roomRow) {
                        $roomRow = $db->table('saiyoojyam_rooms')->where('rooms_id', (int) $cleanNum)->get()->getRow();
                    }
                }

                // If not found yet, search by room name (e.g. '1D', '1A-ANX', '107')
                if (!$roomRow && !empty($cleanNum)) {
                    $builder = $db->table('saiyoojyam_rooms')->where('LOWER(rooms_name)', strtolower($cleanNum));
                    if ($buildingId > 0) {
                        $builder->where('rooms_building', $buildingId);
                    }
                    $roomRow = $builder->get()->getRow();

                    if (!$roomRow) {
                        $roomRow = $db->table('saiyoojyam_rooms')->where('LOWER(rooms_name)', strtolower($cleanNum))->get()->getRow();
                    }
                }

                // If still not found and buildingId is specified, pick first room in that building
                if (!$roomRow && $buildingId > 0) {
                    $roomRow = $db->table('saiyoojyam_rooms')->where('rooms_building', $buildingId)->get()->getRow();
                }
            }

            if ($roomRow) {
                $roomId = (int) $roomRow->rooms_id;
                $roomTypeId = (int) $roomRow->rooms_type;
                if (!empty($roomRow->rooms_building)) {
                    $buildingId = (int) $roomRow->rooms_building;
                }
            } else {
                $roomId = (is_numeric($cleanNum) && (int) $cleanNum > 0) ? (int) $cleanNum : 1;
                $roomTypeId = (int) ($input['roomType'] ?? $input['inmates_room_type'] ?? 1);
            }

            if ($buildingId <= 0) {
                $buildingId = 1;
            }

            // 3. Resolve Tariff & Fees
            $tariffId = 0;
            $cautionDeposit = 0.0;
            $admissionFee = 0.0;
            $monthlyBaseRent = 0.0;

            if ($db->tableExists('saiyoojyam_tariffs')) {
                // Find tariff matching this exact room
                $tariffs = $db->table('saiyoojyam_tariffs')
                    ->orderBy('tariffs_id', 'DESC')
                    ->get()
                    ->getResult();

                foreach ($tariffs as $tf) {
                    if (!empty($tf->tariffs_rooms)) {
                        $rList = array_map('intval', explode(',', (string) $tf->tariffs_rooms));
                        if (in_array($roomId, $rList, true)) {
                            $tariffId = (int) $tf->tariffs_id;
                            $cautionDeposit = (float) ($tf->tariffs_caution_deposit ?? 0);
                            $admissionFee = (float) ($tf->tariffs_admission_fees ?? 0);
                            $monthlyBaseRent = (float) ($tf->tariffs_price ?? 0);
                            break;
                        }
                    }
                }
            }

            if ($cautionDeposit <= 0 && isset($input['cautionDeposit'])) {
                $cautionDeposit = (float) $input['cautionDeposit'];
            }
            if ($admissionFee <= 0 && isset($input['admissionFees'])) {
                $admissionFee = (float) $input['admissionFees'];
            }
            if ($cautionDeposit <= 0 && $buildingId > 0 && $db->tableExists('saiyoojyam_building')) {
                $bRow = $db->table('saiyoojyam_building')->where('building_id', $buildingId)->get()->getRow();
                if ($bRow && !empty($bRow->building_caution_deposit)) {
                    $cautionDeposit = (float) $bRow->building_caution_deposit;
                }
            }
            if ($admissionFee <= 0 && $buildingId > 0 && $db->tableExists('saiyoojyam_building')) {
                $bRow = $db->table('saiyoojyam_building')->where('building_id', $buildingId)->get()->getRow();
                if ($bRow && !empty($bRow->building_admission_fees)) {
                    $admissionFee = (float) $bRow->building_admission_fees;
                }
            }
            if ($monthlyBaseRent <= 0 && isset($input['monthlyRent'])) {
                $monthlyBaseRent = (float) $input['monthlyRent'];
            }

            // 4. Resolve Duration of Stay
            $rawDuration = $input['duration'] ?? $input['inmates_duration_of_stay'] ?? 'Long Term';
            $durationId = 2; // Default to Long Term (id: 2)
            if (is_numeric($rawDuration)) {
                $durationId = (int) $rawDuration;
            } elseif (stripos((string) $rawDuration, 'short') !== false) {
                $durationId = 1;
            } else {
                $durationId = 2;
            }

            // 5. Dates
            $rawCheckIn = $input['checkIn'] ?? $input['checkInDate'] ?? $input['inmates_check_in_date'] ?? date('Y-m-d');
            $checkInDate = !empty($rawCheckIn) ? date('Y-m-d', strtotime($rawCheckIn)) : date('Y-m-d');

            $rawCheckOut = $input['checkOut'] ?? $input['checkOutDate'] ?? $input['inmates_check_out_date'] ?? '';
            $checkOutDate = '0000-00-00';
            if (!empty($rawCheckOut) && $rawCheckOut !== '0000-00-00') {
                $checkOutDate = date('Y-m-d', strtotime($rawCheckOut));
            } elseif ($durationId === 1) {
                $checkOutDate = date('Y-m-d', strtotime($checkInDate . ' +7 days'));
            }

            // Check Room Availability
            if ($roomRow) {
                $checkOutHorizon = (!empty($checkOutDate) && $checkOutDate !== '0000-00-00') ? $checkOutDate : '9999-12-31';
                $occupiedCount = $db->table('saiyoojyam_inmates')
                    ->where('inmates_rooms', (int) $roomRow->rooms_id)
                    ->whereNotIn('inmates_status', ['checked_out', 'checkout', 'rejected', 'cancelled', 'inactive'])
                    ->where('inmates_check_in_date <', $checkOutHorizon)
                    ->groupStart()
                        ->where('inmates_check_out_date >', $checkInDate)
                        ->orWhere('inmates_check_out_date IS NULL')
                        ->orWhere('inmates_check_out_date', '')
                        ->orWhere('inmates_check_out_date', '0000-00-00')
                    ->groupEnd()
                    ->countAllResults();

                $cap = (int) $roomRow->rooms_capacity;
                if ($occupiedCount >= $cap) {
                    return $this->response->setStatusCode(400)->setJSON([
                        'status'  => false,
                        'message' => 'Sorry, Room ' . $roomRow->rooms_name . ' is not available for the selected stay dates. All ' . $cap . ' beds are fully booked. Please select another room or choose different dates.',
                    ]);
                }
            }

            // 6. Handle File Uploads (ID proof & Photo)
            $idProofName = trim($input['idProofFileName'] ?? '');
            $photoName = trim($input['photoFileName'] ?? '');

            $uploadDirs = [
                WRITEPATH . 'uploads/inmates/',
                FCPATH . 'uploads/inmates/',
            ];
            foreach ($uploadDirs as $dir) {
                if (!is_dir($dir)) {
                    @mkdir($dir, 0777, true);
                }
            }

            $idProofFile = $this->request->getFile('inmates_id_proof') ?? $this->request->getFile('idProof');
            if ($idProofFile && $idProofFile->isValid() && !$idProofFile->hasMoved()) {
                $idProofName = $idProofFile->getRandomName();
                $idProofFile->move($uploadDirs[0], $idProofName);
                @copy($uploadDirs[0] . $idProofName, $uploadDirs[1] . $idProofName);
            }

            $photoFile = $this->request->getFile('inmates_photo') ?? $this->request->getFile('photo');
            if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                $photoName = $photoFile->getRandomName();
                $photoFile->move($uploadDirs[0], $photoName);
                @copy($uploadDirs[0] . $photoName, $uploadDirs[1] . $photoName);
            }

            // Check for rapid duplicate submission (e.g. double-clicking Make Payment)
            $recentInmate = $db->table('saiyoojyam_inmates')
                ->where('inmates_rooms', $roomId)
                ->where('inmates_check_in_date', $checkInDate)
                ->groupStart()
                    ->where('inmates_phone_no', $phone)
                    ->orWhere('inmates_email', $email)
                ->groupEnd()
                ->where('inmates_created_at >=', date('Y-m-d H:i:s', strtotime('-60 seconds')))
                ->orderBy('inmates_id', 'DESC')
                ->get()
                ->getRow();

            if ($recentInmate) {
                // Fetch the existing invoice for this recently created inmate
                $existingInvoice = $db->table('saiyoojyam_invoice')
                    ->where('invoice_inmates', (string) $recentInmate->inmates_id)
                    ->orderBy('invoice_id', 'DESC')
                    ->get()
                    ->getRow();

                $invPaymentMonth = $existingInvoice ? $existingInvoice->invoice_payment_month : $checkInDate;
                $invJoinDay = (int) date('j', strtotime($checkInDate));

                return $this->response->setJSON([
                    'status'  => true,
                    'message' => 'Room booking request submitted and payment received! Awaiting admin approval.',
                    'data'    => [
                        'inmates_id'               => (int) $recentInmate->inmates_id,
                        'inmates_uid'              => $recentInmate->inmates_uid,
                        'inmates_name'             => $recentInmate->inmates_name,
                        'inmates_building'         => (int) $recentInmate->inmates_building,
                        'inmates_rooms'            => (int) $recentInmate->inmates_rooms,
                        'inmates_check_in_date'    => $recentInmate->inmates_check_in_date,
                        'inmates_check_out_date'   => $recentInmate->inmates_check_out_date,
                        'inmates_duration_of_stay' => (int) $recentInmate->inmates_duration_of_stay,
                        'inmates_status'           => $recentInmate->inmates_status,
                        'inmates_email'            => $recentInmate->inmates_email,
                        'invoice'                  => $existingInvoice ? [
                            'invoice_id'              => (int) $existingInvoice->invoice_id,
                            'invoice_payment_month'   => $existingInvoice->invoice_payment_month,
                            'payment_month_display'   => ($invJoinDay >= 21 ? date('M Y', strtotime($checkInDate)) . ' & ' . date('M Y', strtotime($invPaymentMonth)) : date('M Y', strtotime($invPaymentMonth))),
                            'invoice_paid_date'       => $existingInvoice->invoice_paid_date,
                            'invoice_rent'            => (float) $existingInvoice->invoice_rent,
                            'invoice_caution_deposit' => (float) $recentInmate->inmates_caution_deposit,
                            'invoice_admission_fee'   => (float) $recentInmate->inmates_admission_fee,
                            'invoice_total'           => (float) $existingInvoice->invoice_total,
                            'invoice_paid_amount'     => (float) $existingInvoice->invoice_paid_amount,
                            'invoice_status'          => 'Fully Paid',
                        ] : null,
                        'receipt_url'              => base_url('Admin/Inmates/Receipt/' . $recentInmate->inmates_id),
                        'print_url'                => base_url('Admin/Inmates/Print/' . $recentInmate->inmates_id),
                        'api_print_url'            => base_url('api/inmates/print/' . $recentInmate->inmates_id),
                    ],
                ]);
            }

            // 7. Insert Inmate Record into saiyoojyam_inmates
            $inmateData = [
                'inmates_uid'              => '',
                'inmates_name'             => $name,
                'inmates_age'              => $age > 0 ? $age : 20,
                'inmates_building'         => $buildingId,
                'inmates_room_type'        => $roomTypeId,
                'inmates_rooms'            => $roomId,
                'inmates_check_in_date'    => $checkInDate,
                'inmates_check_out_date'   => $checkOutDate,
                'inmates_duration_of_stay' => $durationId,
                'inmates_phone_no'         => $phone,
                'inmates_whats_app_number' => !empty($whatsapp) ? $whatsapp : $phone,
                'inmates_email'            => $email,
                'inmates_tariffs'          => $tariffId,
                'inmates_guardian_name'    => !empty($guardianName) ? $guardianName : $name,
                'inmates_relation'         => !empty($relation) ? $relation : 'Guardian',
                'inmates_guardian_contact' => !empty($guardianContact) ? $guardianContact : $phone,
                'inmates_id_proof'         => $idProofName ?: '',
                'inmates_photo'            => $photoName ?: '',
                'inmates_status'           => 'pending',
                'inmates_caution_deposit'  => $cautionDeposit,
                'inmates_admission_fee'    => $admissionFee,
                'inmates_place_of_work'    => !empty($placeOfWork) ? $placeOfWork : 'Self/Employed',
                'inmates_created_at'       => date('Y-m-d H:i:s'),
            ];

            $db->table('saiyoojyam_inmates')->insert($inmateData);
            $insertId = $db->insertID();

            if ($db->tableExists('saiyoojyam_customers') && !empty($email)) {
                $existingCust = $db->table('saiyoojyam_customers')->where('customer_email', $email)->get()->getRow();
                if (!$existingCust) {
                    $db->table('saiyoojyam_customers')->insert([
                        'customer_name'  => $name,
                        'customer_email' => $email,
                        'customer_phone' => $phone,
                        'created_at'     => date('Y-m-d H:i:s'),
                        'updated_at'     => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            // 8. Generate and update inmates_uid
            helper('inmates');
            $uid = function_exists('new_booking_id')
                ? new_booking_id($insertId, 'IN')
                : sprintf('IN%06d', $insertId);

            $db->table('saiyoojyam_inmates')
                ->where('inmates_id', $insertId)
                ->update(['inmates_uid' => $uid]);

            // 9. Process Initial Payment & Generate Invoice (same flow as Admin/Inmates/AddReceipt)
            $currentDate = date('Y-m-d');
            $join_y = (int) date('Y', strtotime($checkInDate));
            $join_m = (int) date('m', strtotime($checkInDate));
            $join_day = (int) date('j', strtotime($checkInDate));
            $join_month_days = cal_days_in_month(CAL_GREGORIAN, $join_m, $join_y);

            // Check if Short Term stay with specified checkout date
            if ($durationId === 1 && !empty($checkOutDate) && $checkOutDate !== '0000-00-00') {
                $dIn = new \DateTime($checkInDate);
                $dOut = new \DateTime($checkOutDate);
                $diff = $dIn->diff($dOut);
                $stayDays = max(1, (int) $diff->days);
                $perDay = $monthlyBaseRent > 0 ? ($monthlyBaseRent / $join_month_days) : 0;
                $calculatedRent = round($stayDays * $perDay, 2);
                $paymentMonth = date('Y-m-01', strtotime($checkInDate));
            // Long Term Monthly Rules:
            // 1. If person comes before or on 5th: full month rent
            } elseif ($join_day <= 5) {
                $paymentMonth = date('Y-m-01', strtotime($checkInDate));
                $calculatedRent = $monthlyBaseRent;
            // 2. Until 20th of a month: collect rent from joining date till end of the month
            // Rent/day = (monthly rent) / (No. of days in the month)
            } elseif ($join_day <= 20) {
                $paymentMonth = date('Y-m-01', strtotime($checkInDate));
                $stayDays = $join_month_days - $join_day + 1;
                $perDay = $monthlyBaseRent > 0 ? ($monthlyBaseRent / $join_month_days) : 0;
                $calculatedRent = round($stayDays * $perDay, 2);
            // 3. From 21st: Rent = Rent for the days left in current month + next month rent
            } else {
                $paymentMonth = date('Y-m-01', strtotime('first day of next month', strtotime($checkInDate)));
                $stayDays = $join_month_days - $join_day + 1;
                $perDay = $monthlyBaseRent > 0 ? ($monthlyBaseRent / $join_month_days) : 0;
                $calculatedRent = $monthlyBaseRent + round($stayDays * $perDay, 2);
            }

            $totalAmount = $calculatedRent + $cautionDeposit + $admissionFee;
            $paidAmount = $totalAmount;

            $invoiceData = [
                'invoice_rent'          => $calculatedRent,
                'invoice_total'         => $totalAmount,
                'invoice_paid_amount'   => $paidAmount,
                'invoice_balance'       => 0.00,
                'invoice_advance'       => 0.00,
                'invoice_inmates'       => (string) $insertId,
                'invoice_paid_date'     => $currentDate,
                'invoice_payment_month' => $paymentMonth,
                'invoice_status'        => 1, // Fully Paid
            ];

            $db->table('saiyoojyam_invoice')->insert($invoiceData);
            $invoiceId = $db->insertID();

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Room booking request submitted and payment received! Awaiting admin approval.',
                'data'    => [
                    'inmates_id'               => $insertId,
                    'inmates_uid'              => $uid,
                    'inmates_name'             => $name,
                    'inmates_building'         => $buildingId,
                    'inmates_rooms'            => $roomId,
                    'inmates_check_in_date'    => $checkInDate,
                    'inmates_check_out_date'   => $checkOutDate,
                    'inmates_duration_of_stay' => $durationId,
                    'inmates_status'           => 'pending',
                    'inmates_email'            => $email,
                    'invoice'                  => [
                        'invoice_id'              => $invoiceId,
                        'invoice_payment_month'   => $paymentMonth,
                        'payment_month_display'   => ($join_day >= 21 ? date('M Y', strtotime($checkInDate)) . ' & ' . date('M Y', strtotime($paymentMonth)) : date('M Y', strtotime($paymentMonth))),
                        'invoice_paid_date'       => $currentDate,
                        'invoice_rent'            => $calculatedRent,
                        'invoice_caution_deposit' => $cautionDeposit,
                        'invoice_admission_fee'   => $admissionFee,
                        'invoice_total'           => $totalAmount,
                        'invoice_paid_amount'     => $paidAmount,
                        'invoice_status'          => 'Fully Paid',
                    ],
                    'receipt_url'              => base_url('Admin/Inmates/Receipt/' . $insertId),
                    'print_url'                => base_url('Admin/Inmates/Print/' . $insertId),
                    'api_print_url'            => base_url('api/inmates/print/' . $insertId),
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[Api\Inmates::create] Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ]);
        }
    }

    public function receipt($id)
    {
        $this->setCorsHeaders();
        $db = Database::connect();

        $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', (int) $id)->get()->getRow();
        if (!$inmate) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'Inmate not found',
            ]);
        }

        $invoices = $db->table('saiyoojyam_invoice')
            ->where('invoice_inmates', (string) $id)
            ->orderBy('invoice_id', 'DESC')
            ->get()
            ->getResult();

        $building = $db->table('saiyoojyam_building')->where('building_id', (int) $inmate->inmates_building)->get()->getRow();
        $room = $db->table('saiyoojyam_rooms')->where('rooms_id', (int) $inmate->inmates_rooms)->get()->getRow();

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'inmate'   => $inmate,
                'building' => $building,
                'room'     => $room,
                'invoices' => $invoices,
                'print_url' => base_url('api/inmates/print/' . $id),
            ],
        ]);
    }

    /**
     * Resident Inmate Dynamic Dashboard API
     * GET /api/inmates/dashboard?inmate_id=119&email=...&user_id=...
     */
    public function dashboard($paramId = null)
    {
        $this->setCorsHeaders();
        $db = Database::connect();

        $inmateId = (int) ($paramId ?: $this->request->getGet('inmate_id') ?: $this->request->getGet('inmates_id') ?: 0);
        $userId   = (int) ($this->request->getGet('user_id') ?: 0);
        $email    = trim((string) ($this->request->getGet('email') ?: ''));
        $username = trim((string) ($this->request->getGet('username') ?: ''));

        $inmate = null;

        if ($inmateId > 0) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', $inmateId)->get()->getRow();
        }

        if (!$inmate && $userId > 0) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_user_id', $userId)->orderBy('inmates_id', 'DESC')->get()->getRow();
        }

        if (!$inmate && !empty($email)) {
            $inmate = $db->table('saiyoojyam_inmates')->where('LOWER(inmates_email)', strtolower($email))->orderBy('inmates_id', 'DESC')->get()->getRow();
        }

        if (!$inmate && !empty($username)) {
            $u = $db->table('users')->where('LOWER(username)', strtolower($username))->get()->getRow();
            if ($u) {
                $inmate = $db->table('saiyoojyam_inmates')->where('inmates_user_id', (int) $u->id)->orderBy('inmates_id', 'DESC')->get()->getRow();
            }
        }

        if (!$inmate) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'Resident inmate record not found.',
            ]);
        }

        $id = (int) $inmate->inmates_id;

        // Fetch Related Data
        $building = $db->table('saiyoojyam_building')->where('building_id', (int) $inmate->inmates_building)->get()->getRow();
        $room = $db->table('saiyoojyam_rooms')->where('rooms_id', (int) $inmate->inmates_rooms)->get()->getRow();
        $roomType = $db->table('saiyoojyam_room_type')->where('room_type_id', (int) $inmate->inmates_room_type)->get()->getRow();
        $tariff = $db->table('saiyoojyam_tariffs')->where('tariffs_id', (int) $inmate->inmates_tariffs)->get()->getRow();

        // Invoices (fetch chronologically for accurate calculation, then format in reverse)
        $invoices = $db->table('saiyoojyam_invoice')
            ->where('invoice_inmates', (string) $id)
            ->orderBy('invoice_payment_month', 'ASC')
            ->get()
            ->getResult();

        // User / Shield Details
        $userRow = null;
        if (!empty($inmate->inmates_user_id)) {
            $userRow = $db->table('users')->where('id', (int) $inmate->inmates_user_id)->get()->getRow();
        }
        if (!$userRow && !empty($inmate->inmates_email)) {
            $ident = $db->table('auth_identities')
                ->where('type', 'email_password')
                ->where('LOWER(secret)', strtolower($inmate->inmates_email))
                ->get()
                ->getRow();
            if ($ident) {
                $userRow = $db->table('users')->where('id', (int) $ident->user_id)->get()->getRow();
                if ($userRow && empty($inmate->inmates_user_id)) {
                    $db->table('saiyoojyam_inmates')->where('inmates_id', (int) $inmate->inmates_id)->update(['inmates_user_id' => (int) $userRow->id]);
                }
            }
        }

        $monthlyRent = 0.0;
        if ($tariff && !empty($tariff->tariffs_price)) {
            $monthlyRent = (float) $tariff->tariffs_price;
        } elseif (!empty($invoices)) {
            $monthlyRent = (float) $invoices[0]->invoice_rent;
        }

        $invoicedMonths = [];
        $pendingBills = [];
        $totalPendingAmount = 0.0;
        $roomLabelStr = ($room ? 'Room ' . $room->rooms_name : 'Hostel Bed') . ($room && $room->rooms_ac_type ? ' ' . $room->rooms_ac_type : '') . ' Rent (Monthly)';

        // 1. Check existing invoices for partial or unpaid records
        foreach ($invoices as $inv) {
            $mKey = !empty($inv->invoice_payment_month) ? date('Y-m-01', strtotime($inv->invoice_payment_month)) : '';
            if ($mKey) {
                $invoicedMonths[$mKey] = $inv;
            }
            $status = (int)$inv->invoice_status;

            if ($status === 0 || $status === 2) {
                $bal = ($status === 2 && (float)$inv->invoice_balance > 0)
                    ? (float)$inv->invoice_balance
                    : ((float)$inv->invoice_total - (float)$inv->invoice_paid_amount);

                if ($bal > 0) {
                    $mName = !empty($mKey) ? date('F Y', strtotime($mKey)) : 'Stay Period';
                    $isOverdue = (!empty($mKey) && strtotime($mKey) < strtotime(date('Y-m-01')));
                    $totalPendingAmount += $bal;

                    $pendingBills[] = [
                        'month_key'         => $mKey,
                        'month_name'        => $mName,
                        'period'            => $mName . ' Rent',
                        'room_label'        => $roomLabelStr,
                        'rent_amount'       => '₹' . number_format($bal, 2),
                        'rent_amount_num'   => $bal,
                        'total_payable'     => '₹' . number_format($bal, 2),
                        'total_payable_num' => $bal,
                        'due_date'          => !empty($mKey) ? date('05 M Y', strtotime($mKey)) : '05th of month',
                        'is_overdue'        => $isOverdue,
                        'status'            => ($status === 2) ? 'Partially Paid' : ($isOverdue ? 'Overdue' : 'Due Soon'),
                        'is_partial'        => ($status === 2),
                        'invoice_id'        => (int) $inv->invoice_id,
                        'meals_included'    => true,
                        'wifi_included'     => true,
                    ];
                }
            }
        }

        // 2. Determine un-invoiced months between last invoice and current/checkout date
        if (!empty($invoices)) {
            $latestInv = end($invoices);
            $startDate = new \DateTime($latestInv->invoice_payment_month);
            $startDate->modify('+1 month');
        } else {
            $ciDateStr = !empty($inmate->inmates_check_in_date) ? $inmate->inmates_check_in_date : date('Y-m-d');
            $ci = new \DateTime($ciDateStr);
            $ciDay = (int) $ci->format('j');
            if ($ciDay >= 21) {
                $ci->modify('first day of next month');
            } else {
                $ci->modify('first day of this month');
            }
            $startDate = $ci;
        }

        $targetDate = new \DateTime(date('Y-m-01'));
        $checkoutDate = (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date !== '0000-00-00')
            ? new \DateTime($inmate->inmates_check_out_date)
            : null;

        $curr = clone $startDate;
        while ($curr <= $targetDate) {
            if ($checkoutDate && $curr > $checkoutDate) {
                break;
            }

            $mKey = $curr->format('Y-m-01');
            if (!isset($invoicedMonths[$mKey])) {
                $mName = $curr->format('F Y');
                $isOverdue = ($curr < $targetDate);
                $totalPendingAmount += $monthlyRent;

                $pendingBills[] = [
                    'month_key'         => $mKey,
                    'month_name'        => $mName,
                    'period'            => $mName . ' Rent',
                    'room_label'        => $roomLabelStr,
                    'rent_amount'       => '₹' . number_format($monthlyRent, 2),
                    'rent_amount_num'   => $monthlyRent,
                    'total_payable'     => '₹' . number_format($monthlyRent, 2),
                    'total_payable_num' => $monthlyRent,
                    'due_date'          => $curr->format('05 M Y'),
                    'is_overdue'        => $isOverdue,
                    'status'            => $isOverdue ? 'Overdue' : 'Due Soon',
                    'is_partial'        => false,
                    'invoice_id'        => null,
                    'meals_included'    => true,
                    'wifi_included'     => true,
                ];
            }

            $curr->modify('+1 month');
        }

        // Format Invoices for History Tab (in descending order)
        $formattedInvoices = [];
        $reverseInvoices = array_reverse($invoices);
        $lastPaidPeriod = '';
        $lastPaidDate = '';

        foreach ($reverseInvoices as $inv) {
            $statusLabel = 'Unpaid';
            if ((int)$inv->invoice_status === 1) {
                $statusLabel = 'Paid';
            } elseif ((int)$inv->invoice_status === 2) {
                $statusLabel = 'Partial';
            } elseif ((int)$inv->invoice_status === 3) {
                $statusLabel = 'Advance';
            }

            $dateDisplay = !empty($inv->invoice_paid_date) && $inv->invoice_paid_date !== '0000-00-00'
                ? date('d M Y', strtotime($inv->invoice_paid_date))
                : (!empty($inv->invoice_created_at) ? date('d M Y', strtotime($inv->invoice_created_at)) : 'N/A');

            $monthDisplay = !empty($inv->invoice_payment_month)
                ? date('F Y', strtotime($inv->invoice_payment_month))
                : 'Stay Period';

            if (empty($lastPaidPeriod) && ((int)$inv->invoice_status === 1 || (int)$inv->invoice_status === 3)) {
                $lastPaidPeriod = $monthDisplay . ' Rent';
                $lastPaidDate = $dateDisplay;
            }

            $formattedInvoices[] = [
                'id'            => 'INV-' . str_pad($inv->invoice_id, 4, '0', STR_PAD_LEFT),
                'invoice_id'    => (int) $inv->invoice_id,
                'period'        => $monthDisplay . ' Rent',
                'date'          => $dateDisplay,
                'amount_num'    => (float) $inv->invoice_paid_amount,
                'amount'        => '₹' . number_format((float) $inv->invoice_paid_amount, 2),
                'total'         => '₹' . number_format((float) $inv->invoice_total, 2),
                'status'        => $statusLabel,
                'status_code'   => (int) $inv->invoice_status,
                'print_url'     => base_url('api/inmates/print/' . $id),
            ];
        }

        $pendingCount = count($pendingBills);
        $isAllPaid = ($pendingCount === 0);

        if ($isAllPaid) {
            $currentBill = [
                'period'           => !empty($lastPaidPeriod) ? $lastPaidPeriod : date('F Y') . ' Rent',
                'room_label'       => $roomLabelStr,
                'rent_amount'      => '₹' . number_format($monthlyRent, 2),
                'rent_amount_num'  => $monthlyRent,
                'total_payable'    => '₹0.00',
                'status'           => 'Paid',
                'is_paid'          => true,
                'last_paid_date'   => $lastPaidDate,
                'due_date'         => date('05 M Y', strtotime('+1 month')),
                'meals_included'   => true,
                'wifi_included'    => true,
            ];
        } else {
            $earliest = $pendingBills[0];
            $currentBill = [
                'period'           => $earliest['period'],
                'room_label'       => $roomLabelStr,
                'rent_amount'      => $earliest['rent_amount'],
                'rent_amount_num'  => $earliest['rent_amount_num'],
                'total_payable'    => '₹' . number_format($totalPendingAmount, 2),
                'total_payable_num'=> $totalPendingAmount,
                'status'           => $earliest['status'],
                'is_paid'          => false,
                'due_date'         => $earliest['due_date'],
                'meals_included'   => true,
                'wifi_included'    => true,
            ];
        }

        $terms = [];
        if ($db->tableExists('saiyoojyam_terms_conditions')) {
            $termRows = $db->table('saiyoojyam_terms_conditions')->orderBy('id', 'ASC')->get()->getResult();
            foreach ($termRows as $tRow) {
                $terms[] = [
                    'id'                => (int) $tRow->id,
                    'title'             => $tRow->title ?? '',
                    'small_description' => $tRow->small_description ?? '',
                    'desc'              => $tRow->small_description ?? '',
                    'pdf_file'          => $tRow->pdf_file ?? null,
                    'pdf_url'           => !empty($tRow->pdf_file) ? base_url('public/uploads/terms/' . $tRow->pdf_file) : '',
                    'download_url'      => base_url('api/terms/download/' . $tRow->id),
                ];
            }
        }

        $dashboardData = [
            'inmate' => [
                'id'               => (int) $inmate->inmates_id,
                'user_id'          => $userRow ? (int) $userRow->id : (int) ($inmate->inmates_user_id ?? 0),
                'uid'              => $inmate->inmates_uid,
                'name'             => $inmate->inmates_name,
                'username'         => $userRow ? $userRow->username : strtolower(str_replace(' ', '', $inmate->inmates_name)),
                'email'            => $inmate->inmates_email ?: '',
                'phone'            => $inmate->inmates_phone_no ?: '',
                'building_id'      => (int) $inmate->inmates_building,
                'building_name'    => $building ? $building->building_name : 'Saiyoojyam Ladies Hostel',
                'room_id'          => (int) $inmate->inmates_rooms,
                'room_name'        => $room ? $room->rooms_name : 'Assigned Bed',
                'room_type_name'   => $roomType ? $roomType->room_type_name : 'Hostel Sharing',
                'ac_type'          => $room ? ($room->rooms_ac_type ?: 'Non-AC') : 'Standard',
                'check_in_date'    => !empty($inmate->inmates_check_in_date) ? date('d M Y', strtotime($inmate->inmates_check_in_date)) : '',
                'check_out_date'   => !empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date !== '0000-00-00' ? date('d M Y', strtotime($inmate->inmates_check_out_date)) : '',
                'duration_of_stay' => $inmate->inmates_duration_of_stay,
                'status'           => $inmate->inmates_status,
                'monthly_rent'     => $monthlyRent,
                'caution_deposit'  => (float) $inmate->inmates_caution_deposit,
                'admission_fee'    => (float) $inmate->inmates_admission_fee,
            ],
            'current_bill'          => $currentBill,
            'pending_bills'         => $pendingBills,
            'pending_count'         => $pendingCount,
            'total_pending_amount'  => '₹' . number_format($totalPendingAmount, 2),
            'total_pending_amount_num' => $totalPendingAmount,
            'is_all_paid'           => $isAllPaid,
            'invoices'              => $formattedInvoices,
            'terms'                 => $terms,
            'print_url'             => base_url('api/inmates/print/' . $id),
        ];

        return $this->response->setJSON([
            'status' => true,
            'data'   => $dashboardData,
        ]);
    }

    /**
     * Settle Rent Payment Online (Single Month or All Pending)
     * POST /api/inmates/pay-rent
     */
    public function payRent()
    {
        $this->setCorsHeaders();
        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $db = Database::connect();

        $inmateId = (int) ($input['inmate_id'] ?? $input['inmates_id'] ?? 0);
        $userId   = (int) ($input['user_id'] ?? 0);
        $email    = trim((string) ($input['email'] ?? ''));
        $username = trim((string) ($input['username'] ?? ''));
        $monthKey = trim((string) ($input['month_key'] ?? $input['month'] ?? ''));
        $amount = (float) ($input['amount'] ?? 0);
        $invoiceId = (int) ($input['invoice_id'] ?? 0);
        $payAll = !empty($input['pay_all']);

        $inmate = null;
        if ($inmateId > 0) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', $inmateId)->get()->getRow();
        }
        if (!$inmate && $userId > 0) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_user_id', $userId)->orderBy('inmates_id', 'DESC')->get()->getRow();
        }
        if (!$inmate && !empty($email)) {
            $inmate = $db->table('saiyoojyam_inmates')->where('LOWER(inmates_email)', strtolower($email))->orderBy('inmates_id', 'DESC')->get()->getRow();
        }
        if (!$inmate && !empty($username)) {
            $u = $db->table('users')->where('LOWER(username)', strtolower($username))->get()->getRow();
            if ($u) {
                $inmate = $db->table('saiyoojyam_inmates')->where('inmates_user_id', (int) $u->id)->orderBy('inmates_id', 'DESC')->get()->getRow();
            }
        }

        if (!$inmate) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'Resident record not found.',
            ]);
        }

        $inmateId = (int) $inmate->inmates_id;

        $tariff = $db->table('saiyoojyam_tariffs')->where('tariffs_id', (int) $inmate->inmates_tariffs)->get()->getRow();
        $monthlyRent = $tariff && !empty($tariff->tariffs_price) ? (float) $tariff->tariffs_price : 200.00;

        if ($payAll && !empty($input['months']) && is_array($input['months'])) {
            $paidCount = 0;
            foreach ($input['months'] as $m) {
                $mKey = is_array($m) ? ($m['month_key'] ?? '') : (string) $m;
                $mAmt = is_array($m) && isset($m['amount_num']) ? (float) $m['amount_num'] : $monthlyRent;
                $mInvId = is_array($m) && isset($m['invoice_id']) ? (int) $m['invoice_id'] : 0;

                if (!empty($mKey)) {
                    $this->settleSingleMonth($db, $inmateId, $mKey, $mAmt, $mInvId, $monthlyRent);
                    $paidCount++;
                }
            }

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Successfully settled all ' . $paidCount . ' pending monthly rent invoices!',
            ]);
        }

        if (empty($monthKey)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Payment month is required.',
            ]);
        }

        if ($amount <= 0) {
            $amount = $monthlyRent;
        }

        $invId = $this->settleSingleMonth($db, $inmateId, $monthKey, $amount, $invoiceId, $monthlyRent);
        $monthName = date('F Y', strtotime($monthKey));

        return $this->response->setJSON([
            'status'     => true,
            'message'    => 'Payment of ₹' . number_format($amount, 2) . ' for ' . $monthName . ' Rent completed successfully!',
            'invoice_id' => $invId,
        ]);
    }

    private function settleSingleMonth($db, $inmateId, $monthKey, $amount, $invoiceId, $monthlyRent)
    {
        $existing = null;
        if ($invoiceId > 0) {
            $existing = $db->table('saiyoojyam_invoice')->where('invoice_id', $invoiceId)->get()->getRow();
        }
        if (!$existing) {
            $existing = $db->table('saiyoojyam_invoice')
                ->where('invoice_inmates', (string) $inmateId)
                ->where('invoice_payment_month', $monthKey)
                ->get()
                ->getRow();
        }

        $currentDate = date('Y-m-d');
        if ($existing) {
            $total = (float) $existing->invoice_total > 0 ? (float) $existing->invoice_total : $amount;
            $newPaid = (float) $existing->invoice_paid_amount + $amount;
            $newBal = max(0.0, $total - $newPaid);
            $newStatus = ($newBal <= 0) ? 1 : 2;

            $db->table('saiyoojyam_invoice')
                ->where('invoice_id', (int) $existing->invoice_id)
                ->update([
                    'invoice_paid_amount' => $newPaid,
                    'invoice_balance'     => $newBal,
                    'invoice_status'      => $newStatus,
                    'invoice_paid_date'   => $currentDate,
                ]);

            return (int) $existing->invoice_id;
        } else {
            $invData = [
                'invoice_inmates'       => (string) $inmateId,
                'invoice_payment_month' => $monthKey,
                'invoice_paid_date'     => $currentDate,
                'invoice_rent'          => $monthlyRent,
                'invoice_total'         => $amount,
                'invoice_paid_amount'   => $amount,
                'invoice_balance'       => 0.00,
                'invoice_advance'       => 0.00,
                'invoice_status'        => 1,
            ];
            $db->table('saiyoojyam_invoice')->insert($invData);
            return (int) $db->insertID();
        }
    }

    public function printReceipt($id)
    {
        $this->setCorsHeaders();
        $db = Database::connect();

        $invoiceId = $this->request->getGet('invoice_id');
        $inmate = null;
        $invRow = null;

        if (!empty($invoiceId)) {
            $invRow = $db->table('saiyoojyam_invoice')->where('invoice_id', (int) $invoiceId)->get()->getRow();
            if ($invRow && empty($id)) {
                $id = $invRow->invoice_inmates;
            }
        }

        if (!empty($id)) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', (int) $id)->get()->getRow();
        }

        if (!$inmate && !empty($id)) {
            $maybeInv = $db->table('saiyoojyam_invoice')->where('invoice_id', (int) $id)->get()->getRow();
            if ($maybeInv) {
                $invRow = $maybeInv;
                $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', (int) $invRow->invoice_inmates)->get()->getRow();
            }
        }

        if (!$inmate) {
            return $this->response->setStatusCode(404)->setBody('Receipt not found');
        }

        if (!$invRow) {
            $invRow = $db->table('saiyoojyam_invoice')->where('invoice_inmates', (string) $inmate->inmates_id)->orderBy('invoice_id', 'DESC')->get()->getRow();
        }

        $guestName = $inmate->inmates_name;
        $guestPhone = $inmate->inmates_phone_no;
        $joinDate = $inmate->inmates_check_in_date;
        $inmateUid = $inmate->inmates_uid;
        $building = 'Saiyoojyam Ladies Hostel';
        $room = 'Room';
        $buildingHeaderName = 'Saiyoojyam Ladies Hostel';
        $buildingAddressHtml = 'Prathibha Layout, Second Cross Road,<br>Block Panchayath Office Road, Kusumagiri P.O, Kakkanad, Kochi';
        $buildingContact = '';

        $bRow = $db->table('saiyoojyam_building')->where('building_id', (int) $inmate->inmates_building)->get()->getRow();
        if ($bRow) {
            $building = $bRow->building_name;
            $buildingHeaderName = !empty($bRow->building_name) ? $bRow->building_name : 'Saiyoojyam Ladies Hostel';
            if (!empty($bRow->building_address)) {
                $buildingAddressHtml = nl2br(htmlspecialchars($bRow->building_address));
            }
            if (!empty($bRow->building_whatsapp)) {
                $buildingContact = $bRow->building_whatsapp;
            }
        }
        $rRow = $db->table('saiyoojyam_rooms')->where('rooms_id', (int) $inmate->inmates_rooms)->get()->getRow();
        if ($rRow) {
            $room = 'Room ' . $rRow->rooms_name;
        }

        $paymentMonth = date('Y-m-01');
        $invoiceTotal = 0.0;
        $paidAmount = 0.0;
        $balanceAmount = 0.0;
        $advanceAmount = 0.0;
        $status = 1;
        $invoiceNo = $invRow ? $invRow->invoice_id : '';
        $invoicePaidDate = $invRow ? $invRow->invoice_paid_date : date('Y-m-d');

        $cautionDeposit = (float) $inmate->inmates_caution_deposit;
        $admissionFees = (float) $inmate->inmates_admission_fee;

        if ($invRow) {
            $paymentMonth   = $invRow->invoice_payment_month;
            $invoiceTotal   = (float) $invRow->invoice_total;
            $paidAmount     = (float) $invRow->invoice_paid_amount;
            $balanceAmount  = (float) $invRow->invoice_balance;
            $advanceAmount  = (float) $invRow->invoice_advance;
            $status         = (int) $invRow->invoice_status;
        } else {
            $tRow = !empty($inmate->inmates_tariffs) ? $db->table('saiyoojyam_tariffs')->where('tariffs_id', (int) $inmate->inmates_tariffs)->get()->getRow() : null;
            $rentRate = $tRow ? (float) $tRow->tariffs_price : 0.0;
            $invoiceTotal = $rentRate + $cautionDeposit + $admissionFees;
            $paidAmount = $invoiceTotal;
            $balanceAmount = 0.0;
            $status = 1;
        }

        $isFirstInvoice = false;
        if ($invRow) {
            $firstInv = $db->table('saiyoojyam_invoice')
                ->where('invoice_inmates', (string) $inmate->inmates_id)
                ->orderBy('invoice_id', 'ASC')
                ->get()->getRow();
            if ($firstInv && (int)$firstInv->invoice_id === (int)$invRow->invoice_id) {
                $isFirstInvoice = true;
            }
        } else {
            $isFirstInvoice = true;
        }

        if ($isFirstInvoice && ($cautionDeposit > 0 || $admissionFees > 0)) {
            $displayCaution = $cautionDeposit;
            $displayAdmission = $admissionFees;
            $displayRent = max(0.0, $invoiceTotal - ($displayCaution + $displayAdmission));
            if ($displayRent == 0 && $invRow && (float)$invRow->invoice_rent > 0) {
                $displayRent = (float)$invRow->invoice_rent;
            }
        } else {
            $displayCaution = 0.0;
            $displayAdmission = 0.0;
            if ($invRow) {
                $rentInDb = (float)$invRow->invoice_rent;
                if ($rentInDb > 0 && ($rentInDb != $balanceAmount || $balanceAmount == 0)) {
                    $displayRent = $rentInDb;
                } else {
                    $displayRent = $invoiceTotal;
                }
            } else {
                $displayRent = $invoiceTotal;
            }
        }

        $paymentMonthDisplay = date('F Y', strtotime($paymentMonth));
        if ($inmate) {
            $joinDay = (int)date('j', strtotime($joinDate));
            $nextMonthDate = date('Y-m-01', strtotime('first day of next month', strtotime($joinDate)));
            if ($joinDay >= 21 && $paymentMonth == $nextMonthDate) {
                $paymentMonthDisplay = date('F Y', strtotime($joinDate)) . ' & ' . date('F Y', strtotime($paymentMonth));
            }
        }

        $statusText = 'Fully Paid';
        $statusColor = '#2e7d32';
        if ($status == 2) {
            $statusText = 'Partially Paid';
            $statusColor = '#e65100';
        } elseif ($status == 3) {
            $statusText = 'Advance Paid';
            $statusColor = '#1565c0';
        } elseif ($status == 0) {
            $statusText = 'Unpaid';
            $statusColor = '#c62828';
        }

        $logo = base_url('assets/admin/img/logo.png');

        $html = '
    <html>
    <head><meta charset="utf-8"></head>
    <body style="font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #2c3e50;">

    <div style="border: 1px solid #ddd; padding: 20px; height: 100%; box-sizing: border-box;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 15px;">
            <img src="' . $logo . '" style="height: 50px; margin-bottom: 6px;">
            <h2 style="margin: 2px 0 4px 0; font-size: 20px; color: #1e293b; font-weight: bold;">' . htmlspecialchars($buildingHeaderName) . '</h2>
            <div style="font-size: 11px; color: #555; line-height: 1.4;">
                ' . $buildingAddressHtml . '
                ' . (!empty($buildingContact) ? '<br><span>Phone / WhatsApp: ' . htmlspecialchars($buildingContact) . '</span>' : '') . '
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #aaa; margin-bottom: 15px;">

        <!-- Title & Meta -->
        <div style="text-align: center; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 0.5px;">INVOICE & RECEIPT</h3>
            <div style="font-size: 12px; color: #555; margin-top: 5px;">
                ' . ($invoiceNo ? 'Invoice No: <strong>#INV-' . htmlspecialchars($invoiceNo) . '</strong> &nbsp;|&nbsp; ' : '') . '
                ' . ($inmateUid ? 'Booking ID: <strong>' . htmlspecialchars($inmateUid) . '</strong>' : '') . '
                ' . ($invoicePaidDate && $invoicePaidDate != '0000-00-00' ? ' &nbsp;|&nbsp; Date: <strong>' . date('d M Y', strtotime($invoicePaidDate)) . '</strong>' : '') . '
            </div>
        </div>

        <!-- Personal Info -->
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 12px; background-color: #f9f9f9;">
            <h4 style="margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #374151;">Personal Details</h4>
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="padding: 4px; width: 25%; font-weight: bold; color: #555;">Name</td>
                    <td style="padding: 4px; color: #111;">' . htmlspecialchars($guestName) . '</td>
                    ' . (!empty($guestPhone) ? '<td style="padding: 4px; width: 20%; font-weight: bold; color: #555;">Phone</td><td style="padding: 4px; color: #111;">' . htmlspecialchars($guestPhone) . '</td>' : '<td></td><td></td>') . '
                </tr>
                <tr>
                    <td style="padding: 4px; font-weight: bold; color: #555;">Join Date</td>
                    <td style="padding: 4px; color: #111;">' . date('d M Y', strtotime($joinDate)) . '</td>
                    <td style="padding: 4px; font-weight: bold; color: #555;">Payment Month</td>
                    <td style="padding: 4px; color: #111;">' . $paymentMonthDisplay . '</td>
                </tr>
            </table>
        </div>

        <!-- Room Info -->
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 12px; background-color: #fdfdfd;">
            <h4 style="margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #374151;">Room Details</h4>
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="padding: 4px; width: 25%; font-weight: bold; color: #555;">Building</td>
                    <td style="padding: 4px; color: #111;">' . htmlspecialchars($building) . '</td>
                    <td style="padding: 4px; width: 20%; font-weight: bold; color: #555;">Room</td>
                    <td style="padding: 4px; color: #111;">' . htmlspecialchars($room) . '</td>
                </tr>
            </table>
        </div>

        <!-- Payment Breakdown -->
        <div style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">
            <h4 style="margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #374151;">Payment Breakdown</h4>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; width: 60%; color: #374151;">Rent Amount</td>
                    <td style="padding: 6px; text-align: right; color: #111;">₹' . number_format($displayRent, 2) . '</td>
                </tr>
                ' . ($displayCaution > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; color: #374151;">Caution Deposit (One-time)</td>
                    <td style="padding: 6px; text-align: right; color: #111;">₹' . number_format($displayCaution, 2) . '</td>
                </tr>' : '') . '
                ' . ($displayAdmission > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; color: #374151;">Admission Fee (One-time)</td>
                    <td style="padding: 6px; text-align: right; color: #111;">₹' . number_format($displayAdmission, 2) . '</td>
                </tr>' : '') . '
                <tr style="border-top: 2px solid #cbd5e1; background-color: #f1f5f9;">
                    <td style="padding: 7px 6px; font-weight: bold; color: #0f172a;">Total Billed</td>
                    <td style="padding: 7px 6px; text-align: right; font-weight: bold; color: #0f172a;">₹' . number_format($invoiceTotal, 2) . '</td>
                </tr>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 6px; font-weight: bold; color: #2e7d32;">Amount Paid</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #2e7d32;">₹' . number_format($paidAmount, 2) . '</td>
                </tr>
                ' . ($balanceAmount > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb; background-color: #fef2f2;">
                    <td style="padding: 6px; font-weight: bold; color: #dc2626;">Balance Remaining</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #dc2626;">₹' . number_format($balanceAmount, 2) . '</td>
                </tr>' : '') . '
                ' . ($advanceAmount > 0 ? '
                <tr style="border-bottom: 1px solid #e5e7eb; background-color: #eff6ff;">
                    <td style="padding: 6px; font-weight: bold; color: #2563eb;">Advance Carried Forward</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #2563eb;">₹' . number_format($advanceAmount, 2) . '</td>
                </tr>' : '') . '
                <tr style="border-top: 1px solid #94a3b8;">
                    <td style="padding: 8px 6px; font-weight: bold; font-size: 13px;">Payment Status</td>
                    <td style="padding: 8px 6px; text-align: right; font-weight: bold; font-size: 13px; color: ' . $statusColor . ';">' . $statusText . '</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div style="text-align: center; font-size: 11px; color: #64748b; margin-top: 25px;">
            <p style="margin: 3px 0;">Thank you for staying with us at Saiyoojyam.</p>
            <p style="margin: 3px 0;">For queries, contact the hostel office.</p>
        </div>

    </div>

    </body>
    </html>';

        try {
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
            ]);
            $mpdf->WriteHTML($html);
            return $this->response
                ->setContentType('application/pdf')
                ->setBody($mpdf->Output('invoice_' . ($invoiceNo ? 'INV' . $invoiceNo : ($inmateUid ?: $id)) . '.pdf', 'I'));
        } catch (\Throwable $e) {
            return $this->response->setContentType('text/html')->setBody($html);
        }
    }
}
