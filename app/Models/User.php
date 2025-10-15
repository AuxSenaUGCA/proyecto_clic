<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'score',
        'completion_time',
    ];

    /**
     * Atributos ocultos en serialización (por ejemplo, al devolver JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // No necesitamos ocultar nada por ahora.
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completion_time' => 'integer',
        'score' => 'integer',
    ];
}
