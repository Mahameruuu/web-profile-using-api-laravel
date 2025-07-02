<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'pangkat',
        'jabatan',
        'departemen',
        'sub_departemen',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_akhir',
        'jumlah_hari',
        'alamat',
        'status',
        'file_pdf',
    ];

    // opsional atau cara ke 2
    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];
}
