<?php

namespace App\Controllers;

use Config\Database;

class Terms extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $terms = null;

        if ($db->tableExists('saiyoojyam_terms_conditions')) {
            $terms = $db->table('saiyoojyam_terms_conditions')->get()->getRow();
        }

        $data['terms'] = $terms;
        $data['seo'] = $this->common_model->SingleRow('saiyoojyam_seo', ['id' => 1]);

        return view('user/terms', $data);
    }
}

