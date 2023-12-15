<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Roles;
use App\Http\Controllers\Sucursal;
use App\Http\Controllers\Ubicacion;
use App\Http\Controllers\Mesas;
use App\Http\Controllers\Lineas;
use App\Http\Controllers\Productos;
use App\Http\Controllers\Mozos;

class Store extends Controller
{
    //
    public function listRoles(Request $request)
    {
        return ['list'=>Roles::listRoles()];
    }
    //
    public function listSucursal(Request $request)
    {
        return ['list'=>Sucursal::Sucursal()];
    }

    //
    public function listUbicacion(Request $request)
    {
        return ['list'=>Ubicacion::Ubicacion()];
    }

    //
    public function listMesas(Request $request)
    {
        return ['list'=>Mesas::Mesas()];
    }

    //
    public function listLineas(Request $request)
    {
        return ['list'=>Lineas::Lineas()];
    }
    //
    public function listMozos(Request $request)
    {
        return ['list'=>Mozos::Mozos()];
    }
    //
    public function listProductos(Request $request)
    {
        return ['list'=>Productos::Productos()];
    }
}
