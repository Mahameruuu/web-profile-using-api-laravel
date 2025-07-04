<?php

namespace App\Http\Controllers;

use App\Models\DynamicInput;
use Illuminate\Http\Request;

class DynamicInputController extends Controller
{
    public function index()
    {
        $inputs = DynamicInput::all();
        return view('dynamic-inputs.index', compact('inputs'));
    }

    public function create()
    {
        return view('dynamic-inputs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'name' => 'required|string|unique:dynamic_inputs,name',
            'type' => 'required|string|in:text,textarea,select,checkbox,radio',
            'active' => 'boolean',
            'options' => 'nullable|array'
        ]);

        // Simpan sebagai JSON jika perlu
        $data = $request->all();
        if (isset($data['options'])) {
            $data['options'] = json_encode($data['options']);
        }

        DynamicInput::create($data);

        return redirect()->route('dynamic-inputs.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $input = DynamicInput::findOrFail($id);
        return view('dynamic-inputs.show', compact('input'));
    }

    public function edit($id)
    {
        $input = DynamicInput::findOrFail($id);
        return view('dynamic-inputs.edit', compact('input'));
    }

    public function update(Request $request, $id)
    {
        $input = DynamicInput::findOrFail($id);

        $request->validate([
            'label' => 'sometimes|required|string',
            'name' => 'sometimes|required|string|unique:dynamic_inputs,name,' . $id,
            'type' => 'sometimes|required|string|in:text,textarea,select,checkbox,radio',
            'active' => 'nullable|boolean',
            'options' => 'nullable|string' // ubah jadi string karena dari form Blade
        ]);

        $data = $request->all();

        // Tangani options jika diisi
        if (!empty($data['options'])) {
            $data['options'] = json_encode(array_map('trim', explode(',', $data['options'])));
        }

        // Tangani nilai aktif/non-aktif
        $data['active'] = $request->input('active') ? 1 : 0;

        $input->update($data);

        return redirect()->route('dynamic-inputs.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $input = DynamicInput::findOrFail($id);
        $input->delete();

        return redirect()->route('dynamic-inputs.index')->with('success', 'Data berhasil dihapus');
    }
}
