<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cube extends Model
{
    use HasFactory;

    protected $table = 'cubes';
    protected $primaryKey = 'id_cube'; // clave primaria personalizada
    public $incrementing = true;   // es auto incremental
    protected $keyType = 'int';    // tipo de la clave

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'number_cube',
        'text_cube',
        'state_cube',
        'id_sentence',
    ];

    // Si quieres que 'state' tenga valor por defecto
    protected $attributes = [
        'state_cube' => 'active',
    ];

    public function sentence()
    {
        return $this->belongsTo(Sentence::class, 'id_sentence', 'id_sentence');
    }
}
