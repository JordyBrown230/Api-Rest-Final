<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table='orden';
    protected $fillable=[
        'idOrden',
        'tipoRetiro',
        'fechaOrden',
        'total',
        'ivaTotal',
        'envio',
        'cliente',
        'empleado'
    ];

    public function detalleOrden(){
        return $this->hasMany('App\Models\DetalleOrden');
    }

    public function envio(){
        return $this->belongsTo('App\Models\Envio','envio');
    }

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente');
    }

    public function empleado(){
        return $this->belongsTo('App\Models\Empleado','empleado');
    }

}
