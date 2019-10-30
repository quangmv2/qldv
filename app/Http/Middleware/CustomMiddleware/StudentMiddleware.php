<?php

namespace App\Http\Middleware\CustomMiddleware;

use Closure;

class StudentMiddleware
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
        $student = $request->session()->get('account');
        if (empty($student)) goto nextMD;
        if ($student->hd != 'sict.udn.vn') goto nextMD;
        return $next($request);
        nextMD: 
        $request->session()->put('nextRequest', \url()->full());
        return \redirect()->route('logout');
    }
}
