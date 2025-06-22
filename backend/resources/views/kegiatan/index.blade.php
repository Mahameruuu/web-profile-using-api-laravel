@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kegiatan</h2>
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary mb-3">+ Tambah Kegiatan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $index => $kegiatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kegiatan->judul }}</td>
                <td>{{ $kegiatan->deskripsi }}</td>
                <td>
                    @if($kegiatan->gambar)
                    <img src="{{ asset('storage/kegiatan/' . $kegiatan->gambar) }}" width="80" alt="Gambar">
                    @endif
                </td>
                <td>
                    <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection