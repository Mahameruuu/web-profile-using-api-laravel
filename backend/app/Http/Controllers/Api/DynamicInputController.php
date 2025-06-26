<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DynamicInput;

class DynamicInputController extends Controller
{
    public function index()
    {
        return response()->json(DynamicInput::all());
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

        $input = DynamicInput::create($request->all());

        return response()->json($input, 201);
    }

    public function show($id)
    {
        return response()->json(DynamicInput::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $input = DynamicInput::findOrFail($id);

        $request->validate([
            'label' => 'sometimes|required|string',
            'name' => 'sometimes|required|string|unique:dynamic_inputs,name,' . $id,
            'type' => 'sometimes|required|string|in:text,textarea,select,checkbox,radio',
            'active' => 'boolean',
            'options' => 'nullable|array'
        ]);

        $input->update($request->all());

        return response()->json($input);
    }

    public function destroy($id)
    {
        $input = DynamicInput::findOrFail($id);
        $input->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
