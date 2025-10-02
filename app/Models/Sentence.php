<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $table = 'sentences';
    protected $primaryKey = 'id_sentence'; // clave primaria personalizada
    public $incrementing = true;   // es auto incremental
    protected $keyType = 'int';    // tipo de la clave

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'number_sentence',
        'text_sentence',
        'state_sentence',
    ];

    // Si quieres que 'state' tenga valor por defecto
    protected $attributes = [
        'state_sentence' => 'active',
    ];

    public function cubes()
    {
        return $this->hasMany(Cube::class, 'id_sentence', 'id_sentence');
    }
}
