<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DynamicInput;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserViewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $role = $request->role;

        $users = User::query()
            ->when($search, fn($q) =>
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
            )
            ->when($role, fn($q) => $q->where('role', $role))
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        $dynamicInputs = DynamicInput::where('active', true)->get();
        return view('users.create', compact('dynamicInputs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'email'           => 'required|email|unique:users',
            'password'        => 'required',
            'role'            => 'nullable',
            'dynamic_fields'  => 'nullable|array'
        ]);

        $data = $request->only(['name', 'email', 'role']);
        $data['password'] = Hash::make($request->password);

        // Ambil field dinamis yang aktif
        $activeFields = DynamicInput::where('active', true)->pluck('name')->toArray();
        $submittedFields = $request->input('dynamic_fields', []);

        $filteredFields = array_filter(
            $submittedFields,
            fn($value, $key) => in_array($key, $activeFields),
            ARRAY_FILTER_USE_BOTH
        );

        // Simpan ke kolom extra_data
        $data['extra_data'] = json_encode($filteredFields);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            'role'     => 'nullable',
            'dynamic_fields' => 'nullable|array'
        ]);

        $data = $request->only(['name', 'email', 'role']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // Update extra_data jika dynamic fields dikirim
        if ($request->has('dynamic_fields')) {
            $activeFields = DynamicInput::where('active', true)->pluck('name')->toArray();
            $submittedFields = $request->input('dynamic_fields', []);

            $filteredFields = array_filter(
                $submittedFields,
                fn($value, $key) => in_array($key, $activeFields),
                ARRAY_FILTER_USE_BOTH
            );

            $data['extra_data'] = json_encode($filteredFields);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function showImportForm()
    {
        return view('users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->route('users.index')->with('success', 'Import user berhasil.');
    }
}
