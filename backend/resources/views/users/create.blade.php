@extends('layouts.main')

@section('title', 'Tambah User')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
  <div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah User</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
        <ul class="list-disc pl-4">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
      @csrf

      {{-- Nama --}}
      <div>
        <label for="name" class="block mb-1 font-medium text-gray-700">Nama</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      {{-- Email --}}
      <div>
        <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      {{-- Password --}}
      <div>
        <label for="password" class="block mb-1 font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password"
               class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      {{-- Role --}}
      <div>
        <label for="role" class="block mb-1 font-medium text-gray-700">Role</label>
        <select name="role" id="role"
                class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
          <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
      </div>

      {{-- Dynamic Fields --}}
      @if(isset($dynamicInputs))
        <hr>
        <h5 class="mb-3 font-semibold text-gray-700">Data Tambahan</h5>

        @foreach($dynamicInputs as $input)
          <div>
            <label class="block mb-1 font-medium text-gray-700">{{ $input->label }}</label>

            @php
              $value = old("dynamic_fields.{$input->name}", $dynamicFields[$input->name] ?? '');
              $options = json_decode($input->options, true) ?? [];
            @endphp

            @if(in_array($input->type, ['text', 'textarea']))
              <input type="{{ $input->type }}" name="dynamic_fields[{{ $input->name }}]"
                     class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                     value="{{ $value }}">
            @elseif($input->type === 'select')
              <select name="dynamic_fields[{{ $input->name }}]"
                      class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                @foreach($options as $opt)
                  <option value="{{ $opt }}" {{ $value === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
              </select>
            @elseif($input->type === 'radio')
              <div class="flex gap-4">
                @foreach($options as $opt)
                  <label class="inline-flex items-center">
                    <input type="radio" name="dynamic_fields[{{ $input->name }}]" value="{{ $opt }}"
                           class="form-radio text-blue-600" {{ $value === $opt ? 'checked' : '' }}>
                    <span class="ml-2">{{ $opt }}</span>
                  </label>
                @endforeach
              </div>
            @elseif($input->type === 'checkbox')
              @php $checkedValues = is_array($value) ? $value : explode(',', $value); @endphp
              <div class="space-y-1">
                @foreach($options as $opt)
                  <label class="inline-flex items-center">
                    <input type="checkbox" name="dynamic_fields[{{ $input->name }}][]"
                           value="{{ $opt }}" class="form-checkbox text-blue-600"
                           {{ in_array($opt, $checkedValues) ? 'checked' : '' }}>
                    <span class="ml-2">{{ $opt }}</span>
                  </label>
                @endforeach
              </div>
            @endif
          </div>
        @endforeach
      @endif

      {{-- Tombol --}}
      <div class="pt-4">
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-primary ml-2">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
