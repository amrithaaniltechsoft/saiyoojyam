<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(setting('Auth.redirects')['login']);
        }

        return view('admin/login');
    }

    public function login()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $validFields = config('Auth')->validFields;

        $credentials = [];

        foreach ($validFields as $field) {
            if (filter_var($login, FILTER_VALIDATE_EMAIL) && $field === 'email') {
                $credentials[$field] = $login;
                break;
            }
            if (! filter_var($login, FILTER_VALIDATE_EMAIL) && $field === 'username') {
                $credentials[$field] = $login;
                break;
            }
        }

        $credentials['password'] = $password;

        /** @var \CodeIgniter\Shield\Authentication\Authenticators\Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $result = $authenticator->attempt($credentials);

        if (! $result->isOK()) {
            session()->setFlashdata('error', $result->reason());

            return redirect()->to('/login')->withInput();
        }

        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->to('/login');
    }
}
