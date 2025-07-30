<?php
namespace App\Controllers\Master; 

use App\Controllers\BaseController;

class VideoLokal extends BaseController
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
            'title' => 'Video',
        ];

        // Mengirim data video ke view
        return view('master/video_lokal/index', $data);
    }

    public function find_all()
    {
        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil semua data dari tabel VideoLokal
        $query = $db->table('videolokal')
            ->select('videolokal.id, videolokal.judul, videolokal.deskripsi, videolokal.filename, item.nama as item_nama')
            ->join('item', 'item.id = videolokal.item_id', 'left')
            ->get();

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
            $errors = array_values($validation->getErrors())[0];
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Ambil data video dari database berdasarkan ID
        $db = \Config\Database::connect();
        $query = $db->table('videolokal')->select('id, judul, deskripsi, filename')->where('id', $id)->get();

        // Melakukan JOIN antara tabel videolokal, kategori, dan item berdasarkan id kategori dan id item pada videolokal
        $query = $db->table('videolokal')
            ->select('videolokal.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = videolokal.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('videolokal.id', $id)
            ->get();

        $videolokal = $query->getRow();

        if ($query->getRow()) {
            // Jika data ditemukan, kirim data sebagai respons JSON dengan kode status 200 OK
            $response = [
                'code' => 200,
                'message' => 'Data video ditemukan.',
                'data' => $videolokal
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Jika data tidak ditemukan, kirim respons kosong dengan kode status 404 Not Found
            return $this->response->setStatusCode(404);
        }
    }

    public function create()
    {
        // Ambil data dari request
        $item_id = $this->request->getPost('item_id');
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'item_id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'video' => 'uploaded[video]|max_size[video,51200]|ext_in[video,mp4,mov,avi,flv,wmv]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = array_values($validation->getErrors());
            $response = [
                'code' => 400,
                'message' => $errors[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Upload video video
        $video = $this->request->getFile('video');

        // Simpan gambar asli
        $newFilename = $video->getRandomName();
        $video->move(ROOTPATH . 'public/uploads/videos', $newFilename);

        // Simpan data ke database
        $db = \Config\Database::connect();
        $data = [
            'item_id' => $item_id,
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'filename' => $newFilename
        ];

        $query = $db->table('videolokal')->insert($data);

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
        // Ambil data dari request
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $newVideo = $this->request->getFile('video');

        $validation_rules = [
            'id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty'
        ];

        // Cek apakah ada gambar yang diunggah
        if ($newVideo) {
            $validation_rules['video'] = 'max_size[video,51200]|ext_in[video,mp4,mov,avi,flv,wmv]';
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
        $video = $db->table('videolokal')->where('id', $id)->get()->getRow();

        if (!$video) {
            $response = [
                'code' => 404,
                'message' => 'Data tidak ditemukan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(404);
        }

        // Periksa apakah ada video yang diunggah
        if ($newVideo) {
            // Hapus video lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/videos/' . $video->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            // Simpan video baru
            $videoOriginalName = $newVideo->getRandomName();
            $newVideo->move(ROOTPATH . 'public/uploads/videos', $videoOriginalName);

            // Update data gambar dengan gambar baru
            $data = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'filename' => $videoOriginalName
            ];
        } else {
            // Jika tidak ada video yang diunggah, update data video tanpa mengubah video
            $data = [
                'judul' => $judul,
                'deskripsi' => $deskripsi
            ];
        }

        // Lakukan proses update data video di database
        $updateQuery = $db->table('videolokal')->where('id', $id)->update($data);

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

        // Ambil nama file video
        $db = \Config\Database::connect();
        $filename = $db->table('videolokal')->select('filename')->where('id', $id)->get()->getRow()->filename;

        if ($filename) {
            // Hapus gambar lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/videos/' . $filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }
        }

        // Hapus data video dari database
        $deleted = $db->table('videolokal')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data video berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data video. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
