<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_section';
    protected $fillable = ['number_section', 'id_profe', 'name_section', 'state_section'];
    public $incrementing = false;

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profe');
    }

    public function sentences()
    {
        return $this->hasMany(Sentence::class, 'id_section')
            ->orderBy('number_sentence', 'asc');
    }
}
