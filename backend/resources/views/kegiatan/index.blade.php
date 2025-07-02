@extends('layouts.main')

@section('title', 'Manajemen Kegiatan')

@section('content')
<div class="p-6 w-full">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Daftar Kegiatan</h2>
    <form action="{{ route('kegiatan.create') }}" method="GET" class="inline">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
        + Tambah
    </button>
    </form>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-600 font-semibold">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-auto bg-white rounded-lg shadow">
    <table class="w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left w-[50px]">No</th>
          <th class="px-4 py-3 text-left w-[180px]">Judul</th>
          <th class="px-4 py-3 text-left w-[300px]">Deskripsi</th>
          <th class="px-4 py-3 text-left w-[120px]">Gambar</th>
          <th class="px-4 py-3 text-left w-[150px]">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($kegiatans as $index => $item)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">{{ $index + 1 }}</td>
            <td class="px-4 py-3">{{ $item->judul }}</td>
            <td class="px-4 py-3">{{ $item->deskripsi }}</td>
            <td class="px-4 py-3">
              @if($item->gambar)
                <img src="{{ asset('storage/kegiatan/' . $item->gambar) }}"
                     alt="{{ $item->judul }}"
                     class="w-16 h-16 object-cover rounded border"
                     onerror="this.onerror=null;this.src='/no-image.png';">
              @else
                <span class="text-gray-500 italic text-xs">Tidak ada gambar</span>
              @endif
            </td>
            <td class="px-4 py-3 flex gap-2">
              <a href="{{ route('kegiatan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form method="POST" action="{{ route('kegiatan.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data kegiatan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
