<?php
namespace App\Http\Middleware\CustomMiddleware;

use Auth;
use Closure;
use App\User;

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
        if (!Auth::check()) goto nextMD;
        $user = new User;
        $user->email = Auth::user()->email;
        $user->picture = $request->session()->get('account')->picture;
        $user->id_student = Auth::user()->profile->student->id_student;
        $user->id_class = Auth::user()->profile->student->id_class;
        $user->position = Auth::user()->profile->student->id_position;
        $request->session()->put('account', $user);
        return $next($request);
        nextMD: 
        $request->session()->put('nextRequest', \url()->full());
        return \redirect()->route('logout');
    }
}
