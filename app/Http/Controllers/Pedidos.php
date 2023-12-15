<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Pedidos extends Controller
{
    //
    public function index(Request $request) {
        
        $this->validate($request, [
            "l_clav" => "required|numeric"
        ]);

        $mozo = DB::table("mozos")->where("l_clav", $request->l_clav)->get();

        if (count($mozo) == 0) {
            return response()->json(['errors' => ['l_clav' => ["Clave ingresada incorrecta"]]], 422);
        }

        return (array)$mozo[0];

    }
}
