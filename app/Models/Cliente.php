<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
   
    protected $table='cliente';

    protected $primaryKey ='cedula';

    protected $fillable=[
        'cedula',
        'nombre',
        'fechaNac',
        'email'
    ];

    public function telefonos(){
        return $this->hasMany('App\Models\TelefonoCliente');
    }

    public function direcciones(){
        return $this->hasMany('App\Models\DireccionCliente');
    }

    public function ordenes(){
        return $this->hasMany('App\Models\Orden');
    }

    public function usuario(){
        return $this->hasOne('App\Models\Usuario');
    }


}
