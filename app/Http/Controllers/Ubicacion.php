<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Ubicacion extends Controller
{
    //
    public function listUbicacion(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = mb_strtoupper(trim($request->k_busc));

        try {

            $resul = DB::table('ubicacion');

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
            return response()->json(['errors' => ['l_ubic' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function grabUbicacion(Request $request)
    {
        $this->validate($request, [
            'k_grab' => 'required|string|in:modi,grab',
            'c_ubic' => 'required_if:k_grab,modi',
            'l_ubic' => 'required',
            'c_sucu' => 'required',
        ]);

        try {

            $params = [
                "l_ubic" => mb_strtoupper(trim($request->l_ubic),"UTF-8"),
                "c_sucu" => (int)$request->c_sucu,
                "c_usua" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"], $params["c_usua"]);

                DB::table('ubicacion')
                    ->where("c_ubic", $request->c_ubic)
                    ->update($params);

            } else {   

                DB::table('ubicacion')
                    ->insert($params);
            
            }
                
            $request->merge($params);
            return ['ubicacion' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_ubic' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimUbicacion(Request $request)
    {
        $this->validate($request,[
            "c_ubic" => "required",
        ]);

        try {

            DB::table('ubicacion')
                ->where("c_ubic", $request->c_ubic)
                ->delete();

            return ['ubicacion' => ["c_ubic" => $request->c_ubic]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_ubic' => [$e->getMessage()]]], 422);
        }
    }

    public static function Ubicacion()
    {
        $resul = DB::table("ubicacion")
                    ->select(DB::raw("c_ubic, l_ubic, c_sucu"));
        $resul = $resul->get();

        return $resul;
    }
}
