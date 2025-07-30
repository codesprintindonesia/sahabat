<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class Carousel extends BaseController
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
            'title' => 'Carousel',
        ];

        // Mengirim data kategori ke view
        return view('master/carousel/index', $data);
    }
    public function find_all()
    {
        $db = \Config\Database::connect();

        $query = $db->table('carousel')->get();

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

        // Melakukan JOIN antara tabel carousel, kategori, dan item berdasarkan id kategori dan id item pada carousel
        $query = $db->table('carousel')
            ->select('carousel.*')
            ->where('carousel.id', $id)
            ->get();

        $carousel = $query->getRow();

        if ($carousel) {
            $response = [
                'code' => 200,
                'message' => 'Data ditemukan.',
                'data' => $carousel
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
            'carousel' => 'uploaded[carousel]|max_size[carousel,10024]|is_image[carousel]'
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

        // Proses upload carousel
        $carousel = $this->request->getFile('carousel');

        // Simpan carousel asli
        $carouselOriginalName = $carousel->getRandomName();
        $carousel->move(ROOTPATH . 'public/uploads/carousel/original', $carouselOriginalName);

        // Kompresi dan simpan thumbnail
        $image = \Config\Services::image()
            ->withFile(ROOTPATH . 'public/uploads/carousel/original/' . $carouselOriginalName)
            ->resize(200, 200, true)
            ->save(ROOTPATH . 'public/uploads/carousel/thumbnail/' . $carouselOriginalName);

        // Simpan data carousel ke database
        $db = \Config\Database::connect();
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'filename' => $carouselOriginalName // Simpan nama file asli ke database
        ];

        $query = $db->table('carousel')->insert($data);

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
        $newCarousel = $this->request->getFile('carousel');

        $validation_rules = [
            'id' => 'required|integer',
            'judul' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty'
        ];

        // Cek apakah ada carousel yang diunggah
        if ($newCarousel) {
            $validation_rules['carousel'] = 'uploaded[carousel]|max_size[carousel,10024]|is_image[carousel]';
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

        // Ambil data carousel yang akan diupdate
        $db = \Config\Database::connect();
        $carousel = $db->table('carousel')->where('id', $id)->get()->getRow();

        if (!$carousel) {
            $response = [
                'code' => 404,
                'message' => 'Data tidak ditemukan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(404);
        }

        // Periksa apakah ada carousel yang diunggah 
        if ($newCarousel) {
            // Hapus carousel lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/carousel/original/' . $carousel->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/carousel/thumbnail/' . $carousel->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }

            // Simpan carousel baru
            $carouselOriginalName = $newCarousel->getRandomName();
            $newCarousel->move(ROOTPATH . 'public/uploads/carousel/original', $carouselOriginalName);

            // Buat thumbnail dari carousel baru
            \Config\Services::image()
                ->withFile(ROOTPATH . 'public/uploads/carousel/original/' . $carouselOriginalName)
                ->resize(200, 200, true)
                ->save(ROOTPATH . 'public/uploads/carousel/thumbnail/' . $carouselOriginalName);

            // Update data carousel dengan carousel baru
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi,
                'filename' => $carouselOriginalName
            ];
        } else {
            // Jika tidak ada carousel yang diunggah, update data carousel tanpa mengubah carousel
            $data = [
                'judul' => $newJudul,
                'deskripsi' => $newDeskripsi
            ];
        }

        // Lakukan proses update data carousel di database
        $updateQuery = $db->table('carousel')->where('id', $id)->update($data);

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

        // Ambil nama file carousel sebelum menghapus dari database
        $carousel = $db->table('carousel')->select('filename')->where('id', $id)->get()->getRow();

        if ($carousel) {
            // Hapus carousel lama jika ada
            $originalFilePath = ROOTPATH . 'public/uploads/carousel/original/' . $carousel->filename;
            $thumbnailFilePath = ROOTPATH . 'public/uploads/carousel/thumbnail/' . $carousel->filename;

            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }

            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }

        // Hapus entri carousel dari database
        $deleted = $db->table('carousel')->where('id', $id)->delete();

        if ($deleted) {
            $response = [
                'code' => 200,
                'message' => 'Data carousel berhasil dihapus.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $response = [
                'code' => 500,
                'message' => 'Gagal menghapus data carousel. Silakan coba lagi.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
