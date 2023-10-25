<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nombre'];

    //Relación uno a muchos
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }

    //Relación muchos a muchos
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
