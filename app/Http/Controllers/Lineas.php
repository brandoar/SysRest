<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Lineas extends Controller
{
    //
    public function listLineas(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = mb_strtoupper(trim($request->k_busc));

        try {

            $resul = DB::table('lineas');

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
            return response()->json(['errors' => ['l_line' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function grabLineas(Request $request)
    {
        $this->validate($request, [
            'k_grab' => 'required|string|in:modi,grab',
            'c_line' => 'required_if:k_grab,modi',
            'l_line' => 'required',
            'l_impr' => 'nullable',
            'c_sucu' => 'nullable',
        ]);

        try {

            $params = [
                "l_line" => mb_strtoupper(trim($request->l_line),"UTF-8"),
                "l_impr" => mb_strtoupper(trim($request->l_impr),"UTF-8"),
                "c_sucu" => (int)$request->c_sucu,
                "c_usua" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"], $params["c_usua"]);

                DB::table('lineas')
                    ->where("c_line", $request->c_line)
                    ->update($params);

            } else {   

                DB::table('lineas')
                    ->insert($params);
            
            }
                
            $request->merge($params);
            return ['lineas' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_line' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimLineas(Request $request)
    {
        $this->validate($request,[
            "c_line" => "required",
        ]);

        try {

            DB::table('lineas')
                ->where("c_line", $request->c_line)
                ->delete();

            return ['lineas' => ["c_line" => $request->c_line]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_line' => [$e->getMessage()]]], 422);
        }
    }

    public static function Lineas()
    {
        $resul = DB::table("lineas")
                    ->select(DB::raw("c_line, l_line, c_sucu"));
                    //->whereIn('c_sucu',  ["0", session("usuario")["c_sucu"]]);
        $resul = $resul->get();

        return $resul;
    }
}
