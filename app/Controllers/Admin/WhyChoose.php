<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class WhyChoose extends BaseController
{
    public function index()
    {
        $data["why_list"] = $this->common_model->FetchAllOrder("saiyoojyam_why_choose", "why_id", "DESC");
        return view("admin/view_why_choose", $data);
    }

    public function Add()
    {
        if ($this->request->getMethod() === "POST") {
            $photo = $this->request->getFile("image");
            $photoName = "";
            $uploadPath = FCPATH . "uploads/whychoose/";

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);
            }

            $insert_data = [
                "why_title"      => $this->request->getPost("title"),
                "why_desc"       => $this->request->getPost("description"),
                "why_image"      => $photoName,
                "why_order"      => $this->request->getPost("why_order") ?? 0,
                "why_created_at" => date("Y-m-d H:i:s")
            ];

            $this->common_model->InsertData("saiyoojyam_why_choose", $insert_data);

            $flashdata = [
                "type" => "success",
                "msg"  => "Added Successfully"
            ];
            $this->session->setFlashdata("alert", $flashdata);

            return redirect()->to(site_url("Admin/WhyChoose"));
        }

        return view("admin/add_why_choose");
    }

    public function Edit($id)
    {
        $data["why"] = $this->common_model->SingleRow("saiyoojyam_why_choose", ["why_id" => $id]);

        if ($this->request->getMethod() === "POST") {
            $photo = $this->request->getFile("image");
            $photoName = $data["why"]->why_image ?? "";
            $uploadPath = FCPATH . "uploads/whychoose/";

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                if (!empty($data["why"]->why_image) && file_exists($uploadPath . $data["why"]->why_image)) {
                    @unlink($uploadPath . $data["why"]->why_image);
                }
                $photoName = $photo->getRandomName();
                $photo->move($uploadPath, $photoName);
            }

            $update_data = [
                "why_title" => $this->request->getPost("title"),
                "why_desc"  => $this->request->getPost("description"),
                "why_image" => $photoName,
            ];

            if ($this->request->getPost("why_order") !== null) {
                $update_data["why_order"] = $this->request->getPost("why_order");
            }

            $this->common_model->EditData($update_data, ["why_id" => $id], "saiyoojyam_why_choose");

            $flashdata = [
                "type" => "success",
                "msg"  => "Updated Successfully"
            ];
            $this->session->setFlashdata("alert", $flashdata);

            return redirect()->to(site_url("Admin/WhyChoose"));
        }

        return view("admin/edit_why_choose", $data);
    }

    public function Delete($id)
    {
        $data["why"] = $this->common_model->SingleRow("saiyoojyam_why_choose", ["why_id" => $id]);
        if (!empty($data["why"]->why_image)) {
            $imgPath = FCPATH . "uploads/whychoose/" . $data["why"]->why_image;
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        $this->common_model->DeleteData("saiyoojyam_why_choose", ["why_id" => $id]);

        $flashdata = [
            "type" => "success",
            "msg"  => "Deleted Successfully"
        ];
        $this->session->setFlashdata("alert", $flashdata);

        return redirect()->to(site_url("Admin/WhyChoose"));
    }
}
