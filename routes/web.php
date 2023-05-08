<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PuestoController;
use App\Http\Controllers\EmpleadoController;
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
        //RUTAS AUTOMÁTICAS Restful
        Route::resource('/puesto',PuestoController::class,['except'=>['create','edit']]);
        Route::resource('/empleado',EmpleadoController::class,['except'=>['create','edit']]);
    }
);

