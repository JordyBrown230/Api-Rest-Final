<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DireccionCliente extends Model
{
    use HasFactory;

    protected $table='direccionescliente';
    protected $primaryKey="idDireccionesCliente";

    protected $fillable=[
        'direccion','cliente'];
        
    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente');
    }
 
}
