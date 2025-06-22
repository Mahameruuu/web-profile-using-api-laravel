<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        Kegiatan::create([
            'judul' => 'Workshop Laravel',
            'deskripsi' => 'Pelatihan Laravel untuk pemula',
            'gambar' => 'laravel.png'
        ]);
    }
}
