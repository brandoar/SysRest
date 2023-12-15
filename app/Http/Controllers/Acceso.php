<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Acceso extends Controller
{
    //
    public function login(Request $request) {

        $this->validate($request, [
            'c_usua' => 'required|max:20',
            'l_pass' => 'required',
        ]);

        $c_usua = mb_strtoupper(trim($request->c_usua), "UTF-8");
        $l_pass = (trim($request->l_pass));

        try {

            // Conexión SQL SERVER
            \Config::set('database.default', 'sqlsrv');
            \Config::set('database.connections.sqlsrv.host', '127.0.0.1');
            \Config::set('database.connections.sqlsrv.port', '1433');
            \Config::set('database.connections.sqlsrv.username', 'sa');
            \Config::set('database.connections.sqlsrv.password', 'A290197r');
            \Config::set('database.connections.sqlsrv.database', 'db_sysrest');
            
            $usuario = DB::table('usuarios as a')
                        ->leftJoin('sucursal as b', function ($join) {
                            $join->on('a.c_sucu', '=', 'b.c_sucu');
                        })
                        ->leftJoin('roles as c', function ($join) {
                            $join->on('a.c_role', '=', 'c.c_role');
                        })
                        ->select(DB::raw('a.c_usua, a.l_usua, a.l_foto, a.l_mail, a.l_nomb, a.c_comp1, a.n_seri1, a.c_comp2, a.n_seri2,
                                a.c_sucu, b.l_sucu, a.c_role, c.l_role'))
                        ->where([
                            ['a.l_usua', '=', $c_usua],
                            ['a.l_pass', '=', $l_pass]
                        ])->get();

            if (count($usuario) == 0) {
                return response()->json(['errors' => ['c_usua' => ['Usuario y/o contraseña incorrectas']]], 422);
            }

            $usuario = array_merge((array)$usuario[0], ["c_anio" => date("Y"), "c_mes" => date("m")]);

            //actualizando la fecha de acceso
            DB::table("usuarios")
            ->where([
                ["l_usua", '=', $c_usua],
            ])
            ->update(["f_ingr" => date('Y-m-d\TH:i:s')]);
            
            //permisos
            $modulos = [];
            $modulos["empresa"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["sucursal"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["usuarios"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["ubicacion"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["mesas"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["mozos"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["lineas"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["productos"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["report-ventas"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["report-ventas-mozos"] = in_array((int)$usuario["c_role"],[1]) ? 1 : 0;
            $modulos["pedidos"] = in_array((int)$usuario["c_role"],[1,3]) ? 1 : 0;
            $modulos["ventas"] = in_array((int)$usuario["c_role"],[1,2]) ? 1 : 0;
            $modulos["clientes"] = in_array((int)$usuario["c_role"],[1,2]) ? 1 : 0;

            $empresa = DB::table("empresa")
                        ->select(DB::raw("n_ruc, l_empr, l_logo, l_dire, n_celu"))
                        ->get();
            
            $tipocamb = TipoCamb::tipocamb();
            
            session([
                "usuario" => (array)$usuario,
                "empresa" => (array)$empresa[0],
                "tipocamb" => (array)$tipocamb,
                "modulos" => (array)$modulos,
                "login" => true
            ]);

            return [
                "usuario" => $usuario,
                "empresa" => $empresa,
            ];

        } catch (\Exception $e) {
            return response()->json(['errors' => ['c_usua' => [$e->getMessage()]]], 422);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
