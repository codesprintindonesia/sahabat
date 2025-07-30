<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {

        if (session()->get('is_login')) {
            return redirect()->to('Master/Carousel');
        }

        $data = [
            'title' => 'Login - Sahabat Agro',
        ];

        // Mengirim data kategori ke view
        return view('login', $data);
    }

    public function ubah_password()
    {

        if (!session()->get('is_login')) {
            return redirect()->to('Auth');
        }

        $data = [
            'title' => 'Ubah Password',
        ];

        // Mengirim data kategori ke view
        return view('ubah_password', $data);
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        $validationRules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            // Jika validasi gagal, kembalikan pesan error
            $response = [
                'code' => 400,
                'message' => array_values($this->validator->getErrors())[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Lakukan otentikasi pengguna berdasarkan username dan password
        // Misalnya, Anda bisa menggunakan model atau Query Builder untuk memeriksa data di database
        $pengguna = $this->db->table('pengguna')
            ->where('username', $username)
            ->where('is_active', 1)
            ->get()
            ->getRowArray();

        if ($pengguna && is_string($password) && password_verify($password, $pengguna['password'])) {            // Otentikasi berhasil

            // Otentikasi berhasil
            $data = [
                'is_login' => true, 
                'role' => $pengguna['role'],
                'id_pengguna' => $pengguna['id'],
                'username' => $pengguna['username'],
                'nama' => $pengguna['nama'] // Gantilah dengan nama kolom yang sesuai di tabel pengguna
            ];

            // Buat session
            session()->set($data);

            $response = [
                'code' => 200,
                'message' => 'Login berhasil',
                'data' => [
                    'user_id' => $pengguna['id'],
                    'username' => $pengguna['username'],
                    // ... tambahkan data pengguna lainnya yang ingin Anda kirimkan
                ]
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Otentikasi gagal
            $response = [
                'code' => 401,
                'message' => 'Username atau password salah',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(401);
        }
    }

    public function ubah_password_proses()
    {

        if (!session()->get('is_login')) {
            return redirect()->to('Auth');
        } 

        $userId = session()->get('id_pengguna');
        $oldPassword = $this->request->getPost('password_lama');
        $newPassword = $this->request->getPost('password_baru');
        $confirmNewPassword = $this->request->getPost('konfirmasi_password_baru');

        if ($newPassword !== $confirmNewPassword) {
            $response = [
                'code' => 400,
                'message' => 'Password baru dan konfirmasi password tidak cocok',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Validasi input
        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]'
        ];

        $errors = [
            'password_baru' => [
                'regex_match' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus (@$!%*?&)'
            ]
        ];

        if (!$this->validate($rules, $errors)) {
            // Jika validasi gagal, kembalikan pesan error
            $response = [
                'code' => 400,
                'message' => array_values($this->validator->getErrors())[0],
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }

        // Validasi password lama
        $pengguna = $this->db->table('pengguna')
            ->where('id', $userId)
            ->get()
            ->getRowArray(); 

        if (is_string($newPassword) && is_string($oldPassword) && $pengguna && password_verify($oldPassword, $pengguna['password'])) {
            // Password lama cocok, lanjutkan dengan pembaruan password baru
            $data = [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ];

            $this->db->table('pengguna')->where('id', $userId)->update($data);
            $response = [
                'code' => 200,
                'message' => 'Password berhasil diubah',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            // Password lama tidak cocok
            $response = [
                'code' => 400,
                'message' => 'Password lama salah',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }
    }

    public function logout()
    {
        // Hancurkan session yang telah diset saat login
        session()->destroy();

        // Redirect ke halaman login atau halaman lain yang sesuai
        return redirect()->to('Auth');
    }
}
