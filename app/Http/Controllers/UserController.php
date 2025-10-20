<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Crear usuario
    public function store(Request $request)
    {
        // Validación de datos
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string|max:255',
            'score' => 'nullable|integer|min:0',
            'completion_time' => 'nullable|integer|min:0',
        ]);

        // Buscar si el usuario ya existe por su nombre
        $user = User::where('name', $data['name'])->first();

        if ($user) {
            // Si ya existe, retornamos el usuario existente
            return response()->json($user, 201);
        }

        // Si no existe, lo creamos
        $user = User::create($data);

        return response()->json($user, 201);
    }

    // Consultar todos los usuarios
    public function index()
    {
        return response()->json(User::all());
    }

    // Consultar un usuario por id
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $users = User::where('name', 'like', "%$query%")->get();
        return response()->json($users);
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:users,name,' . $id, // 👈 permite mantener su propio name
            ],
            'avatar' => 'nullable|string|max:255',
            'score' => 'nullable|integer|min:0',
            'completion_time' => 'nullable|integer|min:0',
        ]);

        $user->update($data);

        return response()->json($user);
    }

    public function destroyAll()
    {
        // Verificar si hay usuarios
        $count = User::count();

        if ($count === 0) {
            return response()->json(['message' => 'No hay usuarios para eliminar.']);
        }

        // Eliminar todos los registros
        User::truncate(); 

        return redirect('/users');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users');
    }

    // 🧹 Limpiar los datos de todos los usuarios
    public function clearAll()
    {
        // Establece avatar como null y resetea los campos numéricos
        User::query()->update([
            'avatar' => null,
            'score' => 0,
            'completion_time' => 0,
        ]);

        return redirect('/users');
    }

    // 🧍‍♂️ Limpiar los datos de un usuario por ID
    public function clearOne($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        $user->update([
            'avatar' => null,
            'score' => 0,
            'completion_time' => 0,
        ]);

        return redirect('/users');
    }
}
