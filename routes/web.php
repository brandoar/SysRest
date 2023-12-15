<?php

use Illuminate\Support\Facades\Route;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

use App\Http\Controllers\Store;

use App\Http\Controllers\Acceso;
use App\Http\Controllers\Dashboard;

use App\Http\Controllers\Empresa;
use App\Http\Controllers\Sucursal;
use App\Http\Controllers\Roles;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Ubicacion;
use App\Http\Controllers\Mesas;
use App\Http\Controllers\Mozos;
use App\Http\Controllers\Lineas;
use App\Http\Controllers\Productos;
use App\Http\Controllers\Pedidos;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/acceso', 'login')->middleware('invitado');
Route::post('/login',[Acceso::class, 'login'])->middleware('invitado');
Route::get('/logout',[Acceso::class, 'logout']);

Route::group(['prefix' => '/','middleware'=>['autenticado']], function() {

    Route::view('/','dashboard');

    Route::post('/store/roles',[Store::class, 'listRoles']);
    Route::post('/store/sucursal',[Store::class, 'listSucursal']);
    Route::post('/store/ubicacion',[Store::class, 'listUbicacion']);
    Route::post('/store/mesas',[Store::class, 'listMesas']);
    Route::post('/store/lineas',[Store::class, 'listLineas']);
    Route::post('/store/productos',[Store::class, 'listProductos']);
    Route::post('/store/mozos',[Store::class, 'listMozos']);

    Route::post('/dashboard/VentasxSucuAnual',[Dashboard::class, 'VentasxSucuAnual']);

    Route::post('/empresa',[Empresa::class, 'devEmpresa']);
    Route::post('/empresa/modempresa',[Empresa::class, 'modEmpresa']);

    Route::post('/sucursal',[Sucursal::class, 'listSucursal']);
    Route::post('/sucursal/grabsucursal',[Sucursal::class, 'grabSucursal']);
    Route::post('/sucursal/elimsucursal',[Sucursal::class, 'elimSucursal']);

    Route::post('/roles',[Roles::class, 'listRoles']);

    Route::post('/usuarios',[Usuarios::class, 'listUsuarios']);
    Route::post('/usuarios/grabusuarios',[Usuarios::class, 'grabUsuario']);
    Route::post('/usuarios/elimusuarios',[Usuarios::class, 'elimUsuario']);
    Route::post('/usuarios/devusuario',[Usuarios::class, 'devUsuario']);
    Route::post('/usuarios/modiusuarioasigcomprob',[Usuarios::class, 'modiUsuarioAsigComprob']);

    Route::post('/ubicacion',[Ubicacion::class, 'listUbicacion']);
    Route::post('/ubicacion/grabubicacion',[Ubicacion::class, 'grabUbicacion']);
    Route::post('/ubicacion/elimubicacion',[Ubicacion::class, 'elimUbicacion']);

    Route::post('/mesas',[Mesas::class, 'listMesas']);
    Route::post('/mesas/grabmesas',[Mesas::class, 'grabMesas']);
    Route::post('/mesas/elimmesas',[Mesas::class, 'elimMesas']);

    Route::post('/mozos',[Mozos::class, 'listMozos']);
    Route::post('/mozos/grabmozos',[Mozos::class, 'grabMozos']);
    Route::post('/mozos/elimmozos',[Mozos::class, 'elimMozos']);

    Route::post('/lineas',[Lineas::class, 'listLineas']);
    Route::post('/lineas/grablineas',[Lineas::class, 'grabLineas']);
    Route::post('/lineas/elimlineas',[Lineas::class, 'elimLineas']);

    Route::post('/productos',[Productos::class, 'listProductos']);
    Route::post('/productos/grabproductos',[Productos::class, 'grabProductos']);
    Route::post('/productos/elimproductos',[Productos::class, 'elimProductos']);

    Route::post('/pedido',[Pedidos::class, 'index']);


});