<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'nif',
        'telefono',
        'email',
        'curriculum',
    ];
}
