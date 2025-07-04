@extends('layouts.main') 

@section('title', 'Tambah Input')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Input Baru</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dynamic-inputs.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-gray-700">Label</label>
                <input type="text" name="label" value="{{ old('label') }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Name (unik)</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Tipe Input</label>
                <select name="type" class="w-full border px-3 py-2 rounded">
                    <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                    <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select</option>
                    <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                    <option value="radio" {{ old('type') == 'radio' ? 'selected' : '' }}>Radio</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">
                    Opsi (untuk select/checkbox/radio, pisahkan dengan koma)
                </label>
                <input type="text" name="options" value="{{ old('options') }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="active" value="1" class="mr-2"
                    {{ old('active', true) ? 'checked' : '' }}>
                <label class="text-gray-700 font-medium">Aktif</label>
            </div>

            <div class="pt-3">
                <button type="submit" class="btn btn-primary mt-4">
                    Simpan
                </button>
                <a href="{{ route('dynamic-inputs.index') }}" class="ml-2 text-sm text-gray-500 hover:underline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
