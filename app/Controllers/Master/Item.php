<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Item extends BaseController
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
            'title' => 'Item',
        ];

        // Mengirim data item ke view
        return view('master/item/index', $data);
    }

    public function find_all()
    {
        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil semua data dari tabel Item
        $query = $db->table('item')->select('item.id, item.nama, kategori.nama as kategori, item.filename')->join('kategori', 'kategori.id = item.kategori_id', 'left')->get();

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

        // Melakukan query untuk mengambil data item berdasarkan ID
        $query = $db->table('item')->where('id', $id)->get();

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

    // Fungsi untuk mencari item berdasarkan kategori
    public function find_by_category_id($categoryId)
    {
        // Validasi ID kategori
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer'
        ]);

        if (!$validation->run(['id' => $categoryId])) {
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

        // Melakukan query untuk mengambil data item berdasarkan kategori
        $query = $db->table('item')->where('kategori_id', $categoryId)->get();

        // Cek apakah data ditemukan atau tidak
        if ($query->getResult()) {
            // Jika data ditemukan, kirim data sebagai respons JSON dengan kode status 200 OK
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $query->getResult()
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika data tidak ditemukan, kirim respons kosong dengan kode status 404 Not Found
            return $this->response->setStatusCode(404);
        }
    }

    public function create()
    {
        $namaItem = $this->request->getPost('nama');
        $kategoriId = $this->request->getPost('kategori_id');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|max_length[255]',
            'kategori_id' => 'required|integer',
            'gambar' => 'uploaded[gambar]|max_size[gambar,5120]|is_image[gambar]'
        ]);

        if (!$validation->run(['nama' => $namaItem, 'kategori_id' => $kategoriId])) {
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Proses upload gambar
        $gambar = $this->request->getFile('gambar');

        // Simpan gambar asli
        $gambarOriginalName = $gambar->getRandomName();
        $gambar->move(ROOTPATH . 'public/uploads/item/original', $gambarOriginalName);
        
        // Kompresi dan simpan thumbnail
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . 'public/uploads/item/original/' . $gambarOriginalName)
            ->resize(200, 200, true)
            ->save(ROOTPATH . 'public/uploads/item/thumbnail/' . $gambarOriginalName);

        // Mengambil instance koneksi database
        $db = \Config\Database::connect();
        // Melakukan query untuk menyimpan data ke tabel Item
        $data = [
            'nama' => $namaItem,
            'kategori_id' => $kategoriId,
            'filename' => $gambarOriginalName
        ];

        $query = $db->table('item')->insert($data);

        // Cek apakah data berhasil disimpan atau tidak
        if ($query) {
            $response = [
                'code' => 200,
                'message' => 'Data berhasil disimpan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menyimpan data.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $namaItem = $this->request->getPost('nama');
        $kategoriId = $this->request->getPost('kategori_id');
        $newGambar = $this->request->getFile('gambar');

        $validation_rules =[
            'id' => 'required|integer',
            'nama' => 'required|max_length[255]',
            'kategori_id' => 'required|integer'
        ];

        // Cek apakah ada gambar yang diunggah
        if ($newGambar) {
            $validation_rules['gambar'] = 'uploaded[gambar]|max_size[gambar,5120]|is_image[gambar]';
        }

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules($validation_rules);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Ambil data gambar yang akan diupdate
        $db = \Config\Database::connect();
        $gambar = $db->table('item')->where('id', $id)->get()->getRow();

        if (!$gambar) {
            $response = [
                'code' => 404,
                'message' => 'Data tidak ditemukan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(404);
        }

        // Periksa apakah ada gambar yang diunggah 
        if ($newGambar) {
            // Hapus gambar lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/item/original/' . $gambar->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/item/thumbnail/' . $gambar->filename;

            if (file_exists($originalFilePath)) {
                @unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                @unlink($thumbnailFilePath);
            }

            // Simpan gambar baru
            $gambarOriginalName = $newGambar->getRandomName();
            $newGambar->move(ROOTPATH . 'public/uploads/item/original', $gambarOriginalName);

            // Buat thumbnail dari gambar baru
            \Config\Services::image()
                ->withFile(ROOTPATH . 'public/uploads/item/original/' . $gambarOriginalName)
                ->resize(200, 200, true)
                ->save(ROOTPATH . 'public/uploads/item/thumbnail/' . $gambarOriginalName);

            // Update data gambar dengan gambar baru
            $data = [
                'nama' => $namaItem,
                'kategori_id' => $kategoriId,
                'filename' => $gambarOriginalName
            ];
        } else {
            // Jika tidak ada gambar yang diunggah, update data gambar tanpa mengubah gambar
            $data = [
                'nama' => $namaItem,
                'kategori_id' => $kategoriId,
            ];
        }

        // Lakukan proses update data gambar di database
        $updateQuery = $db->table('item')->where('id', $id)->update($data);

        if ($updateQuery) {
            $response = [
                'code' => 200,
                'message' => 'Data berhasil diperbarui.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal memperbarui data.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        // Validasi ID
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

        // Menghapus data item dari database
        $db = \Config\Database::connect();

        // Ambil nama file gambar sebelum menghapus dari database
        $gambar = $db->table('item')->select('filename')->where('id', $id)->get()->getRow();

        if ($gambar) {
            // Hapus gambar lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/item/original/' . $gambar->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/item/thumbnail/' . $gambar->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }

        $deleted = $db->table('item')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data item berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data item. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
