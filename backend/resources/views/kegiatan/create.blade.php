@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Kegiatan</h2>
    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection