<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table='orden';
    protected $primaryKey="idOrden";

    protected $fillable=[
        'tipoRetiro',
        'fechaOrden',
        'total',
        'ivaTotal',
        'envio',
        'cliente',
        'empleado'
    ];

    public function scopePorCliente($query,$cliente_id){
        return $query->where('cliente', $cliente_id);
    }

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
