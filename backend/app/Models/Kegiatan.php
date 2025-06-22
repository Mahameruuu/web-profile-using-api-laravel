<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kegiatan extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar'
    ];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? Storage::url('kegiatan/' . $this->gambar) : null;
    }
}
