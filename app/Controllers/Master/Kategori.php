<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Kategori extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('is_login')) {
            header('Location: ' . base_url('Auth'));
            exit();
        }
    }
    public function index()
    {

        $data = [
            'title' => 'Kategori',
        ];

        // Mengirim data kategori ke view
        return view('master/kategori/index', $data);
    }

    public function find_all()
    {
        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil semua data dari tabel kategori (sesuaikan dengan nama tabel yang sesuai)
        $query = $db->table('kategori')->get();

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
            'id' => 'required|integer' // Sesuaikan dengan aturan validasi ID
        ]);

        if (!$validation->run(['id' => $id])) {
            // Jika validasi gagal, kirim pesan kesalahan pertama
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400, // Kode status Bad Request
                'message' => $errors[0], // Mengambil pesan kesalahan pertama
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil data kategori berdasarkan ID (sesuaikan dengan nama tabel yang sesuai)
        $query = $db->table('kategori')->where('id', $id)->get();

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


    // Fungsi untuk menyimpan data kategori ke database
    public function create()
    {
        // Ambil data nama kategori dari permintaan POST
        $namaKategori = $this->request->getPost('nama');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|max_length[255]', // Sesuaikan dengan aturan validasi nama
        ]);

        if (!$validation->run(['nama' => $namaKategori])) {
            // Jika validasi gagal, kirim pesan kesalahan pertama
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400, // Kode status Bad Request
                'message' => $errors[0], // Mengambil pesan kesalahan pertama
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk menyimpan data ke tabel kategori (sesuaikan dengan nama tabel yang sesuai)
        $data = [
            'nama' => $namaKategori
            // Tambahkan kolom-kolom lain yang perlu disimpan sesuai dengan struktur tabel Anda
        ];

        $query = $db->table('kategori')->insert($data);

        // Cek apakah data berhasil disimpan atau tidak
        if ($query) {
            // Jika berhasil, kembalikan respons sukses
            $response = [
                'code' => 200, // Kode status OK
                'message' => 'Data berhasil disimpan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika gagal, kembalikan respons error
            $response = [
                'code' => 500, // Kode status Internal Server Error
                'message' => 'Gagal menyimpan data.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }


    // Fungsi untuk menyimpan perubahan data kategori ke database (dipanggil oleh AJAX) 
    public function update()
    {
        // Ambil data dari input POST
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer', // Sesuaikan dengan aturan validasi ID
            'nama' => 'required|max_length[255]' // Sesuaikan dengan aturan validasi nama
        ]);

        if (!$validation->run($this->request->getPost())) {
            // Jika validasi gagal, kirim pesan kesalahan pertama
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400, // Kode status Bad Request
                'message' => $errors[0], // Mengambil pesan kesalahan pertama
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Mengupdate data kategori ke database
        $db = \Config\Database::connect();
        $data = [
            'nama' => $nama,
            // Tambahkan kolom lain yang perlu diupdate
        ];
        $affectedRows = $db->table('kategori')->where('id', $id)->update($data);

        if ($affectedRows > 0) {
            // Jika update berhasil
            $response = [
                'code' => 200, // Kode status OK
                'message' => 'Data kategori berhasil diperbarui.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika update gagal
            $response = [
                'code' => 500, // Kode status Internal Server Error
                'message' => 'Gagal mengupdate data kategori. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }

    // Fungsi untuk menghapus data kategori dari database
    public function delete($id)
    {
        // Validasi ID
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer' // Sesuaikan dengan aturan validasi ID
        ]);

        if (!$validation->run(['id' => $id])) {
            // Jika validasi gagal, kirim pesan kesalahan pertama
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400, // Kode status Bad Request
                'message' => $errors[0], // Mengambil pesan kesalahan pertama
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Menghapus data kategori dari database
        $db = \Config\Database::connect();
        $deleted = $db->table('kategori')->where('id', $id)->delete();

        if ($deleted) {
            // Jika berhasil menghapus data
            $response = [
                'code' => 200, // Kode status OK
                'message' => 'Data berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika gagal menghapus data
            $response = [
                'code' => 500, // Kode status Internal Server Error
                'message' => 'Gagal menghapus data. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
