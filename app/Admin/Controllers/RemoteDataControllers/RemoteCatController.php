<?php
namespace App\Admin\Controllers\RemoteDataControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RemoteCatController extends Controller{

    public function get(Request $request)
    {
        $category = \App\Models\CategoriesFF::where('category_id', $request->q)->get();
        if(!$category) return response([]);
        else return response($category->pluck('title', 'id'));
    }

}