@extends('layouts.main')

@section('title', 'Import User')

@section('content')
<div class="p-6 max-w-xl mx-auto">
  <div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Import User dari Excel</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
      <div class="bg-green-100 text-green-800 border border-green-300 p-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @elseif(session('error'))
      <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    {{-- Form Import --}}
    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      {{-- Input File --}}
      <div>
        <label for="file" class="block mb-1 font-medium text-gray-700">Pilih File Excel (.xls, .xlsx)</label>
        <input type="file" name="file" id="file" accept=".xls,.xlsx"
               class="w-full border px-3 py-2 rounded file:bg-gray-100 file:border-none file:px-3 file:py-1"
               required>
        @error('file')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Tombol --}}
      <div class="pt-4">
        <button type="submit" class="btn btn-success">Upload</button>
        <a href="{{ route('users.index') }}" class="btn btn-primary ml-2">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
