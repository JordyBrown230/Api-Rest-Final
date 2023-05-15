<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table='vehiculo';

    protected $primaryKey ='numUnidad';

    protected $fillable=[
        'placa',
        'color',
        'tipo',
        'modelo'
    ];

    public function envios(){
        return $this->hasMany('App\Models\Envio');
    }


}
