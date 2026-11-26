<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Payu extends BaseController
{
    protected function setCorsHeaders()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept");
        header("Access-Control-Allow-Credentials: true");
    }

    public function generateHash()
    {
        $this->setCorsHeaders();
        if (strtolower($this->request->getMethod()) === 'options') {
            return $this->response->setStatusCode(200);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        $key = env('PAYU_MERCHANT_KEY') ?: getenv('PAYU_MERCHANT_KEY') ?: '';
        $salt = env('PAYU_MERCHANT_SALT') ?: getenv('PAYU_MERCHANT_SALT') ?: '';
        $mode = env('PAYU_MODE') ?: getenv('PAYU_MODE') ?: 'test';

        $txnid = $input['txnid'] ?? ('TXN_' . date('YmdHis') . rand(1000, 9999));
        $amount = number_format((float)($input['amount'] ?? 0), 2, '.', '');
        $productinfo = $input['productinfo'] ?? 'Hostel Room Reservation';
        $firstname = $input['firstname'] ?? 'Guest';
        $email = $input['email'] ?? 'guest@example.com';
        $phone = $input['phone'] ?? '';
        $udf1 = $input['udf1'] ?? '';
        $udf2 = $input['udf2'] ?? '';
        $udf3 = $input['udf3'] ?? '';
        $udf4 = $input['udf4'] ?? '';
        $udf5 = $input['udf5'] ?? '';

        $hashString = "$key|$txnid|$amount|$productinfo|$firstname|$email|$udf1|$udf2|$udf3|$udf4|$udf5||||||$salt";
        $hash = strtolower(hash('sha512', $hashString));

        $actionUrl = (strtolower((string) $mode) === 'production')
            ? 'https://secure.payu.in/_payment'
            : 'https://test.payu.in/_payment';

        return $this->response->setJSON([
            'status' => true,
            'data' => [
                'action_url'    => $actionUrl,
                'key'           => $key,
                'txnid'         => $txnid,
                'amount'        => $amount,
                'productinfo'   => $productinfo,
                'firstname'     => $firstname,
                'email'         => $email,
                'phone'         => $phone,
                'hash'          => $hash,
                'mode'          => $mode,
                'is_configured' => (!empty($key) && !empty($salt)),
            ]
        ]);
    }
}
