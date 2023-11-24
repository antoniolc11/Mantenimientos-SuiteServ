<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    use CanResetPasswordTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'nif',
        'telefono',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Relación uno a muchos
    public function incidencias(){
        return $this->hasMany(Incidencia::class);
    }

    //Relación muchos a muchos
    public function departamentos(){
        return $this->belongsToMany(Departamento::class);
    }

    //Verifica si el usuario es del departamento de dirección.
    public function esDepartamentoDireccion()
    {
        return $this->departamentos->contains('nombre', 'Dirección');
    }

    public function esDepartamentoSupervision()
    {
        return $this->departamentos->contains('nombre', 'Supervisión');
    }

    public function esDepartamentoRrhh()
    {
        return $this->departamentos->contains('nombre', 'Recursos humanos');
    }


    public function perteneceAlDepartamento(Departamento $departamento)
    {
        return $this->departamentos->contains($departamento);
    }

    public function tieneMasDeUnDepartamento()
    {
        return $this->departamentos->count() > 1;
    }
}
