<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table='detalleorden';
    
    protected $fillable=[
        'idDetalleOrden',
        'cantidad',
        'precioUnitario',
        'ivaUnitario',
        'orden'
    ];

    public function productos(){
        return $this->hasMany('App\Models\Producto');
    }

    public function orden(){
        return $this->belongsTo('App\Models\Orden','orden');
    }


}
