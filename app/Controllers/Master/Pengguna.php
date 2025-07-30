<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Pengguna extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('is_login')) {
            return redirect()->to(base_url('Auth'));
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Pengguna',
        ];

        // Mengirim data pengguna ke view
        return view('master/pengguna/index', $data);
    }

    public function find_all()
    {
        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil semua data dari tabel pengguna
        $query = $db->table('pengguna')->get();

        // Cek apakah ada data yang ditemukan
        if ($query->getResult()) {
            // Jika ada data, kirim data sebagai respons JSON dengan kode status 200 OK
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $query->getResult()
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika tidak ada data, kirim respons kosong dengan kode status 204 No Content
            return $this->response->setStatusCode(204);
        }
    }

    public function find_by_id($id)
    {
        // Validasi ID
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer'
        ]);

        if (!$validation->run(['id' => $id])) {
            // Jika validasi gagal, kirim pesan kesalahan pertama
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil data pengguna berdasarkan ID
        $query = $db->table('pengguna')->where('id', $id)->get();

        // Cek apakah data ditemukan atau tidak
        if ($query->getResult()) {
            // Jika data ditemukan, kirim data sebagai respons JSON dengan kode status 200 OK
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $query->getRow()
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika data tidak ditemukan, kirim respons kosong dengan kode status 404 Not Found
            return $this->response->setStatusCode(404);
        }
    }

    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|max_length[255]',
            'username' => 'required|max_length[255]', 
            'role' => 'required|max_length[255]',
            'is_active' => 'required|in_list[0,1]'
        ]);

        if (!$validation->run($this->request->getPost())) {
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        $db = \Config\Database::connect();

        /* Ternary ini untuk menghindari error password_hash yang tidak boleh null */
        $password = is_string($this->request->getPost('username')) ? $this->request->getPost('username') : 'admin';

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active')
        ];
        $query = $db->table('pengguna')->insert($data);

        if ($query) {
            $response = [
                'code' => 200,
                'message' => 'Data pengguna berhasil disimpan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menyimpan data pengguna. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }

    public function update()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer',
            'nama' => 'required|max_length[255]',
            'username' => 'required|max_length[255]', 
            'role' => 'required|max_length[255]',
            'is_active' => 'required|in_list[0,1]'
        ]);

        if (!$validation->run($this->request->getPost())) {
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        $db = \Config\Database::connect(); 

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'), 
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active')
        ];

        $id = $this->request->getPost('id');
        $query = $db->table('pengguna')->where('id', $id)->update($data);

        if ($query) {
            $response = [
                'code' => 200,
                'message' => 'Data pengguna berhasil diperbarui.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal mengupdate data pengguna. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }


    public function delete($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer'
        ]);

        if (!$validation->run(['id' => $id])) {
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        $db = \Config\Database::connect();
        $deleted = $db->table('pengguna')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data pengguna berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data pengguna. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
