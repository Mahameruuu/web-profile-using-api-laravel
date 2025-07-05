@extends('layouts.dashboard')

@section('title', 'Edit Surat Cuti')

@section('content')
<div class="max-w-4xl mx-auto p-6">
  <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Surat Cuti</h2>

  @if ($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('cuti.update', $cuti->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block font-medium">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $cuti->nama) }}" class="form-input w-full" required>
      </div>

      <div>
        <label class="block font-medium">NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $cuti->nip) }}" class="form-input w-full" required>
      </div>

      <div>
        <label class="block font-medium">Pangkat / Golongan</label>
        <input type="text" name="pangkat" value="{{ old('pangkat', $cuti->pangkat) }}" class="form-input w-full">
      </div>

      <div>
        <label class="block font-medium">Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $cuti->jabatan) }}" class="form-input w-full">
      </div>

      <div>
        <label class="block font-medium">Departemen</label>
        <input type="text" name="departemen" value="{{ old('departemen', $cuti->departemen) }}" class="form-input w-full">
      </div>

      <div>
        <label class="block font-medium">Sub Departemen</label>
        <input type="text" name="sub_departemen" value="{{ old('sub_departemen', $cuti->sub_departemen) }}" class="form-input w-full">
      </div>

      <div>
        <label class="block font-medium">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}" class="form-input w-full" required>
      </div>

      <div>
        <label class="block font-medium">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir', $cuti->tanggal_akhir) }}" class="form-input w-full" required>
      </div>

      <div class="md:col-span-2">
        <label class="block font-medium">Alamat Selama Cuti</label>
        <textarea name="alamat" class="form-textarea w-full" rows="2">{{ old('alamat', $cuti->alamat) }}</textarea>
      </div>
    </div>

    <div class="mt-4 flex gap-2">
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
