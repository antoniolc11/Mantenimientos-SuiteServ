<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table = 'historiales';
    public $timestamps = false;
    protected $primaryKey = null; // Indica que no hay una columna de clave primaria
    public $incrementing = false; // Indica que no se debe intentar insertar ni retornar un valor de clave primaria
    protected $fillable = [
        'incidencia_id',
        'user_id',
        'estado_id',
        'ubicacion_id',
        'hora_inicio',
        'hora_fin',
        'trabajo_realizado',
        'fecha_actualizacion',
    ];

    //Relación uno a muchos (inversa)
    public function incidencia(){
        return $this->belongsTo('app\Models\Incidencia');
    }

    public function estado(){
        return $this->belongsTo('app\Models\Estado');
    }

}
