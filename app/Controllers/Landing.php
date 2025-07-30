<?php

namespace App\Controllers;

class Landing extends BaseController
{
    public function index()
    {

        $db = \Config\Database::connect();
        $landing = $db->table('landing')->get();  
        $kategori = $db->table('kategori')->get();
        $item = $db->table('item')->get();   

        $data = [
            'title' => 'Sahabat Agro', 
            'list_kategori' => $kategori->getResult(),
            'list_item' => $item->getResult(), 
            'list_landing' => $landing->getResult(),
        ]; 

        // Mengirim data kategori ke view
        return view('landing_page', $data);
    }
}
