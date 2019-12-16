<?php

namespace App\Http\Middleware\CustomMiddleware;

use Closure;
use Auth;

class PositionMiddleware
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
        $position =  Auth::user()->profile->student->id_position;
        if ($position <= 5)
        return $next($request);
        return \abort(404);
    }
}
