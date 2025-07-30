<?php

namespace App\Controllers;

class Pustaka extends BaseController
{
    public function gambar($itemId = 1)
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 20; // Jumlah gambar per halaman
        $start = ($page - 1) * $perPage;
        /* select data from carosel find_all() */

        $db = \Config\Database::connect();

        $carousel = $db->table('carousel')->get();
        $tentang = $db->table('tentang')->get();
        $kategori = $db->table('kategori')->get();
        $item = $db->table('item')->get();
        $itemName = $db->table('item')->select('item.nama,item.filename,item.id, kategori.nama as kategori')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('item.id', $itemId)->get();

        if (empty($itemName->getRow())) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gambar tidak ditemukan');
        }

        $data = [
            'title' =>  $itemName->getRow(),
            'list_carousel' => $carousel->getResult(),
            'list_tentang' => $tentang->getResult(),
            'list_kategori' => $kategori->getResult(),
            'list_item' => $item->getResult(),
        ]; 

        // Query untuk mengambil data gambar menggunakan pagination
        $query = $db->table('gambar')
            ->select('gambar.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = gambar.item_id')
            ->join('kategori', 'kategori.id = item.kategori_id') // Menambahkan kondisi WHERE untuk memfilter item berdasarkan ID tertentu
            ->limit($perPage, $start)
            ->where('item.id', $itemId);

        $gambar = $query->get()->getResult();

        // Menghitung jumlah total data gambar
        $totalRows = $db->table('gambar')
            ->select('COUNT(*) as total_rows')
            ->join('item', 'item.id = gambar.item_id')
            ->join('kategori', 'kategori.id = item.kategori_id')
            ->where('item.id', $itemId)->get()->getRow()->total_rows; 
 
        $pager = \Config\Services::pager(null, null, true);

        $data['list_gambar'] = $gambar;
        $data['pager'] = $pager->makeLinks($page, $perPage, $totalRows, 'bootstrap_template');

        // Mengirim data gambar ke view
        return view('pustaka/gambar', $data);
    }

    public function video($itemId = 1)
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 12; // Jumlah videolokal per halaman
        $start = ($page - 1) * $perPage;
        /* select data from carosel find_all() */

        $db = \Config\Database::connect();

        $carousel = $db->table('carousel')->get();
        $tentang = $db->table('tentang')->get();
        $kategori = $db->table('kategori')->get();
        $item = $db->table('item')->get();
        $itemName = $db->table('item')->select('item.nama,item.filename,item.id, kategori.nama as kategori')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('item.id', $itemId)->get();

        if (empty($itemName->getRow())) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Video tidak ditemukan');
        }

        $data = [
            'title' =>  $itemName->getRow(),
            'list_carousel' => $carousel->getResult(),
            'list_tentang' => $tentang->getResult(),
            'list_kategori' => $kategori->getResult(),
            'list_item' => $item->getResult(),
        ];


        // Query untuk mengambil data videolokal menggunakan pagination
        $query = $db->table('videolokal')
            ->select('videolokal.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = videolokal.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left') // Menambahkan kondisi WHERE untuk memfilter item berdasarkan ID tertentu
            ->limit($perPage, $start)
            ->where('item.id', $itemId);

        $videolokal = $query->get()->getResult();

        // Menghitung jumlah total data videolokal
        $totalRows = $db->table('videolokal')
            ->select('COUNT(*) as total_rows')
            ->join('item', 'item.id = videolokal.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('item.id', $itemId)->get()->getRow()->total_rows;
 
        $pager = \Config\Services::pager(null, null, true);

        $data['list_videolokal'] = $videolokal;
        $data['pager'] = $pager->makeLinks($page, $perPage, $totalRows, 'bootstrap_template');

        // Mengirim data videolokal ke view
        return view('pustaka/video_lokal', $data);
    }


    public function youtube($itemId = 1)
    {

        helper('youtube_embed');
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10; // Jumlah videoyoutube per halaman
        $start = ($page - 1) * $perPage;
        /* select data from carosel find_all() */

        $db = \Config\Database::connect();

        $carousel = $db->table('carousel')->get();
        $tentang = $db->table('tentang')->get();
        $kategori = $db->table('kategori')->get();
        $item = $db->table('item')->get();
        $itemName = $db->table('item')->select('item.nama,item.filename,item.id, kategori.nama as kategori')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('item.id', $itemId)->get();

        if (empty($itemName->getRow())) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Video tidak ditemukan');
        }

        $data = [
            'title' =>  $itemName->getRow(),
            'list_carousel' => $carousel->getResult(),
            'list_tentang' => $tentang->getResult(),
            'list_kategori' => $kategori->getResult(),
            'list_item' => $item->getResult(),
        ];


        // Query untuk mengambil data videoyoutube menggunakan pagination
        $query = $db->table('videoyoutube')
            ->select('videoyoutube.*, kategori.nama as kategori_nama, kategori.id as kategori_id, item.nama as item_nama, item.id as item_id')
            ->join('item', 'item.id = videoyoutube.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left') // Menambahkan kondisi WHERE untuk memfilter item berdasarkan ID tertentu
            ->limit($perPage, $start)
            ->where('item.id', $itemId);

        $videoyoutube = $query->get()->getResult();

        /*create embed video youtube for each data */
        foreach ($videoyoutube as $video) {
            // create embed video URL
            $embedUrl = youtube_embed($video->link);
            $youtube_id = get_youtube_video_id($video->link);
            $video->preview = $embedUrl;
            $video->youtube_id = $youtube_id;
        } 

        // Menghitung jumlah total data videolokal
        $totalRows = $db->table('videoyoutube')
            ->select('COUNT(*) as total_rows')
            ->join('item', 'item.id = videoyoutube.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('item.id', $itemId)->get()->getRow()->total_rows;

        $pager = \Config\Services::pager(null, null, true);

        $data['list_videoyoutube'] = $videoyoutube;
        $data['pager'] = $pager->makeLinks($page, $perPage, $totalRows, 'bootstrap_template');

        // Mengirim data videoyoutube ke view
        return view('pustaka/video_youtube', $data);
    }
}
