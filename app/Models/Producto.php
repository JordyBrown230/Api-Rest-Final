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
        'nombre',
        'stock',
        'image',
        'proveedor',
        'categoria',
        'precioUnitario'
    ];

    public function detalleOrden(){
        return $this->hasMany('App\Models\DetalleOrden');
    }

    public function proveedor(){
        return $this->belongsTo('App\Models\Proveedor','proveedor');
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria','categoria');
    }
}
