<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Roles extends Controller
{
    //
    public static function listRoles()
    {
        $resul = DB::table('roles')->get();
        return $resul;
    }
}
