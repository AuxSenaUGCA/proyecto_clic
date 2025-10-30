<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    public $incrementing = true;   
    protected $keyType = 'int';


    protected $fillable = [
        'first_name',
        'second_name',
        'first_lastname',
        'second_lastname',
        'email',
        'password',
    ];
}
