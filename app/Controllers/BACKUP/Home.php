<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        helper('youtube_embed');

        $db = \Config\Database::connect();

        $carousel = $db->table('carousel')->get();
        $tentang = $db->table('tentang')->get();
        $kategori = $db->table('kategori')->get();
        $item = $db->table('item')->get();
        $gambar = $db->table('gambar')->orderBy('RAND()')->limit(8)->get();
        $videoyoutube = $db->table('videoyoutube')->select('videoyoutube.*, item.nama as nama_item')->join('item', 'videoyoutube.item_id = item.id', 'left')->orderBy('videoyoutube.id', 'desc')->limit(3)->get()->getResult();

        /*create embed video youtube for each data */
        foreach ($videoyoutube as $video) {
            // create embed video URL
            $embedUrl = youtube_embed($video->link);
            $youtube_id = get_youtube_video_id($video->link);
            $video->preview = $embedUrl;
            $video->youtube_id = $youtube_id;
        }

        $data = [
            'title' => 'Sahabat Agro',
            'list_carousel' => $carousel->getResult(),
            'list_tentang' => $tentang->getResult(),
            'list_kategori' => $kategori->getResult(),
            'list_item' => $item->getResult(),
            'list_gambar' => $gambar->getResult(),
            'list_videoyoutube' => $videoyoutube
        ];

        // Mengirim data kategori ke view
        return view('welcome_message', $data);
    }
}
