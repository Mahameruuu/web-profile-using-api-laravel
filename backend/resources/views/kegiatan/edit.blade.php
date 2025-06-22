@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Kegiatan</h2>
    <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $kegiatan->judul }}" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required>{{ $kegiatan->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Baru</label>
            <input type="file" name="gambar" class="form-control">
            @if($kegiatan->gambar)
            <div class="mt-2">
                <img src="{{ asset('storage/kegiatan/' . $kegiatan->gambar) }}" width="100">
            </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
