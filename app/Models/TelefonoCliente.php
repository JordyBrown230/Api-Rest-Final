<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonoCliente extends Model
{
    use HasFactory;

    protected $table='telefonoscliente';
    protected $fillable=[
        'numTelefono','cliente'];
    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente');
    }
 
}
