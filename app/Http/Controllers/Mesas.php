<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Mesas extends Controller
{
    //
    public function listMesas(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = mb_strtoupper(trim($request->k_busc));

        try {

            $resul = DB::table('mesas');

            if (!empty($l_busc) && !empty($k_busc)) {
                $resul = $resul->where($k_busc, 'like', '%' . $l_busc . '%');
            }

            $resul = $resul->orderBy('f_digi', 'desc')
                ->paginate(15);

            return [
                'total'        => $resul->total(),
                'current_page' => $resul->currentPage(),
                'per_page'     => $resul->perPage(),
                'last_page'    => $resul->lastPage(),
                'from'         => $resul->firstItem(),
                'to'           => $resul->lastItem(),
                'data'         => $resul->items(),
            ];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_mesa' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function grabMesas(Request $request)
    {
        $this->validate($request, [
            'k_grab' => 'required|string|in:modi,grab',
            'c_mesa' => 'required_if:k_grab,modi',
            'l_mesa' => 'required',
            'c_ubic' => 'required',
            'n_sill' => 'required',
        ]);

        try {

            $params = [
                "l_mesa" => mb_strtoupper(trim($request->l_mesa),"UTF-8"),
                "n_sill" => (int)$request->n_sill,
                "c_ubic" => (int)$request->c_ubic,
                "c_usua" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"], $params["c_usua"]);

                DB::table('mesas')
                    ->where("c_mesa", $request->c_mesa)
                    ->update($params);

            } else {   

                DB::table('mesas')
                    ->insert($params);
            
            }
                
            $request->merge($params);
            return ['mesas' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_mesa' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimMesas(Request $request)
    {
        $this->validate($request,[
            "c_mesa" => "required",
        ]);

        try {

            $c_mesa = DB::table("mesas")->where("c_mesa", $request->c_mesa)->first();

            if ($c_mesa->q_ocup == 1) {
                return response()->json(['errors' => ['l_mesa' => ["¡La mesa esta ocupada no se puede eliminar!"]]], 422);
            }

            DB::table('mesas')
                ->where("c_mesa", $request->c_mesa)
                ->delete();

            return ['mesas' => ["c_mesa" => $request->c_mesa]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_mesa' => [$e->getMessage()]]], 422);
        }
    }

    public static function Mesas()
    {
        $resul = DB::table("mesas")
                    ->select(DB::raw("c_mesa, l_mesa, q_ocup, c_ubic, n_sill"));
                    //->whereIn('c_sucu',  ["0", session("usuario")["c_sucu"]]);
        $resul = $resul->get();

        return $resul;
    }
}
