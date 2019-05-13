<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Pages $page, Request $request)
    {
        return view('page', [
            'page' => $page
        ]);
    }


}
