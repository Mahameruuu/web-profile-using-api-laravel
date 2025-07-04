@extends('layouts.main')

@section('title', 'Manajemen Input')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Input</h2>
        <a href="{{ route('dynamic-inputs.create') }}" class="btn btn-primary">
            + Tambah Input
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Label</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Name</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Type</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Status</th>
                    <th class="px-4 py-3 text-left whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inputs as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $item->label }}</td>
                        <td class="px-4 py-2">{{ $item->name }}</td>
                        <td class="px-4 py-2">{{ $item->type }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded font-medium
                                {{ $item->active ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $item->active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <form method="POST" action="{{ route('dynamic-inputs.update', $item->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="active" value="{{ $item->active ? 0 : 1 }}">
                                <button type="submit"
                                    class="btn btn-sm {{ $item->active ? 'btn-danger' : 'btn-success' }}">
                                    {{ $item->active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <!-- <a href="{{ route('dynamic-inputs.edit', $item->id) }}" class="btn btn-sm btn-secondary">
                                Edit
                            </a> -->
                            <!-- <form method="POST" action="{{ route('dynamic-inputs.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form> -->
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Tidak ada data input.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
