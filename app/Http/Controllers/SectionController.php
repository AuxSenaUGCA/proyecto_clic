<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Sentence;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    // Crear una sección
    public function store(Request $request)
    {
        Log::info($request->all());
        $request->validate([
            'id_profe' => 'nullable|exists:users,id',
            'name_section' => 'required|string',
            'state_section' => 'nullable|in:active,inactive',
            'note_section' => 'nullable|string',
        ]);

        // Número de la frase
        $lastNumber = Section::max('number_section');
        $newNumber  = $lastNumber ? $lastNumber + 1 : 1;

        $section = Section::create([
            'number_section' => $newNumber,
            'name_section' => $request->name_section,
            'state_section' => $request->state_section ?? 'active',
            'id_profe'   => $request->id_profe,
            'note_section' => $request->note_section,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sección creada correctamente',
            'section' => $section,
        ], 201);
    }

    // Consultar todas las secciones
    public function index()
    {
        $sections = Section::with(['profesor', 'sentences'])->get();
        return response()->json($sections);
    }

    public function indexActive()
    {
        $sections = Section::with(['profesor', 'active_sentences.active_cubes'])
            ->where('state_section', 'active')
            ->get()
            ->values();

        foreach ($sections as $section) {
            foreach ($section->active_sentences as $sentence) {
                $cubes = $sentence->active_cubes->values();

                foreach ($cubes as $index => $cube) {
                    $cube->number_cube = $index + 1;
                }

                $sentence->setRelation('active_cubes', $cubes);
            }
        }

        return response()->json($sections);
    }

    // Consultar todas las secciones con paginación
    public function indexPaginated(Request $request)
    {
        $perPage = 10; // Número de secciones por página, puedes ajustarlo
        $page = $request->get('page', 1); // Página actual, por defecto 1

        $sections = Section::with(['profesor', 'sentences'])
            ->orderBy('id_section', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($sections);
    }

    // Consultar una sola sección
    public function show($id)
    {
        $section = Section::with(['profesor', 'sentences'])->findOrFail($id);
        return response()->json($section);
    }

    // Buscar secciones por nombre del profesor o id
    public function search(Request $request)
    {
        $q = $request->get('q');
        $filter = $request->get('filter', 'all'); 

        $sections = Section::with('profesor')
            ->where(function ($query) use ($q) {
                $query->where('name_section', 'LIKE', "%{$q}%")
                    ->orWhere('note_section', 'LIKE', "%{$q}%")
                    ->orWhereHas('sentences', function ($sentenceQuery) use ($q) {
                        $sentenceQuery->where('text_sentence', 'LIKE', "%{$q}%")
                            ->orWhere('note_sentence', 'LIKE', "%{$q}%")
                            ->orWhereHas('cubes', function ($cubeQuery) use ($q) {
                                $cubeQuery->where('text_cube', 'LIKE', "%{$q}%");
                            });
                    });
            });

        // 🔹 Aplicar filtro de estado
        if ($filter === 'active') {
            $sections->where('state_section', 'active');
        } elseif ($filter === 'inactive') {
            $sections->where('state_section', 'inactive');
        }

        $sections = $sections
            ->limit(5)
            ->get(['id_section', 'name_section', 'id_profe', 'state_section']);

        return response()->json($sections);
    }

    // Actualizar una sección
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'id_profe' => 'nullable|exists:teachers,id',
            'name_section' => 'sometimes|string',
            'state_section' => 'sometimes|in:active,inactive',
            'note_section' => 'nullable|string',
            'sentences' => 'nullable|array',
            'sentences.*.id_sentence' => 'required|exists:sentences,id_sentence',
            'sentences.*.text_sentence' => 'required|string',
            'sentences.*.number_sentence' => 'required|integer',
        ]);

        // --- Actualizar sección ---
        $section->update([
            'id_profe' => $request->id_profe ?? $section->id_profe,
            'name_section' => $request->name_section ?? $section->name_section,
            'state_section' => $request->state_section ?? $section->state_section,
            'note_section' => $request->note_section ?? $section->note_section,
        ]);

        // --- Actualizar sentencias ---
        if ($request->has('sentences')) {
            foreach ($request->sentences as $sentenceData) {
                $sentence = $section->sentences()->find($sentenceData['id_sentence']);
                if ($sentence) {
                    $sentence->update([
                        'text_sentence' => $sentenceData['text_sentence'],
                        'number_sentence' => $sentenceData['number_sentence'],
                    ]);
                }
            }
        }

        // Recargar relación
        $section->load('sentences');

        return response()->json([
            'success' => true,
            'message' => 'Sección y sentencias actualizadas correctamente',
            'section' => $section,
        ], 201);
    }


    // Eliminar una sección y sus frases asociadas
    public function destroy($id)
    {
        $section = Section::findOrFail($id);

        // Eliminar oraciones asociadas
        $section->sentences()->delete();

        // Luego eliminar la sección
        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sección eliminada correctamente',
        ], 201);
    }
}
