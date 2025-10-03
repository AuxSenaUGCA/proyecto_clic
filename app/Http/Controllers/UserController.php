<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // Crear usuario
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', Password::defaults()],
            'avatar' => 'nullable|string|max:255'
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

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => ['sometimes', 'required', 'string', Password::defaults()],
            'avatar' => 'nullable|string|max:255'
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
