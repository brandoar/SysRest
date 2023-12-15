<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Mozos extends Controller
{
    //
    public function listMozos(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = mb_strtoupper(trim($request->k_busc));

        try {

            $resul = DB::table('mozos');

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
            return response()->json(['errors' => ['l_mozo' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function grabMozos(Request $request)
    {
        $this->validate($request, [
            'k_grab' => 'required|string|in:modi,grab',
            'c_mozo' => 'required_if:k_grab,modi',
            'l_mozo' => 'required',
            'l_clav' => 'required',
        ]);

        try {

            $params = [
                "l_mozo" => mb_strtoupper(trim($request->l_mozo),"UTF-8"),
                "l_clav" => mb_strtoupper(trim($request->l_clav),"UTF-8"),
                "c_usua" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"], $params["c_usua"]);

                DB::table('mozos')
                    ->where("c_mozo", $request->c_mozo)
                    ->update($params);

            } else {   

                DB::table('mozos')
                    ->insert($params);
            
            }
                
            $request->merge($params);
            return ['mozos' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_mozo' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimMozos(Request $request)
    {
        $this->validate($request,[
            "c_mozo" => "required",
        ]);

        try {

            DB::table('mozos')
                ->where("c_mozo", $request->c_mozo)
                ->delete();

            return ['mozos' => ["c_mozo" => $request->c_mozo]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_mozo' => [$e->getMessage()]]], 422);
        }
    }

    public static function Mozos()
    {
        $resul = DB::table("mozos")
                    ->select(DB::raw("c_mozo, l_mozo, l_clav"));
        $resul = $resul->get();

        return $resul;
    } 
}
