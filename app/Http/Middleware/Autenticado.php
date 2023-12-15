<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Autenticado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!session('login')) {
            if ($request->ajax()){
                return response('Unauthorized.', 401);
            }
            return redirect('/acceso');
        }
        // La validacion se hace con l_usua porque en mantenimiento de usuario de usa Usuario y puede surgir conflictos
        if ($request->ajax() && $request->usuario!=session("usuario")["l_usua"]) {
            // Validamos si se ha cambiado de sesion con otro usuario
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
