<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PuestoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\TelefonoClienteController;
use App\Http\Controllers\OrdenController;

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
       // Route::get('/category',[CategoryController::class,'index']);
       // Route::put('/empleados', 'EmpleadoController@update');
        Route::put('/empleado', [EmpleadoController::class, 'update']);
        Route::put('/usuario',[UsuarioController::class, 'update']);
       //RUTAS AUTOMÁTICAS Restful
        Route::resource('/puesto',PuestoController::class,['except'=>['create','edit']]);
        Route::resource('/empleado',EmpleadoController::class,['except'=>['create']]);
        Route::resource('/categoria',CategoriaController::class,['except'=>['create','edit']]);
        Route::put('/categoria',[CategoriaController::class,'update']);
        Route::put('/orden',[OrdenController::class,'update']);
        Route::post('/orden',[OrdenController::class,'store']);
        Route::delete('/categoria/{id}',[CategoriaController::class,'destroy']);
        Route::delete('/telefonocliente/{id}',[TelefonoClienteController::class,'destroy']);
        Route::resource('/usuario', UsuarioController::class,['except'=>['create','edit']]);
    }
);

