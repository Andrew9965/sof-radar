<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class GoogleController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->flash('referer_auth', $request->headers->get('referer'));
        if(count($request->all())) $request->session()->flash('params_after_auth', \GuzzleHttp\json_encode($request->all()));
        return Socialite::with('google')->redirect();
    }

    public function cb(Request $request)
    {
        $userData = Socialite::driver('google')->user();
        $user = \App\User::findByUsernameOrCreate(collect($userData)->toArray());
        \Auth::login($user, true);
        $ref = session('referer_auth');
        $save = session('params_after_auth');
        $request->session()->flash('params_after_auth', $save);
        if($ref)
            return redirect($ref);
        else
            return redirect()->route('cabinet');
    }
}
