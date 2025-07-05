@extends('layouts.main')

@section('title', 'Tambah Surat Cuti')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
  <div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Surat Cuti</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
        <ul class="list-disc pl-4">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @php
      $cuti = new \App\Models\Cuti;
    @endphp

    <form action="{{ route('cuti.store') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label class="block mb-1 font-medium text-gray-700">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $cuti->nama) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $cuti->nip) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Pangkat / Golongan</label>
        <input type="text" name="pangkat" value="{{ old('pangkat', $cuti->pangkat) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $cuti->jabatan) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Departemen</label>
        <input type="text" name="departemen" value="{{ old('departemen', $cuti->departemen) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Sub Departemen</label>
        <input type="text" name="sub_departemen" value="{{ old('sub_departemen', $cuti->sub_departemen) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir', $cuti->tanggal_akhir) }}"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Alamat Selama Cuti</label>
        <textarea name="alamat" rows="2"
          class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $cuti->alamat) }}</textarea>
      </div>

      <div class="mt-6">
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('cuti.index') }}" class="btn btn-primary ml-2">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
