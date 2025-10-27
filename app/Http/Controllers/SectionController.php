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
        ]);

        // Número de la frase
        $lastNumber = Section::max('number_section');
        $newNumber  = $lastNumber ? $lastNumber + 1 : 1;

        $section = Section::create([
            'number_section' => $newNumber,
            'name_section' => $request->name_section,
            'state_section' => $request->state_section ?? 'active',
            'id_profe'   => $request->id_profe,
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

        $sections = Section::with('profesor')
            ->whereHas('profesor', function ($query) use ($q) {
                $query->where('name', 'LIKE', "%{$q}%");
            })
            ->orWhere('id_section', 'LIKE', "%{$q}%")
            ->limit(5)
            ->get(['id_section', 'id_profe']);

        return response()->json($sections);
    }

    // Actualizar una sección
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'id_profe' => 'nullable|exists:users,id',
            'name_section' => 'sometimes|string',
            'state_section' => 'sometimes|in:active,inactive',
        ]);

        $section->update([
            'id_profe' => $request->id_profe ?? $section->id_profe,
            'name_section' => $request->name_section ?? $section->name_section,
            'state_section' => $request->state_section ?? $section->state_section,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sección actualizada correctamente',
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
