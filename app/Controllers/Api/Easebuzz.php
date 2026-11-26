<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Easebuzz extends BaseController
{
    protected function setCorsHeaders()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept");
        header("Access-Control-Allow-Credentials: true");
    }

    public function initiate()
    {
        $this->setCorsHeaders();
        if (strtolower($this->request->getMethod()) === 'options') {
            return $this->response->setStatusCode(200);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        // Support EASEBUZZ_MERCHANT_KEY, or fallback to general MERCHANT_KEY
        $key = env('EASEBUZZ_MERCHANT_KEY') ?: getenv('EASEBUZZ_MERCHANT_KEY') ?: env('PAYU_MERCHANT_KEY') ?: getenv('PAYU_MERCHANT_KEY') ?: '';
        $salt = env('EASEBUZZ_MERCHANT_SALT') ?: getenv('EASEBUZZ_MERCHANT_SALT') ?: env('PAYU_MERCHANT_SALT') ?: getenv('PAYU_MERCHANT_SALT') ?: '';
        $env = env('EASEBUZZ_ENV') ?: getenv('EASEBUZZ_ENV') ?: 'test';

        $txnid = $input['txnid'] ?? ('EBZ_' . date('YmdHis') . rand(1000, 9999));
        $amount = number_format((float)($input['amount'] ?? 0), 2, '.', '');

        // Sanitize phone: Easebuzz strictly requires 10 digits only
        $rawPhone = preg_replace('/\D/', '', (string)($input['phone'] ?? ''));
        if (strlen($rawPhone) > 10) {
            $rawPhone = substr($rawPhone, -10);
        }
        $phone = (strlen($rawPhone) === 10) ? $rawPhone : '9999999999';

        // Sanitize firstname: Easebuzz expects alphanumeric
        $rawName = trim((string)($input['firstname'] ?? 'Guest'));
        $firstname = preg_replace('/[^a-zA-Z0-9\s]/', '', $rawName);
        if (empty($firstname)) {
            $firstname = 'Guest';
        }

        // Sanitize email
        $rawEmail = strtolower(trim((string)($input['email'] ?? 'guest@example.com')));
        $email = filter_var($rawEmail, FILTER_VALIDATE_EMAIL) ? $rawEmail : 'guest@example.com';

        // Sanitize productinfo (alphanumeric, max 50 chars)
        $rawProduct = preg_replace('/[^a-zA-Z0-9\s]/', '', (string)($input['productinfo'] ?? 'Hostel Room Reservation'));
        $productinfo = !empty(trim($rawProduct)) ? substr(trim($rawProduct), 0, 50) : 'Room Reservation';

        $origin = $_SERVER['HTTP_ORIGIN'] ?? (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_SCHEME) . '://' . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : null);
        $clientUrl = !empty($origin) ? rtrim($origin, '/') : rtrim(env('FRONTEND_URL', 'https://saiyoojyam-main-yyd7.vercel.app'), '/');
        $surl = !empty($input['surl']) ? $input['surl'] : "$clientUrl/checkout?payment_status=success";
        $furl = !empty($input['furl']) ? $input['furl'] : "$clientUrl/checkout?payment_status=failed";

        $udf1 = $input['udf1'] ?? '';
        $udf2 = $input['udf2'] ?? '';
        $udf3 = $input['udf3'] ?? '';
        $udf4 = $input['udf4'] ?? '';
        $udf5 = $input['udf5'] ?? '';

        // Easebuzz SHA-512 Hash calculation
        // key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||salt
        $hashString = "$key|$txnid|$amount|$productinfo|$firstname|$email|$udf1|$udf2|$udf3|$udf4|$udf5||||||$salt";
        $hash = strtolower(hash('sha512', $hashString));

        $initiateUrl = (strtolower((string) $env) === 'prod' || strtolower((string) $env) === 'production')
            ? 'https://pay.easebuzz.in/payment/initiateLink'
            : 'https://testpay.easebuzz.in/payment/initiateLink';

        $accessKey = null;
        $paymentUrl = null;

        // If Merchant Key & Salt are set, call Easebuzz initiateLink
        if (!empty($key) && !empty($salt)) {
            $postData = [
                'key'         => $key,
                'txnid'       => $txnid,
                'amount'      => $amount,
                'productinfo' => $productinfo,
                'firstname'   => $firstname,
                'phone'       => $phone,
                'email'       => $email,
                'surl'        => $surl,
                'furl'        => $furl,
                'hash'        => $hash,
                'udf1'        => $udf1,
                'udf2'        => $udf2,
                'udf3'        => $udf3,
                'udf4'        => $udf4,
                'udf5'        => $udf5,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $initiateUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $response = curl_exec($ch);
            curl_close($ch);

            $easebuzzError = null;
            if ($response) {
                $resData = json_decode($response, true);
                if (isset($resData['status']) && (int)$resData['status'] === 1 && !empty($resData['data'])) {
                    $accessKey = $resData['data'];
                    $paymentUrl = (strtolower((string) $env) === 'prod' || strtolower((string) $env) === 'production')
                        ? "https://pay.easebuzz.in/pay/$accessKey"
                        : "https://testpay.easebuzz.in/pay/$accessKey";
                } else {
                    $easebuzzError = $resData['error_desc'] ?? $resData['data'] ?? 'Easebuzz parameter validation failed';
                    log_message('error', '[Easebuzz::initiate] API Error: ' . json_encode($resData));
                }
            } else {
                $curlErr = curl_error($ch);
                $easebuzzError = !empty($curlErr) ? "cURL error: $curlErr" : 'No response from Easebuzz gateway';
                log_message('error', '[Easebuzz::initiate] cURL Failed: ' . $easebuzzError);
            }
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => [
                'gateway'        => 'Easebuzz',
                'is_configured'  => (!empty($key) && !empty($salt)),
                'key'            => $key,
                'txnid'          => $txnid,
                'amount'         => $amount,
                'productinfo'    => $productinfo,
                'firstname'      => $firstname,
                'email'          => $email,
                'phone'          => $phone,
                'access_key'     => $accessKey,
                'payment_url'    => $paymentUrl,
                'env'            => $env,
                'hash'           => $hash,
                'easebuzz_error' => $easebuzzError ?? null,
            ]
        ]);
    }

    /**
     * Server-side Cryptographic Response Hash Verification
     * Verifies reverse-hash signature sent by Easebuzz:
     * sha512(salt|status|udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key)
     */
    public function verify()
    {
        $this->setCorsHeaders();
        if (strtolower($this->request->getMethod()) === 'options') {
            return $this->response->setStatusCode(200);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        $key = env('EASEBUZZ_MERCHANT_KEY') ?: getenv('EASEBUZZ_MERCHANT_KEY') ?: '';
        $salt = env('EASEBUZZ_MERCHANT_SALT') ?: getenv('EASEBUZZ_MERCHANT_SALT') ?: '';

        $receivedHash = strtolower((string)($input['hash'] ?? ''));
        $status       = $input['status'] ?? '';
        $txnid        = $input['txnid'] ?? '';
        $amount       = number_format((float)($input['amount'] ?? 0), 2, '.', '');
        $productinfo  = $input['productinfo'] ?? '';
        $firstname    = $input['firstname'] ?? '';
        $email        = $input['email'] ?? '';
        $udf1         = $input['udf1'] ?? '';
        $udf2         = $input['udf2'] ?? '';
        $udf3         = $input['udf3'] ?? '';
        $udf4         = $input['udf4'] ?? '';
        $udf5         = $input['udf5'] ?? '';
        $udf6         = $input['udf6'] ?? '';
        $udf7         = $input['udf7'] ?? '';
        $udf8         = $input['udf8'] ?? '';
        $udf9         = $input['udf9'] ?? '';
        $udf10        = $input['udf10'] ?? '';

        $reverseHashString = "$salt|$status|$udf10|$udf9|$udf8|$udf7|$udf6|$udf5|$udf4|$udf3|$udf2|$udf1|$email|$firstname|$productinfo|$amount|$txnid|$key";
        $calculatedHash = strtolower(hash('sha512', $reverseHashString));

        $isValid = (!empty($receivedHash) && hash_equals($calculatedHash, $receivedHash));

        return $this->response->setJSON([
            'status'         => true,
            'is_valid'       => $isValid,
            'payment_status' => $status,
            'txnid'          => $txnid,
            'verified_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Webhook Handler for Easebuzz Server-to-Server Instant Payment Notifications (S2S)
     * Register in Easebuzz Merchant Dashboard -> Webhooks:
     * https://yourdomain.com/api/easebuzz/webhook
     */
    public function webhook()
    {
        $this->setCorsHeaders();
        if (strtolower($this->request->getMethod()) === 'options') {
            return $this->response->setStatusCode(200);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (empty($input)) {
            $raw = file_get_contents('php://input');
            $input = json_decode($raw, true) ?? [];
        }

        log_message('info', '[Easebuzz::webhook] Payload received: ' . json_encode($input));

        $key  = env('EASEBUZZ_MERCHANT_KEY') ?: getenv('EASEBUZZ_MERCHANT_KEY') ?: '';
        $salt = env('EASEBUZZ_MERCHANT_SALT') ?: getenv('EASEBUZZ_MERCHANT_SALT') ?: '';

        if (empty($key) || empty($salt)) {
            log_message('error', '[Easebuzz::webhook] Merchant key or salt not configured in .env');
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => false,
                'message' => 'Easebuzz gateway credentials not configured on server',
            ]);
        }

        $receivedHash = strtolower((string)($input['hash'] ?? ''));
        $status       = strtolower((string)($input['status'] ?? ''));
        $txnid        = trim((string)($input['txnid'] ?? ''));
        $easepayid    = trim((string)($input['easepayid'] ?? ''));
        $amount       = number_format((float)($input['amount'] ?? 0), 2, '.', '');
        $productinfo  = $input['productinfo'] ?? '';
        $firstname    = $input['firstname'] ?? '';
        $email        = $input['email'] ?? '';
        $phone        = $input['phone'] ?? '';
        $udf1         = $input['udf1'] ?? '';
        $udf2         = $input['udf2'] ?? '';
        $udf3         = $input['udf3'] ?? '';
        $udf4         = $input['udf4'] ?? '';
        $udf5         = $input['udf5'] ?? '';
        $udf6         = $input['udf6'] ?? '';
        $udf7         = $input['udf7'] ?? '';
        $udf8         = $input['udf8'] ?? '';
        $udf9         = $input['udf9'] ?? '';
        $udf10        = $input['udf10'] ?? '';

        // Cryptographic reverse hash check
        $reverseHashString = "$salt|$status|$udf10|$udf9|$udf8|$udf7|$udf6|$udf5|$udf4|$udf3|$udf2|$udf1|$email|$firstname|$productinfo|$amount|$txnid|$key";
        $calculatedHash = strtolower(hash('sha512', $reverseHashString));

        if (empty($receivedHash) || !hash_equals($calculatedHash, $receivedHash)) {
            log_message('error', '[Easebuzz::webhook] Hash verification failed for txnid: ' . $txnid . '. Expected: ' . $calculatedHash . ', Received: ' . $receivedHash);
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => false,
                'message' => 'Invalid signature hash',
            ]);
        }

        $db = \Config\Database::connect('default');

        // Check if payment was successful
        if ($status === 'success' || $status === 'user_success') {
            log_message('info', "[Easebuzz::webhook] Payment SUCCESS confirmed for txnid: $txnid, easepayid: $easepayid, amount: $amount");

            // 1. Record or update in saiyoojyam_payments
            if ($db->tableExists('saiyoojyam_payments')) {
                $existingPayment = $db->table('saiyoojyam_payments')
                    ->where('payments_amount', $amount)
                    ->groupStart()
                        ->where('payments_date', date('Y-m-d'))
                        ->orWhere('payments_status', 'pending')
                    ->groupEnd()
                    ->orderBy('payments_id', 'DESC')
                    ->get()
                    ->getRow();

                if ($existingPayment) {
                    $db->table('saiyoojyam_payments')
                        ->where('payments_id', $existingPayment->payments_id)
                        ->update([
                            'payments_status' => 'paid',
                            'payments_amount' => $amount,
                            'payments_date'   => date('Y-m-d'),
                        ]);
                }
            }

            // 2. If invoice ID or inmate ID was passed in udf, ensure invoice status is updated
            if (!empty($udf1) && is_numeric($udf1)) {
                $db->table('saiyoojyam_invoice')
                    ->where('invoice_id', (int)$udf1)
                    ->update([
                        'invoice_status'      => 1, // Fully Paid
                        'invoice_paid_amount' => $amount,
                        'invoice_paid_date'   => date('Y-m-d'),
                    ]);
            }

            return $this->response->setJSON([
                'status'        => true,
                'message'       => 'Webhook received and processed successfully',
                'txnid'         => $txnid,
                'easepayid'     => $easepayid,
                'payment_state' => 'CONFIRMED',
            ]);
        } else {
            log_message('warning', "[Easebuzz::webhook] Non-success status received: $status for txnid: $txnid");
            return $this->response->setJSON([
                'status'        => true,
                'message'       => 'Webhook received with status: ' . $status,
                'txnid'         => $txnid,
                'payment_state' => strtoupper($status),
            ]);
        }
    }
}
