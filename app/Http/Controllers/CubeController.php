<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cube;

class CubeController extends Controller
{
    // Crear un cubo
    public function store(Request $request)
    {
        $request->validate([
            'text_cube'   => 'required|string',
            'state_cube'       => 'in:active,inactive'
        ]);

        $lastNumber = Cube::max('number_cube');

        $newNumber = $lastNumber ? $lastNumber + 1 : 1;

        $cube = Cube::create([
            'number_cube' => $newNumber,
            'text_cube'   => $request->text_cube,
            'state_cube'       => $request->state ?? 'active',
        ]);

        return response()->json($cube, 201);
    }

    // Consultar todos los cubos
    public function index()
    {
        $cubes = Cube::all();
        return response()->json($cubes);
    }

    // Consultar un cubo específico
    public function show($id)
    {
        $cube = Cube::findOrFail($id);
        return response()->json($cube);
    }

    // Actualizar un cubo
    public function update(Request $request, $id)
    {
        $cube = Cube::findOrFail($id);

        $request->validate([
            'text_cube' => 'sometimes|string',
            'state_cube'     => 'sometimes|in:active,inactive'
        ]);

        // Solo actualizar text_cube y state, number_cube no se toca
        $cube->update($request->only('text_cube', 'state_cube'));

        return response()->json($cube);
    }

    // Eliminar un cubo
    public function destroy($id)
    {
        $cube = Cube::findOrFail($id);
        $cube->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cubo eliminado'
        ], 201);
    }
}
