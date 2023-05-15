<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PuestoController;
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
        Route::put('/usuario',[UsuarioController::class, 'update']);

        Route::put('/empleado', [EmpleadoController::class, 'update']);

        Route::put('/orden',[OrdenController::class,'update']);

        Route::put('/categoria',[CategoriaController::class,'update']);

        Route::put('/producto',[ProductoController::class,'update']);

        Route::put('/envio',[EnvioController::class,'update']);

        Route::put('/telefonocliente',[TelefonoClienteController::class,'update']);

        Route::put('/vehiculo',[VehiculoController::class,'update']);

        Route::put('/direccioncliente',[DireccionClienteController::class,'update']);

        Route::put('/puesto',[PuestoController::class,'update']);

        Route::put('/proveedor',[ProveedorController::class,'update']);

        Route::put('/detalleorden',[DetalleOrdenController::class,'update']);

        Route::put('/cliente',[ClienteController::class,'update']);

        Route::post('/usuario/login',[UsuarioController::class,'login']);

        Route::get('/usuario/getidentity',[UsuarioController::class,'getIdentity']);




       //RUTAS AUTOMÁTICAS Restful
        Route::resource('/categoria',CategoriaController::class,['except'=>['create','edit','update']]);

        Route::resource('/usuario', UsuarioController::class,['except'=>['create','edit','update']]);

        Route::resource('/puesto',PuestoController::class,['except'=>['create','edit','update']]);

        Route::resource('/empleado',EmpleadoController::class,['except'=>['create','update','edit']]);

        Route::resource('/orden',OrdenController::class,['except'=>['create','edit','update']]);

        Route::resource('/producto',ProductoController::class,['except'=>['create','edit','update']]);

        Route::resource('/envio',EnvioController::class,['except'=>['create','edit','update']]);

        Route::resource('/telefonocliente',TelefonoClienteController::class,['except'=>['create','edit','update']]);

        Route::resource('/vehiculo',VehiculoController::class,['except'=>['create','edit','update']]);

        Route::resource('/direccioncliente',DireccionClienteController::class,['except'=>['create','edit','update']]);

        Route::resource('/puesto',PuestoController::class,['except'=>['create','edit','update']]);

        Route::resource('/proveedor',ProveedorController::class,['except'=>['create','edit','update']]);

        Route::resource('/detalleorden',DetalleOrdenController::class,['except'=>['create','edit','update']]);

        Route::resource('/cliente',ClienteController::class,['except'=>['create','edit','update']]);

    }
);

