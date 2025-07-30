<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Gambar extends BaseController
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
            'title' => 'Gambar',
        ];

        // Mengirim data kategori ke view
        return view('master/gambar/index', $data);
    }
    public function find_all()
    {
        $db = \Config\Database::connect();

        $query = $db->table('gambar')->select('gambar.id, gambar.item_id, gambar.judul, gambar.deskripsi, gambar.filename, gambar.created_at, gambar.updated_at, item.nama as item_nama')
            ->join('item', 'item.id = gambar.item_id', 'left')
            ->get();

        if ($query->getResult()) {
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $query->getResult()
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(404);
        }
    }

    public function find_by_id($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer'
        ]);

        if (!$validation->run(['id' => $id])) {
            $errors = array_values($validation->getErrors())[0];
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        $db = \Config\Database::connect();

        // Melakukan JOIN antara tabel gambar, kategori, dan item berdasarkan id kategori dan id item pada gambar
        $query = $db->table('gambar')
            ->select('gambar.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = gambar.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('gambar.id', $id)
            ->get();

        $gambar = $query->getRow();

        if ($gambar) {
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $gambar
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(404);
        }
    }


    public function create()
    {
        $item_id = $this->request->getPost('item_id');
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'item_id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'gambar' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = array_values($validation->getErrors())[0];
            $response = [
                'code' => 400,
                'message' => $errors,
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Proses upload gambar
        $gambar = $this->request->getFile('gambar');

        // Simpan gambar asli
        $gambarOriginalName = $gambar->getRandomName();
        $gambar->move(ROOTPATH . 'public/uploads/gambar/original', $gambarOriginalName);

        // Kompresi dan simpan thumbnail
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . 'public/uploads/gambar/original/' . $gambarOriginalName)
            ->resize(400, 400, true)
            ->save(ROOTPATH . 'public/uploads/gambar/thumbnail/' . $gambarOriginalName);

        // Simpan data gambar ke database
        $db = \Config\Database::connect();
        $data = [
            'item_id' => $item_id,
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'filename' => $gambarOriginalName // Simpan nama file asli ke database
        ];

        $query = $db->table('gambar')->insert($data);

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
        // Ambil data dari formulir modal
        $id = $this->request->getPost('id');
        $newJudul = $this->request->getPost('judul');
        $newDeskripsi = $this->request->getPost('deskripsi');
        $newGambar = $this->request->getFile('gambar');

        $validation_rules = [
            'id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty'
        ];

        // Cek apakah ada gambar yang diunggah
        if ($newGambar) {
            $validation_rules['gambar'] = 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]';
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
        $gambar = $db->table('gambar')->where('id', $id)->get()->getRow();

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
            $originalFilePath = ROOTPATH . 'public/uploads/gambar/original/' . $gambar->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/gambar/thumbnail/' . $gambar->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }

            // Simpan gambar baru
            $gambarOriginalName = $newGambar->getRandomName();
            $newGambar->move(ROOTPATH . 'public/uploads/gambar/original', $gambarOriginalName);

            // Buat thumbnail dari gambar baru
            \Config\Services::image()
                ->withFile(ROOTPATH . 'public/uploads/gambar/original/' . $gambarOriginalName)
                ->resize(400, 400, true)
                ->save(ROOTPATH . 'public/uploads/gambar/thumbnail/' . $gambarOriginalName);

            // Update data gambar dengan gambar baru
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi,
                'filename' => $gambarOriginalName
            ];
        } else {
            // Jika tidak ada gambar yang diunggah, update data gambar tanpa mengubah gambar
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi
            ];
        }

        // Lakukan proses update data gambar di database
        $updateQuery = $db->table('gambar')->where('id', $id)->update($data);

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
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer'
        ]);

        if (!$validation->run(['id' => $id])) {
            $errors = array_values($validation->getErrors())[0];
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        $db = \Config\Database::connect();

        // Ambil nama file gambar sebelum menghapus dari database
        $gambar = $db->table('gambar')->select('filename')->where('id', $id)->get()->getRow();

        if ($gambar) {
            // Hapus gambar lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/gambar/original/' . $gambar->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/gambar/thumbnail/' . $gambar->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }

        // Hapus entri gambar dari database
        $deleted = $db->table('gambar')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data gambar berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data gambar. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }

    public function find_by_page()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10; // Jumlah gambar per halaman
        $start = ($page - 1) * $perPage;

        $db = \Config\Database::connect();
        $totalRows = $db->table('gambar')->countAllResults(); // Menghitung jumlah total data

        $query = $db->table('gambar')
            ->select('gambar.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = gambar.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->limit($perPage, $start)
            ->get();

        $gambar = $query->getResult();

        $totalPages = ceil($totalRows / $perPage); // Menghitung jumlah total halaman


        if ($gambar) {
            $response = [
                'status' => 200,
                'message' => 'Data ditemukan.',
                'data' => $gambar,
                'totalPages' => $totalPages,
                'currentPage' => $page
            ];

            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(404);
        }
    }
}
