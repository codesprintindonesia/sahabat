<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Ambil instance dari Database
        $db = \Config\Database::connect();

        // Hitung total pengunjung hari ini
        $todayVisitors = $db->table('visitor')
            ->select('COUNT(*) as total')
            ->where('DATE(visit_date)', date('Y-m-d'))
            ->get()
            ->getRowArray()['total'];

        // Hitung total counter hari ini
        $todayCounters = $db->table('visitor')
            ->selectSum('counter')
            ->where('DATE(visit_date)', date('Y-m-d'))
            ->get()
            ->getRowArray()['counter'];

        // Hitung total pengunjung
        $totalVisitors = $db->table('visitor')
            ->select('COUNT(*) as total')
            ->get()
            ->getRowArray()['total'];

        // Hitung total counter
        $totalCounter = $db->table('visitor')
            ->selectSum('counter')
            ->get()
            ->getRowArray()['counter'];

        // Ambil data untuk chart sevenDaysVisitors
        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
        $sevenDaysVisitors = $db->table('visitor')
            ->select('DATE(visit_date) as date, COUNT(*) as total')
            ->where('visit_date >=', $sevenDaysAgo)
            ->groupBy('DATE(visit_date)')
            ->get()
            ->getResultArray();

        // Ambil data untuk chart sevenDaysCounter
        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
        $sevenDaysCounter = $db->table('visitor')
            ->select('DATE(visit_date) as date, SUM(counter) as total_counter')
            ->where('visit_date >=', $sevenDaysAgo)
            ->groupBy('DATE(visit_date)')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard',
            'todayVisitors' => $todayVisitors,
            'todayCounters' => $todayCounters,
            'totalVisitors' => $totalVisitors,
            'totalCounter' => $totalCounter,
            'sevenDaysVisitors' => $sevenDaysVisitors,
            'sevenDaysCounter' => $sevenDaysCounter
        ];

        // Tampilkan halaman dashboard dengan data
        return view('admin/dashboard', $data);
    }
}
