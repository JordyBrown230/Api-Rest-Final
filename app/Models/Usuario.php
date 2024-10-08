<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

   
    protected $table='usuario';
    protected $primaryKey="idUsuario";
    protected $fillable = [
        'nombreUsuario',
        'password',
        'tipoUsuario',
        'cliente',
        'empleado',
        'remember_token'
    ];

  
    protected $hidden = [
        'password',
        'remember_token',
    ];

 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente');
    }

    public function empleado(){
        return $this->belongsTo('App\Models\Empleado','empleado');
    }
    
}
