<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use CodeIgniter\Images\Image;

class ChangePassword extends BaseController
{
    public function index(){
       
        return view('admin/change_password');
    }


    
    public function updatePassword()
    {
        // 1. Get current user
        $users = auth()->getProvider();
        $user = $users->findById(auth()->id());

        if($this->request->getPost('new_password') == $this->request->getPost('confirm_password')){

            // 3. Update password
            $user->password = $this->request->getPost('new_password');
        
            // 4. Save to database (Shield handles hashing automatically)
            $users->save($user);


            $flashdata = array(
                'type' => 'success',
                'msg'  => 'Password updated! Successfully',
            );
    
            $this->session->setFlashdata('alert',$flashdata);


        }
        else{

            $flashdata = array(
                'type' => 'error',
                'msg'  => 'New password and confirm password do not match',
            );
    
            $this->session->setFlashdata('alert',$flashdata);

        }



        return redirect()->to(site_url('Admin/ChangePassword/updatePassword'));

       
    }








   
}
