<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Productos extends Controller
{
    //
    public function listProductos(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = mb_strtoupper(trim($request->k_busc));

        try {

            $resul = DB::table('productos');

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
            return response()->json(['errors' => ['l_prod' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function grabProductos(Request $request)
    {
        $this->validate($request, [
            'k_grab' => 'required|string|in:modi,grab',
            'c_prod' => 'required_if:k_grab,modi',
            'l_prod' => 'required',
            'c_line' => 'required',
            's_vent' => 'required|numeric|gt:0',
            'l_deta' => 'nullable',
            'l_foto' => 'nullable',
            'c_indi' => 'nullable',
        ]);

        try {

            $params = [
                "l_prod" => mb_strtoupper(trim($request->l_prod),"UTF-8"),
                "c_line" => (int)$request->c_line,
                "s_vent" => (double)$request->s_vent,
                "l_deta" => mb_strtoupper(trim($request->l_deta),"UTF-8"),
                "l_foto" => trim($request->l_foto),
                "c_indi" => mb_strtoupper(trim($request->c_indi),"UTF-8"),
                "c_usua" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "c_usum" => mb_strtoupper(trim($request->usuario),"UTF-8"),
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"], $params["c_usua"]);

                DB::table('productos')
                    ->where("c_prod", $request->c_prod)
                    ->update($params);

            } else {   

                DB::table('productos')
                    ->insert($params);
            
            }
                
            $request->merge($params);
            return ['productos' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_prod' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimProductos(Request $request)
    {
        $this->validate($request,[
            "c_prod" => "required",
        ]);

        try {

            DB::table('productos')
                ->where("c_prod", $request->c_prod)
                ->delete();

            return ['productos' => ["l_prod" => $request->c_prod]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_prod' => [$e->getMessage()]]], 422);
        }
    }

    public static function Productos()
    {
        $resul = DB::table("productos")
                    ->select(DB::raw("c_prod, l_prod, c_line, s_vent, l_foto, c_indi"));
        $resul = $resul->get();

        return $resul;
    }
}
