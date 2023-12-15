<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Sucursal extends Controller
{
    //
    public function listSucursal(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = mb_strtoupper(trim($request->k_busc));

        try {

            $resul = DB::table('sucursal');

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
            return response()->json(['errors' => ['c_usua' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function grabSucursal(Request $request)
    {
        $this->validate($request, [
            'l_sucu' => 'required',
            'k_grab' => 'required|string|in:modi,grab',
            'c_sucu' => 'required_if:k_grab,modi',
        ]);

        try {

            $params = [
                "l_sucu" => mb_strtoupper(trim($request->l_sucu),"UTF-8"),
                "c_usua" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"], $params["c_usua"]);

                DB::table("sucursal")
                    ->where("c_sucu", $request->c_sucu)
                    ->update($params);

            } else {                
                DB::table("sucursal")
                    ->insert($params);
            }
                
            $request->merge($params);
            return ["Sucursal" => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_sucu' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimSucursal(Request $request)
    {
        $this->validate($request,[
            "c_sucu" => "required",
        ]);

        try {

            if (DB::table("sucursal")->count() == 1) {
                return response()->json(['errors' => ['c_sucu' => ["No puede eliminar el último registro... !!!"]]], 422);
            }

            DB::table("sucursal")
                ->where("c_sucu", $request->c_sucu)
                ->delete();

            return ["Sucursal" => ["c_sucu" => $request->c_sucu]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['c_sucu' => [$e->getMessage()]]], 422);
        }
    }

    public static function Sucursal()
    {
        $resul = DB::table("sucursal")->select(DB::raw("c_sucu, l_sucu"))->get();
        return $resul;
    }
}
