<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\ProductNews;
use App\Models\Products;

class NewsController extends Controller
{
    public function index(Products $product, Request $request)
    {
        $news = \App\Models\ProductNews::where('active', 1)->orderBy('created_at', 'desc');
        if($product->id) $news->where('product_id', $product->id);
        $news = $news->paginate(8);
//        dd($news);
        return view('news', [
            'product' => $product,
            'news' => $news
        ]);
    }

    public function category_news(Categories $categories, Request $request)
    {
        $product = new Products();
        $products = Products::where('category_1', $categories->id)->get()->pluck('id');

        $news = \App\Models\ProductNews::where('active', 1)->whereIn('product_id', $products)->orderBy('created_at', 'desc');
        //if($product->id) $news->where('product_id', $product->id);
        $news = $news->paginate(8);

        return view('news', [
            'product' => $product,
            'category' => $categories,
            'news' => $news
        ]);
    }

    public function view(Products $product, ProductNews $productNew, Request $request)
    {

        return view('news.new', [
            'new' => $productNew,
            'product' => $productNew->product
        ]);
    }
}
