<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table='producto';

    protected $primaryKey = 'idProducto';

    protected $fillable=[
        'idProducto',
        'nombre',
        'precioUnitario',
        'stock',
        'foto',
        'proveedor',
        'categoria',
        'detalleOrden'
    ];

    public function detalleOrden(){
        return $this->belongsTo('App\Models\DetalleOrden','detalleOrden');
    }

    public function proveedor(){
        return $this->belongsTo('App\Models\Proveedor','proveedor');
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria','categoria');
    }
}
