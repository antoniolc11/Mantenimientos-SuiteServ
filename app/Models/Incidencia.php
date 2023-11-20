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

    /**
     * Método "boot" del modelo.
     *
     * El método "boot" se utiliza para configurar eventos y comportamientos específicos
     * en el modelo. En este caso, se utiliza para establecer un evento de creación
     * que genera automáticamente un número de incidencia en un formato específico antes
     * de que se cree una nueva instancia de Incidencia.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($incidencia) {
            // Obtener el valor máximo de "numero" desde la base de datos
            $ultimoNumero = self::max('numero');

            // Calcular el siguiente valor de "numero"
            $numero = $ultimoNumero ? (int)substr($ultimoNumero, 3) + 1 : 1;

            // Generar el valor de "numero" formateado (por ejemplo, "INC00001")
            $incidencia->numero = 'INC' . str_pad($numero, 5, '0', STR_PAD_LEFT);
        });
    }

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

    public function prioridadColor()
    {
        switch ($this->prioridad) {
            case 'Alta':
                return 'bg-red-600';
            case 'Media':
                return 'bg-yellow-600';
            case 'Baja':
                return 'bg-yellow-400';
            default:
                return '';
        }
    }
}
