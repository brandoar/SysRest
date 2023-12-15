<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Usuarios extends Controller
{
    //
    public function listUsuarios(Request $request)
    {

        $this->validate($request, [
            'l_busc' => 'nullable',
            'k_busc' => 'nullable',
        ]);

        $l_busc = mb_strtolower(trim($request->l_busc));
        $k_busc = ((array)$request->k_busc);

        try {

            $resul = DB::table('usuarios')
                    ->select(DB::raw('c_usua, c_role, l_usua, n_docu, l_nomb, c_comp1, n_seri1, c_comp2, n_seri2'));

            if (!empty($l_busc) && count($k_busc) > 0) {
                foreach ($k_busc as $key => $value) {
                    if ($key == 0) {
                        $resul = $resul->where($value, 'like', '%' . $l_busc . '%');
                    } else {
                        $resul = $resul->orWhere($value, 'like', '%' . $l_busc . '%');
                    }
                }
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
    public function grabUsuario(Request $request)
    {
        $this->validate($request, [
            'k_grab' => 'required|string|in:modi,grab',
            'c_usua' => 'required_if:k_grab,modi',
            'l_usua' => 'required|string',
            'c_role' => 'required|numeric',
            'l_pass' => 'required|string',
            'n_docu' => 'nullable|string',
            'l_nomb' => 'nullable|string',
            'l_mail' => 'nullable|email',
            'n_celu' => 'nullable',
            'l_foto' => 'nullable',
            'c_sucu' => 'nullable',
        ]);

        try {

            $params = [
                "l_usua" => mb_strtoupper($request->l_usua, "UTF-8"),
                "c_role" => (int)$request->c_role,
                "l_pass" => mb_strtoupper($request->l_pass, "UTF-8"),
                "n_docu" => mb_strtoupper($request->n_docu, "UTF-8"),
                "l_nomb" => mb_strtoupper($request->l_nomb, "UTF-8"),
                "l_mail" => mb_strtoupper($request->l_mail, "UTF-8"),
                "n_celu" => mb_strtoupper($request->n_celu, "UTF-8"),
                "l_foto" => trim($request->l_foto),
                "c_sucu" => (int)$request->c_sucu,
                "f_digi" => date('Y-m-d\TH:i:s'),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if ($request->k_grab == "modi") {

                unset($params["f_digi"]);

                DB::table('usuarios')
                    ->where('c_usua', $request->c_usua)
                    ->update($params);

            } else {                
                DB::table('usuarios')
                    ->insert($params);
            }
                
            $request->merge($params);
            return ['usuarios' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['l_sucu' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function elimUsuario(Request $request)
    {
        $this->validate($request,[
            'c_usua' => "required",
        ]);

        try {

            if (DB::table('usuarios')->count() == 1) {
                return response()->json(['errors' => ['c_sucu' => ["No puede eliminar el último registro... !!!"]]], 422);
            }

            DB::table('usuarios')
                ->where('c_usua', $request->c_sucu)
                ->delete();

            return ['usuarios' => ['c_usua' => $request->c_sucu]];
            
        } catch (\Exception $e) {
            return response()->json(['errors' => ['c_usua' => [$e->getMessage()]]], 422);
        }
    }

    //
    public function devUsuario(Request $request)
    {
        $this->validate($request,[
            'c_usua' => "required",
        ]);

        $resul = DB::table('usuarios')
                    ->select(DB::raw("c_usua, l_usua, c_role, l_pass, n_docu, l_nomb, l_mail, n_celu, l_foto"))
                    ->where('c_usua', $request->c_usua)
                    ->first();

        return ['usuario' => (array)$resul];
    }

    //
    public function modiUsuarioAsigComprob(Request $request)
    {
        $this->validate($request, [
            'c_usua' => 'required',
            'c_comp1' => 'nullable',
            'n_seri1' => 'nullable',
            'c_comp2' => 'nullable',
            'n_seri2' => 'nullable',
        ]);

        try {


            $params = [
                "c_comp1" => mb_strtoupper($request->c_comp1, "UTF-8"),
                "n_seri1" => mb_strtoupper($request->n_seri1, "UTF-8"),
                "c_comp2" => mb_strtoupper($request->c_comp2, "UTF-8"),
                "n_seri2" => mb_strtoupper($request->n_seri2, "UTF-8"),
                "f_modi" => date('Y-m-d\TH:i:s'),
            ];

            if (DB::table("usuarios")->where("n_seri1", $params["n_seri1"])->count() > 0) {
                throw new \Exception("¡Esta serie ya ah sido asignada intente otra serie para factura!");
            }

            if (DB::table("usuarios")->where("n_seri2", $params["n_seri2"])->count() > 0) {
                throw new \Exception("¡Esta serie ya ah sido asignada intente otra serie para boleta de venta!");
            }

            if (DB::table("usuarios")->where("n_seri1", $params["n_seri2"])->count() > 0) {
                throw new \Exception("¡Esta serie ya ah sido asignada intente otra serie para factura!");
            }

            if (DB::table("usuarios")->where("n_seri2", $params["n_seri1"])->count() > 0) {
                throw new \Exception("¡Esta serie ya ah sido asignada intente otra serie para boleta de venta!");
            }

            DB::table('usuarios')
                    ->where('c_usua', $request->c_usua)
                    ->update($params);
                
            $request->merge($params);

            return ['usuario' => $request->all()];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['c_usua' => [$e->getMessage()]]], 422);
        }
    }
}
