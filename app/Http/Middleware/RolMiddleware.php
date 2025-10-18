<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::guard('usuario')->user();

        if(!$user){
            return redirect('/');
        }

        if(!in_array($user->rol, $roles)){
            return abort(403,'No autorizado');
        }

        return $next($request);
    }
}
