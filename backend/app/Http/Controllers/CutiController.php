<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $cutis = Cuti::orderBy('created_at', 'desc')->get();
        return view('cuti.index', compact('cutis'));
    }

    public function create()
    {
        return view('cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|string|unique:cutis,nip',
            'pangkat' => 'required|string',
            'jabatan' => 'required|string',
            'departemen' => 'required|string',
            'sub_departemen' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'alamat' => 'nullable|string|max:255',
        ]);

        try {
            $data = $request->all();
            $tanggalMulai = Carbon::parse($data['tanggal_mulai']);
            $tanggalAkhir = Carbon::parse($data['tanggal_akhir']);

            $data['jumlah_hari'] = $tanggalMulai->diffInDays($tanggalAkhir) + 1;
            $data['tanggal_pengajuan'] = now();

            $cuti = Cuti::create($data);

            // Buat file PDF
            $fileName = Str::uuid() . '.pdf';
            $pdf = Pdf::loadView('pdf.surat_cuti', compact('cuti'))->setPaper('A4');

            Storage::disk('public')->put("surat_cuti/{$fileName}", $pdf->output());

            $cuti->update(['file_pdf' => $fileName]);

            return redirect()->route('cuti.index')->with('success', 'Data cuti berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data cuti: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data cuti.');
        }
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('cuti.show', compact('cuti'));
    }

    public function edit($id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('cuti.edit', compact('cuti'));
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|string|unique:cutis,nip,' . $cuti->id,
            'pangkat' => 'required|string',
            'jabatan' => 'required|string',
            'departemen' => 'required|string',
            'sub_departemen' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'alamat' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:Tunggu Konfirmasi,Disetujui,Ditolak,Dibatalkan',
        ]);

        try {
            $data = $request->all();
            $tanggalMulai = Carbon::parse($data['tanggal_mulai']);
            $tanggalAkhir = Carbon::parse($data['tanggal_akhir']);

            $data['jumlah_hari'] = $tanggalMulai->diffInDays($tanggalAkhir) + 1;

            $cuti->update($data);

            return redirect()->route('cuti.index')->with('success', 'Data cuti berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal update cuti: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data.');
        }
    }

    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);

        try {
            if ($cuti->file_pdf && Storage::disk('public')->exists('surat_cuti/' . $cuti->file_pdf)) {
                Storage::disk('public')->delete('surat_cuti/' . $cuti->file_pdf);
            }

            $cuti->delete();

            return redirect()->route('cuti.index')->with('success', 'Data cuti berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal hapus cuti: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data cuti.');
        }
    }

    public function downloadPdf($id)
    {
        $cuti = Cuti::findOrFail($id);
        $pdf = Pdf::loadView('pdf.surat_cuti', compact('cuti'))->setPaper('A4');
        return $pdf->download('surat_cuti_' . $cuti->nip . '.pdf');
    }

    public function regeneratePdf($id)
    {
        $cuti = Cuti::findOrFail($id);

        try {
            $fileName = Str::uuid() . '.pdf';
            $pdf = Pdf::loadView('pdf.surat_cuti', compact('cuti'))->setPaper('A4');
            Storage::disk('public')->put("surat_cuti/{$fileName}", $pdf->output());

            if ($cuti->file_pdf && Storage::disk('public')->exists('surat_cuti/' . $cuti->file_pdf)) {
                Storage::disk('public')->delete('surat_cuti/' . $cuti->file_pdf);
            }

            $cuti->update(['file_pdf' => $fileName]);

            return redirect()->back()->with('success', 'PDF berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal regenerasi PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat ulang PDF.');
        }
    }
}
