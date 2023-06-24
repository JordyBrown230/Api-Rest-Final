<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table='detalleorden';

    protected $primaryKey ='idDetalleOrden';
    
    protected $fillable=[
        'cantidad',
        'precioUnitario',
        'ivaUnitario',
        'orden',
        'producto'
    ];

    public function producto(){
        return $this->belongsTo('App\Models\Producto','producto');
    }

    public function orden(){
        return $this->belongsTo('App\Models\Orden','orden');
    }


}
