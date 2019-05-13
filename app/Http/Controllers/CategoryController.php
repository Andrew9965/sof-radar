<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Reviews;
use Illuminate\Http\Request;
use App\Models\Categories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;


class CategoryController extends Controller
{
    public function index(Categories $categories, Request $request)
    {
        if(!$categories->active) abort(404);

        $products = \App\Models\Products::where(function($query) use ($categories){
            $query->where('category_1', $categories->id)->orWhere('category_2', $categories->id)->orWhere('category_3', $categories->id);
        });

        $this->sorter($products, $request);

        $products_similar = $products;
        $products = $products->where('active', 1)->orderBy('review_rait_total', 'desc')->get();
            /*->paginate(8)->setPath(route('category', array_merge(['categories' => $categories->slug], (count($request->all()) ? $request->all() : [])) ));*/

        $p1 = $products->where('web_site', '!=', '')->all();
        $p2 = $products->where('web_site', '==', '')->all();

        $products = (new Collection)->merge($p1)->merge($p2);


        $products = $this->paginate(
            $products,
            8,
            $request->page ? $request->page : 1,
            [
                'path' => route('category', array_merge(['categories' => $categories->slug], (count($request->all()) ? $request->all() : [])) )
            ]
        );

        $sCats = [];
        foreach ($products_similar->get() as $p){
            $sCats[$p->category_1] = $p->category_1;
            if($p->category_2) $sCats[$p->category_2] = $p->category_2;
            if($p->category_3) $sCats[$p->category_3] = $p->category_3;
        }

        return view('category', [
            'category' => $categories,
            'products' => $products,
            'sCats' => $sCats
        ]);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function sorter(&$products, $request)
    {
        if($request->q)
            $products->where('title', 'like', "%{$request->q}%");

        if($request->rating)
            $products->where('review_rait_total', '>=', $request->rating);

        if($request->business)
            $products->where(function($query) use ($request){
                foreach ($request->business as $business)
                    $query->where('business_size', 'like', '%' . $business . '%');
            });

        if($request->feature)
            $products->where(function($query) use ($request){
                foreach ($request->feature as $feature)
                    $query->where('features', 'like', '%' . $feature . '%');
            });

        if($request->deployment)
            $products->where(function($query) use ($request){
                foreach ($request->deployment as $deployment)
                    $query->where('deployment', 'like', '%' . $deployment . '%');
            });

        if($request->pricing_free_trial_active)
            $products->where('pricing_free_trial_active', 'on');

        if($request->pricing_license_price_onsubmit)
            $products->where('pricing_license_price_onsubmit', 'on');

        if($request->pricing_starting_price_onsubmit)
            $products->where('pricing_starting_price_onsubmit', 'on');

        if($request->pricing_pricing_model)
            $products->where(function($query) use ($request){
                foreach ($request->pricing_pricing_model as $pricing_pricing_model)
                    $query->where('pricing_pricing_model', 'like', '%' . $pricing_pricing_model . '%');
            });

        if($request->pricing_training)
            $products->where(function($query) use ($request){
                foreach ($request->pricing_training as $pricing_training)
                    $query->where('pricing_training', 'like', '%' . $pricing_training . '%');
            });
    }

    public function ajax_products($product_id, Request $request)
    {
        if(!$product_id) return ['status' => 'null'];
        if(!$request->ajax()) abort(404);
        $product = Products::findOrFail($product_id);
        if(!isset($product->categories[1])) abort(404);
        return response(
            Categories::findOrFail($product->categories[1])
        );
    }

    public function fool_list(Reviews $reviews)
    {
        $categories = \App\Models\Categories::where('active',1)->where('count', '!=', 0)->get()->groupBy('type');

        return view('category_list', [
            'categoriesGroup' => $categories
        ]);
    }
}
