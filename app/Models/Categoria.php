<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table='categoria';
    protected $primaryKey ='idCategoria';
    protected $fillable=[
        'idCategoria',
        'nombre',
        'descripcion'
    ];
    public function productos(){
        return $this->hasMany('App\Models\Producto');
    }
    
}
