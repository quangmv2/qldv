<?php

namespace App\Http\Middleware;

use Closure;

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
        // $student = $request->session()->get('account');
        // if (empty($student)) goto nextMD;
        // if ($student->email != 'mvquang.18it5@sict.udn.vn') goto nextMD;
        // return $next($request);
        // nextMD: 
        // $request->session()->put('nextRequest', \url()->full());
        // return \redirect()->route('logout');
        return $next($request);
    }
}
