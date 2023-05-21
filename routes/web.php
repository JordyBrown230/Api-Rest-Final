<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\TelefonoClienteController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\DireccionClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\DetalleOrdenController;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('api')->group(
    function(){
        //RUTAS ESPECÍFICAS

        Route::post('/usuario/login',[UsuarioController::class,'login']);

        Route::get('/usuario/getidentity',[UsuarioController::class,'getIdentity']);


        //RUTAS MÉTODOS ESPECIALIZADOS

        Route::get('/cliente/nombre/{nombre}',[ClienteController::class,'getByName']);

        Route::get('/orden/cliente/{id}',[OrdenController::class,'getByClient']);

        Route::get('/empleado/puesto/{nombre}',[EmpleadoController::class,'getByJob']);

        Route::get('/cliente/telefonocliente/{id}',[ClienteController::class,'getNumsByClient']);

        Route::get('/cliente/direccioncliente/{id}',[ClienteController::class,'getDirByClient']);


       //RUTAS AUTOMÁTICAS Restful
        Route::resource('/categoria',CategoriaController::class,['except'=>['create','edit']]);

        Route::resource('/usuario', UsuarioController::class,['except'=>['create','edit']]);

        Route::resource('/empleado',EmpleadoController::class,['except'=>['create','edit']]);

        Route::resource('/orden',OrdenController::class,['except'=>['create','edit']]);

        Route::resource('/producto',ProductoController::class,['except'=>['create','edit']]);

        Route::resource('/envio',EnvioController::class,['except'=>['create','edit']]);

        Route::resource('/telefonocliente',TelefonoClienteController::class,['except'=>['create','edit']]);

        Route::resource('/vehiculo',VehiculoController::class,['except'=>['create','edit']]);

        Route::resource('/direccioncliente',DireccionClienteController::class,['except'=>['create','edit']]);

        Route::resource('/proveedor',ProveedorController::class,['except'=>['create','edit']]);

        Route::resource('/detalleorden',DetalleOrdenController::class,['except'=>['create','edit']]);

        Route::resource('/cliente',ClienteController::class,['except'=>['create','edit']]);

      

    }
);

