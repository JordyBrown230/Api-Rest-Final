<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $table='envio';

      protected $primaryKey = 'idEnvio';

    
    protected $fillable=[
        'idEnvio',
        'direccion',
        'fechaOrden',
        'chofer',
        'vehiculo'
    ];

    public function ordenes(){
        return $this->hasMany('App\Models\Orden');
    }

    public function chofer(){
        return $this->belongsTo('App\Models\Empleado','chofer');
    }

    public function vehiculo(){
        return $this->belongsTo('App\Models\Vehiculo','vehiculo');
    }

}
