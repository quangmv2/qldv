<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Socialite;
use App\User;

class LoginController extends Controller
{

    protected $redirectTo = '/';

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        $users = Socialite::driver($provider)->stateless()->user();
        $users = (object) $users->user;

        // var_dump($users);
        // return;
        if (!isset($users->hd) || $users->hd != 'sict.udn.vn') return \redirect()->route("logout");
        $acc = User::where("email", $users->email)->get();
        // $k = 0;
        // if (count($acc) < 1) {
        //     $k = createAccountLogin($users);
        //     return;
        // }
        // if (k==0) return \redirect()->route('logout');
        $acc = User::where("email", $users->email)->get();
        if (count($acc) < 1) return \redirect()->route("logout");
        $acc = $acc[0];

        $user = new User;
        $user->email = $users->email;
        $user->name  = $users->name;
        $user->picture = $users->picture;
        $user->hd = $users->hd;
        $user->id_student = $acc->profile->student->id_student;
        $user->id_class = $acc->profile->student->id_class;
        $user->position = $acc->profile->student->id_position;

        $request->session()->put('account', $user);
        if (!empty($request->session()->get('nextRequest'))){
            return redirect($request->session()->get('nextRequest'));
        }
        return redirect($this->redirectTo);
    }

    function logout(Request $request)
    {
        $request->session()->forget('account');
        $request->session()->forget('nextRequest');
        return \redirect()->route('getLogin');
    }
}
