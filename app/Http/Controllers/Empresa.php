<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Empresa extends Controller
{
    //
    public function devEmpresa(Request $request)
    {
        $resul = DB::table("empresa")->where("n_ruc", $request->n_ruc)->first();
        return ["Empresa" => (array)$resul];
    }

    //
    public function modEmpresa(Request $request)
    {
        $this->validate($request, [
            "n_ruc" => "required", 
            "l_empr" => "required",
            "c_usua" => "required", 
        ]);

        try {

            $params = [
                "n_ruc"  => $request->n_ruc,
                "l_empr" => mb_strtoupper(trim($request->l_empr),"UTF-8"),
                "l_dire" => mb_strtoupper(trim($request->l_dire),"UTF-8"),
                "n_celu" => mb_strtoupper(trim($request->n_celu),"UTF-8"),
                "l_logo" => trim($request->l_logo),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];
            
            DB::table("empresa")
                ->where("n_ruc", $params["n_ruc"])
                ->update($params);

            $request->merge($params);

            return ["empresa" => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['n_ruc' => [$e->getMessage()]]], 422);
        }
    }
}
