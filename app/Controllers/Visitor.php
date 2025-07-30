<?php

namespace App\Controllers;

class Visitor extends BaseController
{
    public function logVisitor()
    {
        // Logika penambahan counter (letakkan di tempat yang sesuai)
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        // Ambil instance dari Database
        $db = \Config\Database::connect();

        $existingVisitor = $db->table('visitor')
            ->where('ip_address', $ipAddress)
            ->get()
            ->getRowArray();

        if ($existingVisitor) {
            // Jika pengunjung sudah ada, update counter
            $db->table('visitor')
                ->where('ip_address', $ipAddress)
                ->set('counter', $existingVisitor['counter'] + 1)
                ->update();
        } else {
            // Jika pengunjung belum ada, tambahkan entri baru
            $db->table('visitor')
                ->insert([
                    'ip_address' => $ipAddress,
                    'visit_date' => date('Y-m-d H:i:s'),
                    'counter' => 1
                ]);
        }
    }
}
