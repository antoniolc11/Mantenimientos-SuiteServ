<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];
    public $timestamps = false;


    //Relación uno a muchos
    public function Incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
