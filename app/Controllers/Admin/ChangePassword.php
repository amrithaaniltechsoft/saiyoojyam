<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ChangePassword extends BaseController
{
    public function index()
    {
        return view('admin/change_password');
    }

    public function updatePassword()
    {
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (empty($newPassword) || empty($confirmPassword)) {
            $msg = 'Please fill in all password fields.';
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => false, 'msg' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url('Admin/ChangePassword'));
        }

        if ($newPassword !== $confirmPassword) {
            $msg = 'New password and confirm password do not match.';
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => false, 'msg' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url('Admin/ChangePassword'));
        }

        // 1. Get current user
        $users = auth()->getProvider();
        $user = $users->findById(auth()->id());

        if (!$user) {
            $msg = 'User not found or not authenticated.';
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => false, 'msg' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
            return redirect()->to(site_url('Admin/ChangePassword'));
        }

        // 2. Update password
        $user->password = $newPassword;

        // 3. Save to database (Shield handles hashing automatically)
        if ($users->save($user)) {
            $msg = 'Password updated successfully!';
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => true, 'msg' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'success', 'msg' => $msg]);
        } else {
            $errors = $users->errors();
            $msg = !empty($errors) ? implode(' ', $errors) : 'Failed to update password. Please check password criteria.';
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response->setJSON(['status' => false, 'msg' => $msg]);
            }
            $this->session->setFlashdata('alert', ['type' => 'error', 'msg' => $msg]);
        }

        return redirect()->to(site_url('Admin/ChangePassword'));
    }
}
