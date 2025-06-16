<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Request;

class KegiatanApiController extends Controller
{
    public function index()
    {
        return response()->json(Kegiatan::all());
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable'
        ]);

        $kegiatan = Kegiatan::create($data);

        return response()->json($kegiatan, 201);
    }

}
