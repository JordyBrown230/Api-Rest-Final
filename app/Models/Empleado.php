<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table='empleado';

    protected $primaryKey = 'idEmpleado';

    protected $fillable=[
        'idEmpleado',
        'cedula',
        'nombre',
        'fechaNac',
        'fechaIngreso',
        'email', 
        'tipoEmpleado'
    ];

    /*
    public function scopePorPuesto($query, $nombrePuesto){
    
    return $query->whereHas('puesto', function($query) use ($nombrePuesto){
        $query->where('nombre', $nombrePuesto);
        });

    }
   */
   public function scopePorTipo($query,$nombrePuesto){
    return $query->where('tipoEmpleado', 'LIKE', $nombrePuesto. '%');
}

    public function ordenes(){
        return $this->hasMany('App\Models\Orden');
    }

    public function envios(){
        return $this->hasMany('App\Models\Envio');
    }

    public function usuario(){
        return $this->hasOne('App\Models\Usuario');
    }

}


