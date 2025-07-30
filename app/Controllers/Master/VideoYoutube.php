<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class videoyoutube extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('is_login')) {
            header('Location: ' . base_url('Auth'));
            exit();
        }
        helper('youtube_embed');
    } 
    public function index()
    {
        $data = [
            'title' => 'Video Youtube',
        ];

        // Mengirim data video youtube ke view
        return view('master/video_youtube/index', $data);
    }

    public function find_all()
    {
        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk mengambil semua data dari tabel videoyoutube
        $query = $db->table('videoyoutube')
            ->select('videoyoutube.id, videoyoutube.judul, videoyoutube.deskripsi, videoyoutube.link, item.nama as item_nama')
            ->join('item', 'item.id = videoyoutube.item_id', 'left')
            ->get();

        // Cek apakah ada data yang ditemukan
        if ($query->getResult()) {

            $dataVideo = $query->getResult();
            /*create embed video youtube for each data */
            foreach ($dataVideo as $video) {
                // create embed video URL
                $embedUrl = youtube_embed($video->link);
                $youtube_id = get_youtube_video_id($video->link);
                $video->preview = $embedUrl;
                $video->youtube_id = $youtube_id;
            }

            // Jika ada data, kirim data sebagai respons JSON dengan kode status 200 OK
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $dataVideo
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

        // Melakukan JOIN antara tabel video, kategori, dan item berdasarkan id kategori dan id item pada video
        $query = $db->table('videoyoutube')
            ->select('videoyoutube.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = videoyoutube.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('videoyoutube.id', $id)
            ->get();

        $gambar = $query->getRow();

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
        $item_id = $this->request->getPost('item_id');
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $link = $this->request->getPost('link');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'item_id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'link' => 'required|valid_url'
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

        // Mengambil instance koneksi database
        $db = \Config\Database::connect();

        // Melakukan query untuk menyimpan data ke tabel videoyoutube
        $data = [
            'item_id' => $item_id,
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'link' => $link
        ];

        $query = $db->table('videoyoutube')->insert($data);

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
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $link = $this->request->getPost('link');

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'link' => 'required|valid_url'
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

        // Mengupdate data video youtube ke database
        $db = \Config\Database::connect();
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'link' => $link
        ];

        $affectedRows = $db->table('videoyoutube')->where('id', $id)->update($data);

        if ($affectedRows > 0) {
            $response = [
                'code' => 200,
                'message' => 'Data video youtube berhasil diperbarui.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal mengupdate data video youtube. Silakan coba lagi.',
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

        // Menghapus data video youtube dari database
        $db = \Config\Database::connect();
        $deleted = $db->table('videoyoutube')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data video youtube berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data video youtube. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }

    private function embedYouTubeVideo($url)
    {
        // Temukan ID video dari URL YouTube
        $videoId = '';
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
            if (isset($query['v'])) {
                $videoId = $query['v'];
            }
        }

        // Jika ID video ditemukan, susun URL embed
        if (!empty($videoId)) {
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
            return $embedUrl;
        } else {
            // Jika ID video tidak ditemukan, kembalikan URL asli
            return $url;
        }
    }
}
