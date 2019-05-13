<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\RelatedLinks;
use Illuminate\Http\Request;

class RelatedController extends Controller
{
    public function index(RelatedLinks $relatedLinks, Request $request)
    {
        if(!$relatedLinks->active) abort(404);

        $products = Products::whereIn('id', $relatedLinks->products->pluck('p_id'))->where('active',1);

        (new CategoryController())->sorter($products, $request);

        $products = $products->where('active', 1)->orderBy('review_rait_total', 'desc')
            ->paginate(8)->setPath(route('relate', array_merge(['relate' => $relatedLinks->slug], (count($request->all()) ? $request->all() : [])) ));

        //dd($products);

        return view('related', [
            'category' => $relatedLinks,
            'products' => $products,
        ]);
    }
}
