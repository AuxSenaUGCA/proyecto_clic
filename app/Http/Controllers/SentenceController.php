<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use Illuminate\Http\Request;
use App\Models\Sentence;

class SentenceController extends Controller
{
    // Crear una frase con cubos
    public function store(Request $request)
    {
        $request->validate([
            'text_sentence'   => 'required|string',
            'state_sentence'  => 'in:active,inactive',
            'cubes'           => 'array|max:4',
            'cubes.*.text_cube'  => 'required|string',
            'cubes.*.state_cube' => 'in:active,inactive'
        ]);

        // Número de la frase
        $lastNumber = Sentence::max('number_sentence');
        $newNumber  = $lastNumber ? $lastNumber + 1 : 1;

        // Crear frase
        $sentence = Sentence::create([
            'number_sentence' => $newNumber,
            'text_sentence'   => $request->text_sentence,
            'state_sentence'  => $request->state_sentence ?? 'active',
        ]);

        // Crear cubos relacionados
        if ($request->has('cubes')) {
            foreach ($request->cubes as $index => $cubeData) {
                Cube::create([
                    'number_cube' => $index + 1,
                    'text_cube'   => $cubeData['text_cube'],
                    'state_cube'  => $cubeData['state_cube'] ?? 'active',
                    'id_sentence' => $sentence->id_sentence
                ]);
            }
        }

        return redirect('/');
    }

    // Consultar todas las frases
    public function index()
    {
        $sentences = Sentence::with('cubes')->get();
        return response()->json($sentences);
    }

    public function indexActive()
    {
        $sentences = Sentence::with('activeCubes')
            ->where('state_sentence', 'active')
            ->get()
            ->values(); // asegura que sea un array

        return response()->json($sentences);
    }

    // Consultar una frase
    public function show($id)
    {
        $sentence = Sentence::with('cubes')->findOrFail($id);
        return response()->json($sentence);
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $sentences = Sentence::where('text_sentence', 'LIKE', "%{$q}%")
            ->limit(5) // máximo 5 resultados
            ->get(['id_sentence', 'text_sentence']);

        return response()->json($sentences);
    }

    // Actualizar una frase y sus cubos
    public function update(Request $request, $id)
    {
        $sentence = Sentence::findOrFail($id);

        $request->validate([
            'text_sentence'   => 'sometimes|string',
            'state_sentence'  => 'sometimes|in:active,inactive',
            'cubes'           => 'array|max:4',
            'cubes.*.id_cube' => 'sometimes|exists:cubes,id_cube',
            'cubes.*.text_cube'  => 'required|string',
            'cubes.*.state_cube' => 'in:active,inactive'
        ]);

        // Actualizar la frase
        $sentence->update($request->only('text_sentence', 'state_sentence'));

        // --- ELIMINAR CUBOS BORRADOS ---
        if ($request->filled('deleted_cubes')) {
            $deletedIds = explode(',', $request->input('deleted_cubes'));
            Cube::whereIn('id_cube', $deletedIds)->delete();
        }

        // --- ACTUALIZAR O CREAR CUBOS Y RENUMERAR ---
        if ($request->has('cubes')) {
            foreach ($request->cubes as $index => $cubeData) {
                $numberCube = $index + 1;

                if (!empty($cubeData['id_cube'])) {
                    // actualizar cubo existente
                    $cube = Cube::find($cubeData['id_cube']);
                    if ($cube) {
                        $cube->update([
                            'text_cube'  => $cubeData['text_cube'],
                            'state_cube' => $cubeData['state_cube'] ?? 'active',
                            'number_cube' => $numberCube,
                        ]);
                    }
                } else {
                    // crear nuevo cubo
                    Cube::create([
                        'number_cube' => $numberCube,
                        'text_cube'   => $cubeData['text_cube'],
                        'state_cube'  => $cubeData['state_cube'] ?? 'active',
                        'id_sentence' => $sentence->id_sentence
                    ]);
                }
            }
        }

        return redirect('/');
    }

    // Eliminar una frase y sus cubos
    public function destroy($id)
    {
        $sentence = Sentence::findOrFail($id);

        // eliminar cubos asociados primero
        $sentence->cubes()->delete();

        $sentence->delete();

        return redirect('/');
    }
}
