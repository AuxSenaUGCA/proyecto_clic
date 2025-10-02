<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClicController extends Controller
{
    public function index($input) 
    {
        $response = "Respuesta de prueba: " . $input;

        $data = ['success' => true, 'Response' => $response];
        return response()->json($data, 200, []);
    }
}
