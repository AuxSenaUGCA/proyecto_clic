<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use Illuminate\Http\Request;
use App\Models\Sentence;
use Illuminate\Support\Facades\Log;

class SentenceController extends Controller
{
    // Crear una frase con cubos
    public function store(Request $request)
    {
        $request->validate([
            'text_sentence'   => 'required|string',
            'state_sentence'  => 'in:active,inactive',
            'id_section'      => 'required|exists:sections,id_section',
            'note_sentence' => 'nullable|string',
            'cubes'           => 'array|max:4',
            'cubes.*.text_cube'  => 'required|string',
            'cubes.*.state_cube' => 'in:active,inactive'
        ]);

        // Número de la frase
        $lastNumber = Sentence::where('id_section', $request->id_section)
            ->max('number_sentence');
        $newNumber = $lastNumber ? $lastNumber + 1 : 1;

        // Crear frase
        $sentence = Sentence::create([
            'number_sentence' => $newNumber,
            'text_sentence'   => $request->text_sentence,
            'state_sentence'  => $request->state_sentence ?? 'active',
            'note_sentence'   => $request->note_sentence,
            'id_section'      => $request->id_section,
        ]);

        // Crear cubos relacionados
        $cubes = [];
        if ($request->has('cubes')) {
            foreach ($request->cubes as $index => $cubeData) {
                $cube = Cube::create([
                    'number_cube' => $index + 1,
                    'text_cube'   => $cubeData['text_cube'],
                    'state_cube'  => $cubeData['state_cube'] ?? 'active',
                    'id_sentence' => $sentence->id_sentence
                ]);
                $cubes[] = $cube;
            }
        }

        $sentence->load('cubes');

        return response()->json([
            'success'  => true,
            'message'  => 'Frase creada correctamente',
            'sentence' => $sentence
        ], 201);
    }

    // Consultar todas las frases (con secciones y cubos)
    public function index()
    {
        $sentences = Sentence::with(['cubes', 'section'])->get();
        return response()->json($sentences);
    }

    // Consultar todas las frases activas (con secciones y cubos activos)
    public function indexActive()
    {
        $sentences = Sentence::with(['active_cubes', 'section'])
            ->where('state_sentence', 'active')
            ->get()
            ->values();

        // Reenumerar los number_cube solo en la respuesta
        foreach ($sentences as $sentence) {
            $cubes = $sentence->active_cubes->values(); // reindexar la colección

            foreach ($cubes as $index => $cube) {
                // Asignamos un número consecutivo temporal (no persistente)
                $cube->number_cube = $index + 1;
            }

            $sentence->setRelation('active_cubes', $cubes);
        }

        return response()->json($sentences);
    }

    // Consultar frases por sección específica
    public function indexBySection($id_section)
    {
        $sentences = Sentence::with(['cubes', 'section'])
            ->where('id_section', $id_section)
            ->orderBy('number_sentence', 'asc')
            ->get()
            ->values();

        return response()->json($sentences);
    }

    // Consultar una frase específica
    public function show($id)
    {
        $sentence = Sentence::with(['cubes', 'section'])->findOrFail($id);
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
            'note_sentence' => 'nullable|string',
            'id_section'      => 'sometimes|exists:sections,id_section',
            'cubes'           => 'array|max:4',
            'cubes.*.id_cube' => 'sometimes|exists:cubes,id_cube',
            'cubes.*.text_cube'  => 'required|string',
            'cubes.*.state_cube' => 'in:active,inactive',
            'deleted_cubes'   => 'nullable|string',
        ]);

        // --- ACTUALIZAR FRASE ---
        $sentence->update($request->only('text_sentence', 'state_sentence', 'note_sentence','id_section'));

        // --- ELIMINAR CUBOS BORRADOS ---
        if ($request->filled('deleted_cubes')) {
            $deletedIds = array_filter(explode(',', $request->input('deleted_cubes')));
            Cube::whereIn('id_cube', $deletedIds)->delete();
        }

        if ($request->has('cubes')) {
            foreach ($request->cubes as $index => $cubeData) {
                $numberCube = $index + 1;

                if (!empty($cubeData['id_cube'])) {
                    $cube = Cube::find($cubeData['id_cube']);
                    if ($cube) {
                        $cube->update([
                            'text_cube'   => $cubeData['text_cube'],
                            'state_cube'  => $cubeData['state_cube'] ?? 'active',
                            'number_cube' => $numberCube,
                        ]);
                    }
                } else {
                    Cube::create([
                        'number_cube' => $numberCube,
                        'text_cube'   => $cubeData['text_cube'],
                        'state_cube'  => $cubeData['state_cube'] ?? 'active',
                        'id_sentence' => $sentence->id_sentence,
                    ]);
                }
            }
        }

        // --- RECARGAR RELACIÓN CON CUBOS ---
        $sentence->load('cubes');

        return response()->json([
            'success'  => true,
            'message'  => 'Frase actualizada correctamente',
            'sentence' => $sentence
        ], 201);
    }

    // Eliminar una frase y sus cubos
    public function destroy($id)
    {
        $sentence = Sentence::findOrFail($id);

        // eliminar cubos asociados primero
        $sentence->cubes()->delete();

        $sentence->delete();

        return response()->json([
            'success'  => true,
            'message'  => 'Frase eliminada correctamente'
        ], 201);
    }
}
