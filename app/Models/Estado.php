<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['nombre'];

    //Relación uno a muchos
    public function historiales()
    {
        return $this->hasMany(Historial::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
