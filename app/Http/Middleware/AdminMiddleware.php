<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
        if (!Auth::check()) goto nextMD;
        if (Auth::user()->email != 'mvquang.18it5@sict.udn.vn') goto nextMD;
        return $next($request);
        nextMD: 
        $request->session()->put('nextRequest', \url()->full());
        return \abort(404);
        // return $next($request);
    }
}
