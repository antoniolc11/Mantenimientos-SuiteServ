<?php

namespace App\Models;

use App\Policies\UbicacionPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'usuario_creador',
        'usuario_asignado',
        'descripcion',
        'departamento_id',
        'estado_id',
        'ubicacion_id',
        'categoria_id',
        'fecha',
        'prioridad',
    ];


    //Relación uno a muchos (inversa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'usuario_creador');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    //Relación uno a muchos
    public function historiales()
    {
        return $this->hasMany(Historial::class);
    }
}
