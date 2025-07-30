<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Tentang extends BaseController
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
            'title' => 'Tentang',
        ];

        // Mengirim data kategori ke view
        return view('master/tentang/index', $data);
    }
    public function find_all()
    {
        $db = \Config\Database::connect();

        $query = $db->table('tentang')->get();

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

        // Melakukan JOIN antara tabel tentang, kategori, dan item berdasarkan id kategori dan id item pada tentang
        $query = $db->table('tentang')
            ->select('tentang.*') 
            ->where('tentang.id', $id)
            ->get();

        $tentang = $query->getRow();

        if ($tentang) {
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $tentang
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
            'tentang' => 'uploaded[tentang]|max_size[tentang,10024]|is_image[tentang]'
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

        // Proses upload tentang
        $tentang = $this->request->getFile('tentang');

        // Simpan tentang asli
        $tentangOriginalName = $tentang->getRandomName();
        $tentang->move(ROOTPATH . 'public/uploads/tentang/original', $tentangOriginalName);

        // Kompresi dan simpan thumbnail
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . 'public/uploads/tentang/original/' . $tentangOriginalName)
            ->resize(200, 200, true)
            ->save(ROOTPATH . 'public/uploads/tentang/thumbnail/' . $tentangOriginalName);

        // Simpan data tentang ke database
        $db = \Config\Database::connect();
        $data = [ 
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'filename' => $tentangOriginalName // Simpan nama file asli ke database
        ];

        $query = $db->table('tentang')->insert($data);

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
        $newTentang = $this->request->getFile('tentang');

        $validation_rules = [
            'id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty'
        ];

        // Cek apakah ada tentang yang diunggah
        if ($newTentang) {
            $validation_rules['tentang'] = 'uploaded[tentang]|max_size[tentang,10024]|is_image[tentang]';
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

        // Ambil data tentang yang akan diupdate
        $db = \Config\Database::connect();
        $tentang = $db->table('tentang')->where('id', $id)->get()->getRow();

        if (!$tentang) {
            $response = [
                'code' => 404,
                'message' => 'Data tidak ditemukan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(404);
        }

        // Periksa apakah ada tentang yang diunggah 
        if ($newTentang) {
            // Hapus tentang lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/tentang/original/' . $tentang->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/tentang/thumbnail/' . $tentang->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }

            // Simpan tentang baru
            $tentangOriginalName = $newTentang->getRandomName();
            $newTentang->move(ROOTPATH . 'public/uploads/tentang/original', $tentangOriginalName);

            // Buat thumbnail dari tentang baru
            \Config\Services::image()
                ->withFile(ROOTPATH . 'public/uploads/tentang/original/' . $tentangOriginalName)
                ->resize(200, 200, true)
                ->save(ROOTPATH . 'public/uploads/tentang/thumbnail/' . $tentangOriginalName);

            // Update data tentang dengan tentang baru
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi,
                'filename' => $tentangOriginalName
            ];
        } else {
            // Jika tidak ada tentang yang diunggah, update data tentang tanpa mengubah tentang
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi
            ];
        }

        // Lakukan proses update data tentang di database
        $updateQuery = $db->table('tentang')->where('id', $id)->update($data);

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

        // Ambil nama file tentang sebelum menghapus dari database
        $tentang = $db->table('tentang')->select('filename')->where('id', $id)->get()->getRow();

        if ($tentang) {
            // Hapus tentang lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/tentang/original/' . $tentang->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/tentang/thumbnail/' . $tentang->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }

        // Hapus entri tentang dari database
        $deleted = $db->table('tentang')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data tentang berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data tentang. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
