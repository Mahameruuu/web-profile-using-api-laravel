@extends('layouts.main')

@section('title', 'Manajemen User')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold text-dark">Daftar Users</h2>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-primary" onclick="window.location='{{ route('users.create') }}'">
        + Tambah User
      </button>
      <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('users.import') }}'">
        Import Excel
      </button>
    </div>
  </div>


  {{-- Search & Filter --}}
  <form method="GET" class="row g-2 align-items-center mb-4">
    <div class="col-sm-5">
      <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}" 
        class="form-control" 
        placeholder="Cari nama atau email..." 
      />
    </div>

    <div class="col-sm-3">
      <select name="role" class="form-select">
        <option value="">Semua Role</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
      </select>
    </div>

    <div class="col-auto">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Filter
      </button>
    </div>
  </form>


  {{-- Table --}}
  <div class="overflow-auto bg-white rounded-lg shadow">
    <table class="w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left w-[50px]">No</th>
          <th class="px-4 py-3 text-left">Nama</th>
          <th class="px-4 py-3 text-left">Email</th>
          <th class="px-4 py-3 text-left w-[100px]">Role</th>
          <th class="px-4 py-3 text-left w-[150px]">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($users as $index => $user)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">{{ $index + 1 }}</td>
            <td class="px-4 py-3">{{ $user->name }}</td>
            <td class="px-4 py-3">{{ $user->email }}</td>
            <td class="px-4 py-3 capitalize">{{ $user->role ?? 'user' }}</td>
            <td class="px-4 py-3 flex gap-2">
              <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data user.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
