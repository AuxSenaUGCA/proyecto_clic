<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Crear usuario
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string|max:255',
            'score' => 'nullable|integer|min:0',
            'completion_time' => 'nullable|integer|min:0', // segundos, milisegundos, etc.
        ]);

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
            'name' => 'sometimes|required|string|max:255',
            'avatar' => 'nullable|string|max:255',
            'score' => 'nullable|integer|min:0',
            'completion_time' => 'nullable|integer|min:0',
        ]);

        $user->update($data);

        return response()->json($user);
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users');
    }
}
