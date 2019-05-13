<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(!\Auth::user()->moderator_id) abort(404);
        return view('user');
    }
}
