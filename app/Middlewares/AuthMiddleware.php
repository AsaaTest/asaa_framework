<?php

namespace App\Middlewares;

use Closure;
use Asaa\Auth\Auth;
use Asaa\Http\Middleware;
use Asaa\Http\Request;
use Asaa\Http\Response;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::isGuest()){
            return redirect('/login');
        }

        return $next($request);
    }
}
