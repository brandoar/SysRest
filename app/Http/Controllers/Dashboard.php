<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Dashboard extends Controller
{
    //
    public function VentasxSucuAnual(Request $request)
    {
        $this->validate($request, [
            "c_anio" => "required"
        ]);

        $resul = DB::table("ventas")
                    ->select(DB::raw("c_sucu, MONTH(f_comp) c_mes, SUM(s_tota) s_tota"))
                    ->where(DB::raw("YEAR(f_comp)"), $request->c_anio)
                    ->groupBy(DB::raw("c_sucu, MONTH(f_comp)"))
                    ->orderBy(DB::raw("MONTH(f_comp)"))
                    ->get();

        return $resul;
    }
}
