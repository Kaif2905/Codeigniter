<?php

namespace App\Controllers;

use App\Models\UserDataModel;
use CodeIgniter\Controller;

class UserController extends Controller
{


    public function index()
    {
        return view('user_form');
    }






    public function success()
    {
        return view('success_message');
    }



 

    public function list()
    {
        $userDataModel = new UserDataModel();
        $data['users'] = $userDataModel->findAll();

        return view('user_list', $data);
    }









    ///////////////ADD DATA INTO DB//////////
    public function store()
    {
        if ($this->request->isAJAX()) {
            $userDataModel = new UserDataModel();
            $file = $this->request->getFile('remark'); // 'remark' is the name of the file input field

            if ($file->isValid() && !$file->hasMoved()) {
                // Validate file type and size
                $validationRule = [
                    'remark' => [
                        'uploaded[remark]',
                        'mime_in[remark,image/jpg,image/jpeg,image/png,image/gif]',
                        'max_size[remark,2048]', // 2MB
                    ],
                ];

                if (!$this->validate($validationRule)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['status' => 'error', 'message' => implode(', ', $errors)]);
                }

                // Generate a random name to avoid filename conflicts
                $newFileName = $file->getRandomName();

                // Move the file to the uploads directory
                $file->move(WRITEPATH . 'uploads', $newFileName);

                $data = [
                    'name'     => $this->request->getPost('name'),
                    'material' => $this->request->getPost('material'),
                    'detail'   => $this->request->getPost('detail'),
                    'quantity' => $this->request->getPost('quantity'),
                    'remark'   => $newFileName, // Save the file name to the database
                    'address'  => $this->request->getPost('address'),
                    'city'     => $this->request->getPost('city'),
                    'state'    => $this->request->getPost('state'),
                    'zip'      => $this->request->getPost('zip'),
                ];

                if ($userDataModel->insert($data)) {
                    $data['id'] = $userDataModel->insertID();
                    return $this->response->setJSON(['status' => 'success', 'data' => $data]);
                } else {
                    log_message('error', 'Failed to insert data: ' . print_r($userDataModel->errors(), true));
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save data']);
                }
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not an AJAX request']);
        }
    }

    //////////////////DELETE ////////////////////////
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $userDataModel = new UserDataModel();

            if ($userDataModel->delete($id)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data could not be deleted.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not an AJAX request']);
        }
    }

    ///////////////////UPDATE/////////////
    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $userDataModel = new UserDataModel();
            $file = $this->request->getFile('remark');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newFileName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newFileName);

                $data = [
                    'name'     => $this->request->getPost('name'),
                    'material' => $this->request->getPost('material'),
                    'detail'   => $this->request->getPost('detail'),
                    'quantity' => $this->request->getPost('quantity'),
                    'remark'   => $newFileName, // Update the file name in the database
                    'address'  => $this->request->getPost('address'),
                    'city'     => $this->request->getPost('city'),
                    'state'    => $this->request->getPost('state'),
                    'zip'      => $this->request->getPost('zip'),
                ];
            } else {
                // If no new file is uploaded, keep the old one
                $data = [
                    'name'     => $this->request->getPost('name'),
                    'material' => $this->request->getPost('material'),
                    'detail'   => $this->request->getPost('detail'),
                    'quantity' => $this->request->getPost('quantity'),
                    'address'  => $this->request->getPost('address'),
                    'city'     => $this->request->getPost('city'),
                    'state'    => $this->request->getPost('state'),
                    'zip'      => $this->request->getPost('zip'),
                ];
            }

            if ($userDataModel->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success', 'data' => $data]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data could not be updated.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not an AJAX request']);
        }
    }
}
