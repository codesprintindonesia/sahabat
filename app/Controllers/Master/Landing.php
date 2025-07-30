<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Landing extends BaseController
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
            'title' => 'Landing',
        ];

        // Mengirim data kategori ke view
        return view('master/landing/index', $data);
    }
    public function find_all()
    {
        $db = \Config\Database::connect();

        $query = $db->table('landing')->get();

        if ($query->getResult()) {
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $query->getResult()
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(204);
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

        // Melakukan JOIN antara tabel landing, kategori, dan item berdasarkan id kategori dan id item pada landing
        $query = $db->table('landing')
            ->select('landing.*')
            ->where('landing.id', $id)
            ->get();

        $landing = $query->getRow();

        if ($landing) {
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $landing
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(404);
        }
    }

    public function create()
    {
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'landing' => 'uploaded[landing]|max_size[landing,10024]|is_image[landing]'
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

        // Proses upload landing
        $landing = $this->request->getFile('landing');

        // Simpan landing asli
        $landingOriginalName = $landing->getRandomName();
        $landing->move(ROOTPATH . 'public/uploads/landing/original', $landingOriginalName);

        // Kompresi dan simpan thumbnail
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . 'public/uploads/landing/original/' . $landingOriginalName)
            ->resize(200, 200, true)
            ->save(ROOTPATH . 'public/uploads/landing/thumbnail/' . $landingOriginalName);

        // Simpan data landing ke database
        $db = \Config\Database::connect();
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'filename' => $landingOriginalName // Simpan nama file asli ke database
        ];

        $query = $db->table('landing')->insert($data);

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
        $newLanding = $this->request->getFile('landing');

        $validation_rules = [
            'id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty'
        ];

        // Cek apakah ada landing yang diunggah
        if ($newLanding) {
            $validation_rules['landing'] = 'uploaded[landing]|max_size[landing,10024]|is_image[landing]';
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

        // Ambil data landing yang akan diupdate
        $db = \Config\Database::connect();
        $landing = $db->table('landing')->where('id', $id)->get()->getRow();

        if (!$landing) {
            $response = [
                'code' => 404,
                'message' => 'Data tidak ditemukan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(404);
        }

        // Periksa apakah ada landing yang diunggah 
        if ($newLanding) {
            // Hapus landing lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/landing/original/' . $landing->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/landing/thumbnail/' . $landing->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }

            // Simpan landing baru
            $landingOriginalName = $newLanding->getRandomName();
            $newLanding->move(ROOTPATH . 'public/uploads/landing/original', $landingOriginalName);

            // Buat thumbnail dari landing baru
            \Config\Services::image()
                ->withFile(ROOTPATH . 'public/uploads/landing/original/' . $landingOriginalName)
                ->resize(200, 200, true)
                ->save(ROOTPATH . 'public/uploads/landing/thumbnail/' . $landingOriginalName);

            // Update data landing dengan landing baru
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi,
                'filename' => $landingOriginalName
            ];
        } else {
            // Jika tidak ada landing yang diunggah, update data landing tanpa mengubah landing
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi
            ];
        }

        // Lakukan proses update data landing di database
        $updateQuery = $db->table('landing')->where('id', $id)->update($data);

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

        // Ambil nama file landing sebelum menghapus dari database
        $landing = $db->table('landing')->select('filename')->where('id', $id)->get()->getRow();

        if ($landing) {
            // Hapus landing lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/landing/original/' . $landing->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/landing/thumbnail/' . $landing->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }

        // Hapus entri landing dari database
        $deleted = $db->table('landing')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data landing berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data landing. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
