<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use abort;

class AdminMiddleware
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
            $korisnik = $request->session()->get('user')[0];
            if($korisnik->username == 'admin')
            {
                return $next($request);
            }
            abort(404);
        }
        abort(404);
        \Log::error('Pokusaj upada preko ' . $request->get()->ip() . ' adrese');
    }
}
