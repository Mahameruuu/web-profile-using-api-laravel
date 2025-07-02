@extends('layouts.main')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
  <div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Kegiatan</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
        <ul class="list-disc pl-4">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <div>
        <label class="block mb-1 font-medium text-gray-700">Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}"
               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
                  class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('deskripsi') }}</textarea>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Gambar</label>
        <input type="file" name="gambar"
               class="w-full border px-3 py-2 rounded file:bg-gray-100 file:border-none file:px-3 file:py-1" accept="image/*">
      </div>

      <div class="mt-6">
        <button type="submit" class="btn btn-success">Simpan</button>
        <button type="button" onclick="location.href='{{ route('kegiatan.index') }}';" class="btn btn-primary ml-2">Kembali</button>
      </div>
    </form>
  </div>
</div>
@endsection
