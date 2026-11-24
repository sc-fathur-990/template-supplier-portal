<?php

namespace App\Http\Controllers;

/**
 * Controller untuk dummy menu "Example Menu" di sidebar.
 * Pola ini yang diikuti saat menambah menu baru:
 *  1. Buat controller + view
 *  2. Daftarkan route di routes/web.php (dalam group auth:pub_login)
 *  3. Insert baris di tabel sidemenu/submenu dengan role yang sesuai
 */
class ExampleMenuController extends Controller
{
    public function index()
    {
        return view('example-menu.index', ['title' => 'Example Menu - List']);
    }

    public function create()
    {
        return view('example-menu.index', ['title' => 'Example Menu - Create']);
    }
}
