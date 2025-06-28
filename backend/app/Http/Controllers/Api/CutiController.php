<?php

namespace App\Http\Controllers\Api;

use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CutiController extends Controller
{
    public function index()
    {
        return Cuti::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        try {
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

            $data = $request->all();
            $data['jumlah_hari'] = now()->parse($data['tanggal_akhir'])
                                        ->diffInDays(now()->parse($data['tanggal_mulai'])) + 1;
            $data['tanggal_pengajuan'] = now();

            $cuti = Cuti::create($data);

            // Generate nama file
            $fileName = Str::random(40) . '.pdf';
            while (Storage::exists("public/surat_cuti/{$fileName}")) {
                $fileName = Str::random(40) . '.pdf';
            }

            try {
                $pdf = Pdf::loadView('pdf.surat_cuti', compact('cuti'))->setPaper('A4');
                Storage::disk('public')->put("surat_cuti/{$fileName}", $pdf->output());
                $cuti->update(['file_pdf' => $fileName]);
            } catch (\Exception $pdfError) {
                Log::error('Gagal membuat PDF surat cuti: ' . $pdfError->getMessage());
            }

            return response()->json($cuti, 201);

        } catch (\Exception $e) {
            Log::error('Gagal simpan cuti: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data cuti.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return Cuti::findOrFail($id);
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

        $data = $request->all();
        $data['jumlah_hari'] = now()->parse($data['tanggal_akhir'])
                                    ->diffInDays(now()->parse($data['tanggal_mulai'])) + 1;

        $cuti->update($data);

        return response()->json($cuti);
    }

    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);

        if ($cuti->file_pdf && Storage::exists('public/surat_cuti/' . $cuti->file_pdf)) {
            Storage::delete('public/surat_cuti/' . $cuti->file_pdf);
        }

        $cuti->delete();

        return response()->json(['message' => 'Cuti berhasil dihapus']);
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
            $fileName = Str::random(40) . '.pdf';
            $pdf = Pdf::loadView('pdf.surat_cuti', compact('cuti'))->setPaper('A4');
            Storage::put("public/surat_cuti/{$fileName}", $pdf->output());

            // Hapus file lama jika ada
            if ($cuti->file_pdf && Storage::exists('public/surat_cuti/' . $cuti->file_pdf)) {
                Storage::delete('public/surat_cuti/' . $cuti->file_pdf);
            }

            $cuti->update(['file_pdf' => $fileName]);

            return response()->json(['message' => 'PDF berhasil diperbarui', 'file' => $fileName]);

        } catch (\Exception $e) {
            Log::error('Gagal regenerasi PDF: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal membuat ulang PDF'], 500);
        }
    }
}
