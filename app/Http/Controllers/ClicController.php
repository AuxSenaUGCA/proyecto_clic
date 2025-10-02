<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClicController extends Controller
{
    public function index($dato) 
    {
        $respuesta = "Respuesta de prueba: " . $dato;

        $data = ['success' => true, 'Respuesta' => $respuesta];
        return response()->json($data, 200, []);
    }
}
