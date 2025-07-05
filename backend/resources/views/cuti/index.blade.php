@extends('layouts.main')

@section('title', 'Data Surat Cuti')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Surat Cuti</h2>
    <a href="{{ route('cuti.create') }}" class="btn btn-primary">
      + Tambah Cuti
    </a>
  </div>

  @if(session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="flex items-center px-4 py-3 rounded mb-4 bg-emerald-600 text-white shadow"
        >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="w-full table-auto text-sm">
      <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">No</th>
          <th class="px-4 py-3 text-left">Nama</th>
          <th class="px-4 py-3 text-left">NIP</th>
          <th class="px-4 py-3 text-left">Tgl Mulai</th>
          <th class="px-4 py-3 text-left">Tgl Akhir</th>
          <th class="px-4 py-3 text-left">Jumlah</th>
          <th class="px-4 py-3 text-left">Status</th>
          <th class="px-4 py-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($cutis as $index => $cuti)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2">{{ $index + 1 }}</td>
            <td class="px-4 py-2">{{ $cuti->nama }}</td>
            <td class="px-4 py-2">{{ $cuti->nip }}</td>
            <td class="px-4 py-2">{{ $cuti->tanggal_mulai }}</td>
            <td class="px-4 py-2">{{ $cuti->tanggal_akhir }}</td>
            <td class="px-4 py-2">{{ $cuti->jumlah_hari }} hari</td>
            <td class="px-4 py-2">
              <span class="px-2 py-1 text-xs rounded font-medium
                @if($cuti->status === 'Disetujui')
                  bg-green-100 text-green-700
                @elseif($cuti->status === 'Ditolak')
                  bg-red-100 text-red-700
                @else
                  bg-yellow-100 text-yellow-700
                @endif
              ">
                {{ $cuti->status }}
              </span>
            </td>
            <td class="px-4 py-2 space-x-1">
              @if($cuti->file_pdf)
              <a href="{{ route('cuti.download', $cuti->id) }}" class="btn btn-sm btn-success">
                📄 Download PDF
              </a>
              @else
                <span class="text-muted text-xs">Tidak ada file</span>
              @endif

              <form action="{{ route('cuti.destroy', $cuti->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                  🗑 Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center py-6 text-gray-500">
              Tidak ada data cuti.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
