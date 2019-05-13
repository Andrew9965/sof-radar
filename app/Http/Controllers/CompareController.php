<?php

namespace App\Http\Controllers;

use App\Models\Compares;
use App\Models\Products;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Compares $compare, Request $request)
    {
        return view('compare', [
            'compare' => $compare,
            'left' => $compare->left,
            'right' => $compare->right
        ]);
    }

    public function newCompare($left, $right, Request $request)
    {
        if(!$left = Products::find($left)) abort(404);
        if(!$right = Products::find($right)) abort(404);
        $compare = Compares::create([
            'user_id' => \Auth::guest() ? 0 : \Auth::user()->id,
            'slug' => $slug = str_slug($left->id.'-'.$left->title.'-'.$right->id.'-'.$right->title),
            'category_id' => $left->categories[1],
            'product_left_id' => $left->id,
            'product_right_id' => $right->id
        ]);
        return redirect()->route('compare', ['compare' => $slug]);
    }
}
