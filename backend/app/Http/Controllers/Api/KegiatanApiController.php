<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanApiController extends Controller
{
    public function index()
    {
        return response()->json(Kegiatan::all());
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = $file->hashName(); // nama file unik

            // Simpan ke storage lokal dan publik
            $file->storeAs('kegiatan_local', $filename, 'local');
            $file->storeAs('kegiatan', $filename, 'public');

            $data['gambar'] = $filename;
        }

        $kegiatan = Kegiatan::create($data);
        return response()->json($kegiatan, 201);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $kegiatan = Kegiatan::findOrFail($id);

        $data = $request->validate([
            'judul' => 'sometimes|required',
            'deskripsi' => 'sometimes|required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($kegiatan->gambar) {
                Storage::disk('local')->delete('kegiatan_local/' . $kegiatan->gambar);
                Storage::disk('public')->delete('kegiatan/' . $kegiatan->gambar);
            }

            $file = $request->file('gambar');
            $filename = $file->hashName();

            $file->storeAs('kegiatan_local', $filename, 'local');
            $file->storeAs('kegiatan', $filename, 'public');

            $data['gambar'] = $filename;
        }

        $kegiatan->update($data);
        return response()->json($kegiatan);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->gambar) {
            Storage::disk('local')->delete('kegiatan_local/' . $kegiatan->gambar);
            Storage::disk('public')->delete('kegiatan/' . $kegiatan->gambar);
        }

        $kegiatan->delete();
        return response()->json(['message' => 'Kegiatan berhasil dihapus.']);
    }
}
