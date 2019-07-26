<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use abort;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('user'))
        {
            return $next($request);
        }
        abort(404);
        \Log::error('Pokusaj upada preko ' . $request->get()->ip() . ' adrese');
    }
}
