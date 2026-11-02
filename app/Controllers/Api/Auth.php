<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;
use Config\Services;

class Auth extends BaseController
{
    private function setCorsHeaders()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }

    public function options()
    {
        $this->setCorsHeaders();
        return $this->response->setStatusCode(200)->setContentType('application/json')->setJSON(['status' => true]);
    }

    private function ensureTablesExist()
    {
        $db = Database::connect();
        $forge = Database::forge();

        // 1. saiyoojyam_customers table
        if (!$db->tableExists('saiyoojyam_customers')) {
            $forge->addField([
                'customer_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'customer_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'customer_email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => false,
                ],
                'customer_phone' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $forge->addKey('customer_id', true);
            $forge->createTable('saiyoojyam_customers', true);
        }

        // 2. saiyoojyam_email_otp table
        if (!$db->tableExists('saiyoojyam_email_otp')) {
            $forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => false,
                ],
                'otp' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '10',
                    'null'       => false,
                ],
                'expires_at' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
                'is_used' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                ],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('saiyoojyam_email_otp', true);
        }
    }

    /**
     * Send OTP to Email
     * POST /api/auth/send-otp
     */
    public function sendOtp()
    {
        $this->setCorsHeaders();
        $this->ensureTablesExist();

        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $email = strtolower(trim($input['email'] ?? ''));

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Please provide a valid email address.',
            ]);
        }

        $db = Database::connect();

        // Invalidate previous active OTPs for this email
        $db->table('saiyoojyam_email_otp')
            ->where('email', $email)
            ->where('is_used', 0)
            ->update(['is_used' => 1]);

        // Generate 6-digit numeric OTP
        $otp = (string) random_int(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', time() + 600); // 10 minutes expiry

        // Store OTP in database
        $db->table('saiyoojyam_email_otp')->insert([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s'),
            'is_used'    => 0,
        ]);

        // Prepare Email
        $emailSent = false;
        $debugError = null;
        try {
            $emailConfig = config('Email');
            $emailService = Services::email();
            $emailService->setFrom($emailConfig->fromEmail ?? 'websolutionstechsoft@gmail.com', 'Saiyoojyam Ladies Hostels');
            $emailService->setTo($email);
            $emailService->setSubject("Your Saiyoojyam Login OTP: {$otp}");
            $emailService->setMailType('html');

            $htmlMessage = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f7f7f9; margin: 0; padding: 24px; }
                    .card { max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #eaeaea; }
                    .header { background: #FF561C; padding: 24px; text-align: center; color: #ffffff; }
                    .header h1 { margin: 0; font-size: 20px; font-weight: 700; }
                    .body { padding: 32px 24px; text-align: center; color: #1a1a1a; }
                    .otp-box { display: inline-block; background: #FFF2ED; border: 2px dashed #FF561C; border-radius: 12px; padding: 14px 28px; font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #FF561C; margin: 20px 0; }
                    .note { font-size: 13px; color: #666666; line-height: 1.5; margin-top: 16px; }
                    .footer { padding: 16px; text-align: center; font-size: 11px; color: #999999; border-top: 1px solid #f0f0f0; }
                </style>
            </head>
            <body>
                <div class="card">
                    <div class="header">
                        <h1>Saiyoojyam Ladies Hostels</h1>
                    </div>
                    <div class="body">
                        <p style="font-size: 15px; margin-bottom: 8px;">Hello,</p>
                        <p style="font-size: 14px; color: #444; margin-bottom: 16px;">Use the One-Time Password (OTP) below to log into your account:</p>
                        <div class="otp-box">' . $otp . '</div>
                        <p class="note">This OTP is valid for <strong>10 minutes</strong>.<br>If you did not request this OTP, please disregard this email.</p>
                    </div>
                    <div class="footer">
                        &copy; ' . date('Y') . ' Saiyoojyam Ladies Hostels, Kakkanad, Kochi. All rights reserved.
                    </div>
                </div>
            </body>
            </html>';

            $emailService->setMessage($htmlMessage);
            $emailSent = (bool) $emailService->send(false);

            if (!$emailSent) {
                $debugError = $emailService->printDebugger(['headers']);
                log_message('error', 'OTP Email Send Error: ' . $debugError);
            }
        } catch (\Throwable $e) {
            $debugError = $e->getMessage();
            log_message('error', 'OTP Email Sending Exception: ' . $debugError);
            $emailSent = false;
        }

        return $this->response->setJSON([
            'status'    => true,
            'message'   => $emailSent
                ? 'OTP has been sent to ' . $email . '. Please check your inbox.'
                : 'Could not deliver email. Please check server SMTP configuration.',
            'email'     => $email,
            'emailSent' => $emailSent,
            'debugOtp'  => (!$emailSent ? $otp : null),
            'debugError'=> (!$emailSent ? $debugError : null),
        ]);
    }

    /**
     * Verify OTP and check if existing or new customer
     * POST /api/auth/verify-otp
     */
    public function verifyOtp()
    {
        $this->setCorsHeaders();
        $this->ensureTablesExist();

        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $email = strtolower(trim($input['email'] ?? ''));
        $otp   = trim($input['otp'] ?? '');

        if (empty($email) || empty($otp)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Email and OTP are both required.',
            ]);
        }

        $db = Database::connect();

        // Find active valid OTP
        $record = $db->table('saiyoojyam_email_otp')
            ->where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', 0)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        if (empty($record)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Invalid or expired OTP. Please try again or request a new code.',
            ]);
        }

        // Mark OTP as used
        $db->table('saiyoojyam_email_otp')
            ->where('id', $record->id)
            ->update(['is_used' => 1]);

        // Check if customer already exists in saiyoojyam_customers
        $customer = $db->table('saiyoojyam_customers')
            ->where('LOWER(customer_email)', $email)
            ->get()
            ->getRow();

        if (!empty($customer) && !empty($customer->customer_name)) {
            // Existing Customer
            return $this->response->setJSON([
                'status'        => true,
                'isNewCustomer' => false,
                'message'       => 'Welcome back, ' . $customer->customer_name . '!',
                'customer'      => [
                    'id'    => (int) $customer->customer_id,
                    'name'  => $customer->customer_name,
                    'email' => $customer->customer_email,
                    'phone' => $customer->customer_phone ?? '',
                ],
            ]);
        }

        // New Customer
        return $this->response->setJSON([
            'status'        => true,
            'isNewCustomer' => true,
            'message'       => 'OTP verified successfully. Please enter your name to complete registration.',
            'email'         => $email,
        ]);
    }

    /**
     * Complete Registration for New Customer
     * POST /api/auth/register-customer
     */
    public function registerCustomer()
    {
        $this->setCorsHeaders();
        $this->ensureTablesExist();

        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $email = strtolower(trim($input['email'] ?? ''));
        $name  = trim($input['name'] ?? '');
        $phone = trim($input['phone'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Valid email address is required.',
            ]);
        }

        if (empty($name)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Full name is required to complete registration.',
            ]);
        }

        $db = Database::connect();

        $existing = $db->table('saiyoojyam_customers')
            ->where('LOWER(customer_email)', $email)
            ->get()
            ->getRow();

        if (!empty($existing)) {
            $db->table('saiyoojyam_customers')
                ->where('customer_id', $existing->customer_id)
                ->update([
                    'customer_name'  => $name,
                    'customer_phone' => !empty($phone) ? $phone : $existing->customer_phone,
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);
            $customerId = (int) $existing->customer_id;
        } else {
            $db->table('saiyoojyam_customers')->insert([
                'customer_name'  => $name,
                'customer_email' => $email,
                'customer_phone' => $phone,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            $customerId = (int) $db->insertID();
        }

        return $this->response->setJSON([
            'status'        => true,
            'isNewCustomer' => false,
            'message'       => 'Welcome to Saiyoojyam, ' . $name . '!',
            'customer'      => [
                'id'    => $customerId,
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
            ],
        ]);
    }

    /**
     * Inmate / Resident Password Login
     * Accepts 'login' (Username or Email) and 'password'
     * POST /api/auth/login
     */
    public function login()
    {
        $this->setCorsHeaders();
        if (strtoupper($this->request->getMethod()) === 'OPTIONS') {
            return $this->response->setStatusCode(200)->setContentType('application/json')->setJSON(['status' => true]);
        }
        $this->ensureTablesExist();

        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $login    = trim((string) ($input['login'] ?? $input['username'] ?? $input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        if (empty($login) || empty($password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Please provide both your Username/Email and Password.',
            ]);
        }

        $db = Database::connect();

        // 1. Find User by Username or Email Identity
        $user = $db->table('users')
            ->where('LOWER(username)', strtolower($login))
            ->get()
            ->getRow();

        $identity = null;
        if ($user) {
            $identity = $db->table('auth_identities')
                ->where('user_id', $user->id)
                ->where('type', 'email_password')
                ->get()
                ->getRow();
        } else {
            // Try looking up by email in auth_identities
            $identity = $db->table('auth_identities')
                ->where('type', 'email_password')
                ->where('LOWER(secret)', strtolower($login))
                ->get()
                ->getRow();

            if ($identity) {
                $user = $db->table('users')
                    ->where('id', $identity->user_id)
                    ->get()
                    ->getRow();
            }
        }

        // 2. If user or identity not found, check if this email/phone has a pending booking
        if (!$user || !$identity) {
            $pendingInmate = $db->table('saiyoojyam_inmates')
                ->where('inmates_status', 'pending')
                ->groupStart()
                    ->where('LOWER(inmates_email)', strtolower($login))
                    ->orWhere('inmates_phone_no', $login)
                ->groupEnd()
                ->orderBy('inmates_id', 'DESC')
                ->get()
                ->getRow();

            if ($pendingInmate) {
                return $this->response->setStatusCode(403)->setJSON([
                    'status'    => false,
                    'isPending' => true,
                    'message'   => 'Your booking (' . $pendingInmate->inmates_uid . ') is currently awaiting admin approval. Your username and login password will be emailed to ' . ($pendingInmate->inmates_email ?: 'your email address') . ' once approved.',
                ]);
            }

            return $this->response->setStatusCode(401)->setJSON([
                'status'  => false,
                'message' => 'Invalid username/email or password. Please verify your credentials.',
            ]);
        }

        // 3. Verify Account Activation
        if (isset($user->active) && (int)$user->active !== 1) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => false,
                'message' => 'Your account is currently inactive. Please contact the hostel administration.',
            ]);
        }

        // 4. Verify Password Hash
        if (!password_verify($password, $identity->secret2)) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => false,
                'message' => 'Incorrect password. Please try again.',
            ]);
        }

        // 5. Update last activity timestamp
        $now = date('Y-m-d H:i:s');
        $db->table('users')->where('id', $user->id)->update(['last_active' => $now]);
        $db->table('auth_identities')->where('id', $identity->id)->update(['last_used_at' => $now]);

        // 6. Fetch Inmate Profile (with Building & Room Details)
        $inmate = $db->table('saiyoojyam_inmates')
            ->select('saiyoojyam_inmates.*, saiyoojyam_building.building_name, saiyoojyam_rooms.rooms_name')
            ->join('saiyoojyam_building', 'saiyoojyam_building.building_id = saiyoojyam_inmates.inmates_building', 'left')
            ->join('saiyoojyam_rooms', 'saiyoojyam_rooms.rooms_id = saiyoojyam_inmates.inmates_rooms', 'left')
            ->groupStart()
                ->where('saiyoojyam_inmates.inmates_user_id', $user->id)
                ->orWhere('LOWER(saiyoojyam_inmates.inmates_email)', strtolower($identity->secret))
            ->groupEnd()
            ->orderBy('saiyoojyam_inmates.inmates_id', 'DESC')
            ->get()
            ->getRow();

        // Also check saiyoojyam_users table as fallback
        $sUser = null;
        if ($db->tableExists('saiyoojyam_users')) {
            $sUser = $db->table('saiyoojyam_users')->where('users_id', $user->id)->get()->getRow();
        }

        $displayName = !empty($inmate->inmates_name)
            ? $inmate->inmates_name
            : (!empty($sUser->users_name) ? $sUser->users_name : $user->username);

        $phone = !empty($inmate->inmates_phone_no)
            ? $inmate->inmates_phone_no
            : (!empty($sUser->users_mobile) ? $sUser->users_mobile : '');

        $userData = [
            'id'            => (int) $user->id,
            'username'      => $user->username,
            'name'          => $displayName,
            'email'         => $identity->secret,
            'phone'         => $phone,
            'inmates_id'    => !empty($inmate->inmates_id) ? (int) $inmate->inmates_id : null,
            'inmates_uid'   => !empty($inmate->inmates_uid) ? $inmate->inmates_uid : '',
            'status'        => !empty($inmate->inmates_status) ? $inmate->inmates_status : 'active',
            'building_id'   => !empty($inmate->inmates_building) ? (int) $inmate->inmates_building : null,
            'building_name' => !empty($inmate->building_name) ? $inmate->building_name : '',
            'room_id'       => !empty($inmate->inmates_rooms) ? (int) $inmate->inmates_rooms : null,
            'room_name'     => !empty($inmate->rooms_name) ? $inmate->rooms_name : '',
            'check_in_date' => !empty($inmate->inmates_check_in_date) ? $inmate->inmates_check_in_date : '',
        ];

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Welcome back, ' . $displayName . '!',
            'user'    => $userData,
            'customer'=> [
                'id'    => (int) $user->id,
                'name'  => $displayName,
                'email' => $identity->secret,
                'phone' => $phone,
            ],
        ]);
    }

    /**
     * Helper to resolve CodeIgniter Shield User record from various payload fields
     */
    private function resolveUserRecord(array $input, $db)
    {
        $userId   = (int) ($input['user_id'] ?? $input['id'] ?? 0);
        $inmateId = (int) ($input['inmate_id'] ?? $input['inmates_id'] ?? 0);
        $email    = trim((string) ($input['email'] ?? ''));
        $username = trim((string) ($input['username'] ?? ''));

        $user = null;

        // 1. By direct Shield users.id
        if ($userId > 0) {
            $user = $db->table('users')->where('id', $userId)->get()->getRow();
        }

        // 2. By inmate_id -> inmates_user_id
        if (!$user && $inmateId > 0) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', $inmateId)->get()->getRow();
            if ($inmate) {
                if (!empty($inmate->inmates_user_id)) {
                    $user = $db->table('users')->where('id', (int) $inmate->inmates_user_id)->get()->getRow();
                }
                if (!$user && !empty($inmate->inmates_email)) {
                    $email = $inmate->inmates_email;
                }
            }
        }

        // 3. If $userId was actually an inmates_id
        if (!$user && $userId > 0) {
            $inmate = $db->table('saiyoojyam_inmates')->where('inmates_id', $userId)->get()->getRow();
            if ($inmate) {
                if (!empty($inmate->inmates_user_id)) {
                    $user = $db->table('users')->where('id', (int) $inmate->inmates_user_id)->get()->getRow();
                }
                if (!$user && !empty($inmate->inmates_email)) {
                    $email = $inmate->inmates_email;
                }
            }
        }

        // 4. By email in auth_identities
        if (!$user && !empty($email)) {
            $identity = $db->table('auth_identities')
                ->where('type', 'email_password')
                ->where('LOWER(secret)', strtolower($email))
                ->get()
                ->getRow();
            if ($identity) {
                $user = $db->table('users')->where('id', (int) $identity->user_id)->get()->getRow();
            }
        }

        // 5. By email in saiyoojyam_inmates
        if (!$user && !empty($email)) {
            $inmate = $db->table('saiyoojyam_inmates')
                ->where('LOWER(inmates_email)', strtolower($email))
                ->orderBy('inmates_id', 'DESC')
                ->get()
                ->getRow();
            if ($inmate && !empty($inmate->inmates_user_id)) {
                $user = $db->table('users')->where('id', (int) $inmate->inmates_user_id)->get()->getRow();
            }
        }

        // 6. By username in users table
        if (!$user && !empty($username)) {
            $user = $db->table('users')
                ->where('LOWER(username)', strtolower($username))
                ->get()
                ->getRow();
        }

        return $user;
    }

    /**
     * Dedicated Password Update Endpoint
     * POST /api/auth/update-password
     */
    public function updatePassword()
    {
        $this->setCorsHeaders();
        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $db = Database::connect();

        $currentPassword = (string) ($input['current_password'] ?? '');
        $newPassword     = (string) ($input['new_password'] ?? '');
        $confirmPassword = (string) ($input['confirm_password'] ?? '');

        if (empty($currentPassword)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Please enter your current password.',
            ]);
        }

        if (empty($newPassword)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Please enter your new password.',
            ]);
        }

        if (strlen($newPassword) < 8) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'New password must be at least 8 characters long.',
            ]);
        }

        if (!preg_match('/[a-z]/', $newPassword)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'New password must contain at least one lowercase letter.',
            ]);
        }

        if (!preg_match('/[A-Z]/', $newPassword)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'New password must contain at least one uppercase letter.',
            ]);
        }

        if (!preg_match('/[0-9]/', $newPassword)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'New password must contain at least one number.',
            ]);
        }

        if (!empty($confirmPassword) && $newPassword !== $confirmPassword) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'New password and confirm password do not match.',
            ]);
        }

        if ($currentPassword === $newPassword) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'New password must be different from your current password.',
            ]);
        }

        $user = $this->resolveUserRecord($input, $db);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'User account not found. Please log in again.',
            ]);
        }

        $identity = $db->table('auth_identities')
            ->where('user_id', (int) $user->id)
            ->where('type', 'email_password')
            ->get()
            ->getRow();

        if ($identity && !empty($identity->secret2)) {
            if (!password_verify($currentPassword, $identity->secret2)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'The current password you entered is incorrect.',
                ]);
            }
        }

        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $now = date('Y-m-d H:i:s');

        if ($identity) {
            $db->table('auth_identities')
                ->where('id', (int) $identity->id)
                ->update([
                    'secret2'    => $newHash,
                    'updated_at' => $now,
                ]);
        } else {
            $email = trim((string) ($input['email'] ?? ''));
            if (empty($email)) {
                $inmate = $db->table('saiyoojyam_inmates')->where('inmates_user_id', (int) $user->id)->get()->getRow();
                $email = $inmate ? $inmate->inmates_email : '';
            }
            $db->table('auth_identities')->insert([
                'user_id'    => (int) $user->id,
                'type'       => 'email_password',
                'name'       => '',
                'secret'     => $email ?: $user->username,
                'secret2'    => $newHash,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Password updated successfully! You can now use your new password.',
        ]);
    }

    /**
     * Update Account Profile / Password
     * POST /api/auth/update-profile
     */
    public function updateProfile()
    {
        $this->setCorsHeaders();
        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $db = Database::connect();

        $username        = trim((string) ($input['username'] ?? ''));
        $currentPassword = (string) ($input['current_password'] ?? '');
        $newPassword     = (string) ($input['new_password'] ?? '');

        // Resolve user using robust multi-attribute lookup
        $user = $this->resolveUserRecord($input, $db);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => false,
                'message' => 'User account not found.',
            ]);
        }

        $identity = $db->table('auth_identities')
            ->where('user_id', (int) $user->id)
            ->where('type', 'email_password')
            ->get()
            ->getRow();

        // If password update requested
        if (!empty($newPassword)) {
            if (empty($currentPassword)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'Current password is required to set a new password.',
                ]);
            }
            if (strlen($newPassword) < 8) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'New password must be at least 8 characters long.',
                ]);
            }
            if (!preg_match('/[a-z]/', $newPassword)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'New password must contain at least one lowercase letter.',
                ]);
            }
            if (!preg_match('/[A-Z]/', $newPassword)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'New password must contain at least one uppercase letter.',
                ]);
            }
            if (!preg_match('/[0-9]/', $newPassword)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'New password must contain at least one number.',
                ]);
            }
            if ($identity && !empty($identity->secret2) && !password_verify($currentPassword, $identity->secret2)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'Current password does not match.',
                ]);
            }

            // Hash and update
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $now = date('Y-m-d H:i:s');
            if ($identity) {
                $db->table('auth_identities')
                    ->where('id', (int) $identity->id)
                    ->update([
                        'secret2'    => $newHash,
                        'updated_at' => $now,
                    ]);
            } else {
                $email = trim((string) ($input['email'] ?? ''));
                $db->table('auth_identities')->insert([
                    'user_id'    => (int) $user->id,
                    'type'       => 'email_password',
                    'name'       => '',
                    'secret'     => $email ?: $user->username,
                    'secret2'    => $newHash,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // If username update requested
        if (!empty($username)) {
            // Check if username is taken by another user in Shield users table
            $existingUser = $db->table('users')
                ->where('LOWER(username)', strtolower($username))
                ->where('id !=', (int) $user->id)
                ->get()
                ->getRow();

            if ($existingUser) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => false,
                    'message' => 'The username "' . $username . '" is already taken. Please choose another username.',
                ]);
            }

            // 1. Update CodeIgniter Shield users table
            $db->table('users')->where('id', (int) $user->id)->update([
                'username'   => $username,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // 2. Update saiyoojyam_inmates table so profile name reflects changes
            $resolvedEmail = trim((string) ($input['email'] ?? ($identity ? $identity->secret : '')));
            $inmateId = (int) ($input['inmate_id'] ?? $input['inmates_id'] ?? 0);

            if ($inmateId > 0) {
                $db->table('saiyoojyam_inmates')->where('inmates_id', $inmateId)->update(['inmates_name' => $username]);
            } else {
                $db->table('saiyoojyam_inmates')->where('inmates_user_id', (int) $user->id)->update(['inmates_name' => $username]);
            }

            if (!empty($resolvedEmail)) {
                $db->table('saiyoojyam_inmates')->where('LOWER(inmates_email)', strtolower($resolvedEmail))->update(['inmates_name' => $username]);
            }

            // 3. Update saiyoojyam_customers table
            if ($db->tableExists('saiyoojyam_customers') && !empty($resolvedEmail)) {
                $db->table('saiyoojyam_customers')
                    ->where('LOWER(customer_email)', strtolower($resolvedEmail))
                    ->update([
                        'customer_name' => $username,
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);
            }

            // 4. Update saiyoojyam_users table
            if ($db->tableExists('saiyoojyam_users')) {
                $db->table('saiyoojyam_users')
                    ->where('users_id', (int) $user->id)
                    ->update(['users_name' => $username]);
            }
        }

        return $this->response->setJSON([
            'status'   => true,
            'message'  => 'Profile username updated successfully.',
            'username' => !empty($username) ? $username : $user->username,
        ]);
    }
}
