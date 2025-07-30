<?php

namespace App\Controllers;

class Kontak extends BaseController
{

    public function index()
    {

        $db = \Config\Database::connect();
        $kategori = $db->table('kategori')->get();
        $item = $db->table('item')->get();
        $data = [
            'title' => 'Kontak - Sahabat Agro',
            'list_kategori' => $kategori->getResult(),
            'list_item' => $item->getResult(),
        ];
        return view('kontak', $data);
    }
    public function kirim_email()
    {
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $subjek = $this->request->getPost('subjek');
        $pesan = $this->request->getPost('pesan'); 

        // Ambil konfigurasi SMTP dari database
        $db = \Config\Database::connect(); // Mengambil instance dari Database
        $query = $db->table('gmailsmtp')->select('smtp_user, smtp_pass')->where('id', 1)->get();
        $smtpConfig = $query->getRow();

        if (!$smtpConfig) {
            // Handle jika konfigurasi tidak ditemukan
            $response = [
                'code' => 500,
                'message' => 'Konfigurasi SMTP tidak ditemukan.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }

        // Validasi data (sesuaikan dengan kebutuhan Anda)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|max_length[255]|alpha_numeric_space',
            'email' => 'required|valid_email|max_length[255]',
            'subjek' => 'required|max_length[255]|alpha_numeric_space',
            'pesan' => 'required|max_length[500]|alpha_numeric_space'
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

        // Proses pengiriman email menggunakan Gmail SMTP
        $emailConfig = \Config\Services::email();

        // Konfigurasi email
        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => $smtpConfig->smtp_user,
            'SMTPPass' => $smtpConfig->smtp_pass,
            'SMTPPort' => 587,
            'mailType' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'validate' => true,
            'SMTPCrypto' => 'tls',
        ];

        $emailConfig->initialize($config);
        $emailConfig->setTo($smtpConfig->smtp_user); // Alamat email penerima
        $emailConfig->setFrom($email, "SahabatAgro");
        $emailConfig->setSubject($subjek);

        // Set konten email menggunakan template HTML
        $emailTemplate = view('email_template', [
            'nama' => $nama,
            'email' => $email,
            'pesan' => $pesan,
        ]);

        $emailConfig->setMessage($emailTemplate);

        if ($emailConfig->send()) {
            $response = [
                'code' => 200,
                'message' => 'Email berhasil dikirim.',
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(200);
        } else {
            $error = $emailConfig->printDebugger(['headers']);
            $response = [
                'code' => 500,
                'message' => 'Gagal mengirim email. Silakan coba lagi nanti. ' . $error,
                'data' => null
            ];
            return $this->response->setJSON($response)->setStatusCode(500);
        }
    }
}
