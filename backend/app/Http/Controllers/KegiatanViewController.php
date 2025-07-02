<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanViewController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = $file->hashName();
            $file->storeAs('kegiatan_local', $filename, 'local');
            $file->storeAs('kegiatan', $filename, 'public');
            $data['gambar'] = $filename;
        }

        Kegiatan::create($data);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan ditambahkan.');
    }

    public function edit($id)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $kegiatan = Kegiatan::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
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
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan diperbarui.');
    }

    public function destroy($id)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->gambar) {
            Storage::disk('local')->delete('kegiatan_local/' . $kegiatan->gambar);
            Storage::disk('public')->delete('kegiatan/' . $kegiatan->gambar);
        }

        $kegiatan->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan dihapus.');
    }
}
