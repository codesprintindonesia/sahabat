<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function gambar($id)
    {
        $db = \Config\Database::connect();

        $kategori = $db->table('kategori')->get()->getResult();
        $item = $db->table('item')->get()->getResult();
        $gambar = $db->table('gambar')->select('gambar.id, gambar.filename, gambar.judul,gambar.deskripsi,gambar.views_count,gambar.updated_at, kategori.nama as nama_kategori, item.nama as nama_item, item.id as item_id')
            ->join('item', 'item.id = gambar.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('gambar.id', $id)->get()->getRow();

        if (empty($gambar)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gambar tidak ditemukan');
        }

        // Update views count
        $db->table('gambar')->where('id', $gambar->id)->update(['views_count' => $gambar->views_count + 1]);

        $data = [
            'title' =>  'Blog - Sahabat Agro',
            'list_kategori' => $kategori,
            'list_item' => $item,
            'gambar' => $gambar
        ];


        // Mengirim data gambar ke view
        return view('blog/gambar', $data);
    }

    public function video_lokal($id)
    {
        $db = \Config\Database::connect();

        $kategori = $db->table('kategori')->get()->getResult();
        $item = $db->table('item')->get()->getResult();
        $videolokal = $db->table('videolokal')->select('videolokal.id, videolokal.filename, videolokal.judul,videolokal.deskripsi,videolokal.views_count,videolokal.updated_at, kategori.nama as nama_kategori, item.nama as nama_item, item.id as item_id')
            ->join('item', 'item.id = videolokal.item_id', 'left')
            ->join('kategori', 'kategori.id = item.kategori_id', 'left')
            ->where('videolokal.id', $id)->get()->getRow();

        if (empty($videolokal)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Video tidak ditemukan');
        }

        // Update views count
        $db->table('videolokal')->where('id', $videolokal->id)->update(['views_count' => $videolokal->views_count + 1]);

        $data = [
            'title' =>  'Blog',
            'list_kategori' => $kategori,
            'list_item' => $item,
            'videolokal' => $videolokal
        ];

        // Mengirim data videolokal ke view
        return view('blog/video_lokal', $data);
    }
}
