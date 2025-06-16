<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanViewController extends Controller
{
    public function index()
    {
        return view('kegiatan.index');
    }
}
