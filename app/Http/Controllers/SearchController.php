<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->q || !$request->ajax()) return response(['status' => 'error'], 500);
        $q = $request->q;
        $products = \App\Models\Products::where('active', 1)->where('title', 'LIKE', '%'.$q.'%')->get();
        $products_news = \App\Models\ProductNews::where('active', 1)->where('title', 'LIKE', '%'.$q.'%')->get();
        $response_products = [];
        foreach (collect($products)->take(6) as $p){
            $response_products[] = [
                'logo' => asset($p->logo),
                'url' => route('product', ['product' => $p->slug]),
                'title' => $p->title
            ];
        }
        $response_products_news = [];
        foreach (collect($products_news)->take(6) as $new){
            $response_products_news[] = [
                'logo' => asset($new->product->logo),
                'url' => route('product.new', ['product' => $new->product->slug,'product_new' => $new->id]),
                'title' => $new->title
            ];
        }

        $response_categories = [];
        $categories = Categories::where('active', 1)->where('title', 'LIKE', '%'.$q.'%')->get();
        foreach ($categories as $cat){
            $response_categories[] = [
                'id' => $cat->id,
                'logo' => $cat->img,
                'url' => route('category', ['categories' => $cat->slug]),
                'title' => $cat->title
            ];
        }



        return response(['products' => $response_products, 'categories' => $response_categories, 'news' => $response_products_news]);

        $categories = [];
        foreach($products as $prod){
            foreach ($prod->categories as $cat) $categories[$cat] = isset($categories[$cat]) ? $categories[$cat]+1 : 0;
        }
        asort($categories);
        $cat_ids = array_keys($categories);
        $cats = collect(\App\Models\Categories::whereIn('id', $cat_ids)->get());
        $cats_types = [];
        foreach ($cats as $key=>$val) {
            $cats[$key]['sort'] = $categories[$val->id];
            $cats_types[$val->type][] = $cats[$key];
        }
        foreach ($cats_types as $key=>$val){
            $cats_types[$key] = collect($cats_types[$key])->sortByDesc('sort')->take(8)->all();
            $count = count($cats_types[$key]);
            $cats_types[$key]['sort'] = 0;
            foreach ($cats_types[$key] as $s){ $cats_types[$key]['sort']+=$s['sort']; }
            $cats_types[$key]['sort'] = $cats_types[$key]['sort']/$count;
        }
        $cats_types = collect($cats_types)->sortByDesc('sort')->all();
        $types = collect(\App\Models\CategoryType::whereIn('id', array_keys($cats_types))->get());
        foreach ($cats_types as $key=>$val) unset($cats_types[$key]['sort']);
        $response = [];
        foreach ($cats_types as $type => $cat_collect){
            $type = $types->where('id', $type)->first();
            $response[] = [
                'title' => $type->title,
                'icon' => asset('uploads/'.$type->logo),
                'data' => collect($cat_collect)->map(function($item, $key) use ($request){
                    return [
                        'id' => $item['id'],
                        'logo' => $item['img'],
                        'url' => route('category', ['categories' => $item['slug'], 'q' => $request->q]),
                        'title' => $item['title']
                    ];
                })->toArray()
            ];
        }

        return response(['products' => $response_products, 'categories' => $response, 'news' => $response_products_news]);
        //dd($response);
    }

    public function product(Request $request)
    {
        $q = $request->term ? $request->term : '';
        $page = $request->page ? $request->page : 1;
        $resultCount = 25;

        $offset = ($page - 1) * $resultCount;

        $products = Products::where("title", "like", "%{$q}%");

        if(isset(\Auth::user()->id)){
            $products = $products->whereNotIn('id', \Auth::user()->reviews->pluck('product_id'));
        }

        $count = $products->get()->count();

        $products = $products->orderBy('title')->skip($offset)->take($resultCount)
                                ->get(['id', DB::raw('title as text'), 'logo']);

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        $results = [
            "results" => $products,
            "pagination" => [
                "more" => $morePages
            ]
        ];

        return response()->json($results);
    }
}


































