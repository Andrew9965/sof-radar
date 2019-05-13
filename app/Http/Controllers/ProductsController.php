<?php

namespace App\Http\Controllers;

use App\Click;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Compares;
use App\Models\Reviews;
use Illuminate\Database\Eloquent\Collection;
use App\Transactions;

class ProductsController extends Controller
{
    public function index(Products $product, Request $request)
    {
        return view('soft', [
            'product' => $product
        ]);
    }

    public function reviews(Products $product, Request $request)
    {
        return view('soft.review', [
            'product' => $product,
            'ctrl' => $this
        ]);
    }

    public function getColorAttribute($rate)
    {
        if($rate>=0 && $rate<=1.9) return 'red '.$rate;
        if($rate>=2 && $rate<=3.5) return 'orange '.$rate;
        if($rate>=3.6 && $rate<=4) return 'pale_green '.$rate;
        if($rate>=4.1 && $rate<=4.5) return 'green '.$rate;
        if($rate>=4.6 && $rate<=5) return 'dark_green '.$rate;
        return $rate;
    }

    public function review(Products $product, Reviews $review, Request $request)
    {
        $top_soft = \App\Models\Products::where('active', 1)->where('top',1)->orderby('review_rait_total', 'desc')->take(8)->get();
        return view('review', [
            'review' => $review,
            'top_soft' => $top_soft,
            'product' => $product
        ]);
    }

    public function reviews_post(Products $product, Request $request)
    {
        $result = $this->validate($request, [
            'easy_of_use' => 'int|max:5|min:0',
            'functionality' => 'int|max:5|min:0',
            'product_quality' => 'int|max:5|min:0',
            'customer_support' => 'int|max:5|min:0',
            'value_for_money' => 'int|max:5|min:0',
            'headline' => 'required|string|max:200',
            'like_best' => 'required|string|max:1500',
            'like_least' => 'required|string|max:1500',
            'comment' => 'required|string|max:1500',
            'used' => 'required|string|max:200'
        ]);

        $result['user_id'] = \Auth::user()->id;
        $result['product_id'] = $product->id;

        if($request->review_edit){
            $rev = \App\Models\Reviews::where('id', $request->review_edit)->where('user_id', \Auth::user()->id)->first();
            $result['status'] = '2';
            if($rev->update($result)) {
                return redirect()->route('product.reviews', ['product' => $product->slug])->with(['status' => 'success', 'message' => 'Thank you, your review has been submitted for review to the administrator!']);
            }else{
                return back()->with(['status' => 'error', 'message' => 'Unknown error while saving review!']);
            }
        }

        if(\App\Models\Reviews::create($result)) {
            return back()->with(['status' => 'success', 'message' => 'Thank you, your review has been submitted for review to the administrator!']);
        }else{
            return back()->with(['status' => 'error', 'message' => 'Unknown error while saving review!']);
        }
    }

    public function reviews_post_undefined(Request $request)
    {
        $product = Products::find($request->product_id);
        if(!$product) abort(404);
        return $this->reviews_post($product, $request);
    }

    public function already_use(Products $product, Request $request)
    {
        if(!$request->ajax() || is_null($request->ch)) abort(404);
        if(\Auth::guest()) return response(['status' => 'error']);
        if($request->ch=='true') \Auth::user()->uses()->updateOrCreate(['product_id' => $product->id]);
        else \Auth::user()->uses()->where('product_id', $product->id)->first()->delete();
        return response(['status' => 'success', 'reviews' => \Auth::user()->reviews->where('product_id', $product->id)->count()]);
    }

    public function media(Products $product, Request $request)
    {
        return view('soft.media', [
            'product' => $product
        ]);
    }

    public function alternative(Products $product, Request $request)
    {
        $products = Products::where('id', '!=', $product->id)->where(function($query) use ($product){
            $query->orWhere('category_1', $product->categories[1]);
            $query->orWhere('category_2', $product->categories[1]);
            $query->orWhere('category_3', $product->categories[1]);
        });

        $catSort = new CategoryController();
        $catSort->sorter($products, $request);

        $products = $products->orderBy('review_rait_total', 'desc')->get(); //->paginate(6);

        $p1 = $products->where('web_site', '!=', '')->all();
        $p2 = $products->where('web_site', '==', '')->all();

        $products = (new Collection)->merge($p1)->merge($p2);

        $products = $catSort->paginate($products, 8);

        return view('soft.alternative', [
            'product' => $product,
            'products' => $products
        ]);
    }

    public function compare(Products $product, Request $request)
    {
        $compare = Compares::where(function($query) use ( $product ){
            $query->orWhere('product_left_id', $product->id);
            $query->orWhere('product_right_id', $product->id);
        })->get();


        $ids = $compare->where('product_left_id', '!=', $product->id)->pluck('product_left_id', 'product_left_id')->toArray()
            +
            $compare->where('product_right_id', '!=', $product->id)->pluck('product_right_id', 'product_right_id')->toArray();

        /*$products = Products::whereIn('id', $ids);

        $catSort = new CategoryController();
        $catSort->sorter($products, $request);

        $products = $products->orderBy('review_rait_total', 'desc')->paginate(6);*/

        $products = Products::where('id', '!=', $product->id)->where(function($query) use ($product){
            $query->orWhere('category_1', $product->categories[1]);
            $query->orWhere('category_2', $product->categories[1]);
            $query->orWhere('category_3', $product->categories[1]);
        });

        $catSort = new CategoryController();
        $catSort->sorter($products, $request);

        $products = $products->orderBy('review_rait_total', 'desc')->get(); //->paginate(6);

        $p1 = $products->where('web_site', '!=', '')->all();
        $p2 = $products->where('web_site', '==', '')->all();

        $products = (new Collection)->merge($p1)->merge($p2);

        $r = $request->all();
        if(isset($r['page'])) unset($r['page']);
        $r['product'] = $product->slug;

        $products = $catSort->paginate($products, 8, $request->page ? $request->page : 1, [
            'path' => route('product.compare', $r)
        ]);

        return view('soft.compare', [
            'product' => $product,
            'products' => $products,
            'compares' => collect($compare)
        ]);
    }

    public function top(Request $request)
    {
        $products = \App\Models\Products::where('active',1)->whereHas('category1')->orderBy('review_rait_total','desc')->paginate();

        return view('top_soft', [
            'products' => $products
        ]);
    }

    public function link($product_id, Request $request)
    {

        if(app('Illuminate\Routing\UrlGenerator')->previous() == app('Illuminate\Routing\UrlGenerator')->current()) abort(404);

        $product = Products::find($product_id);
        if(!$product) $product = Products::where('slug', $product_id)->first();
        if(!$product) abort(404);


        if($request->source && !isset($product->pricing[$request->source]['link'])) abort(404);
        $link = $request->source ? $product->pricing[$request->source]['link'] : $product->web_site;
        if(!$product->is_web_click) abort(404);

        $visitor = \Tracker::currentSession();
        if($visitor->is_robot != '0') abort(404);

        $transaction = Transactions::create([
            'amount' => -$product->author->click_cost,
            'user_id' => $product->author->id,
            'status' => Transactions::STATUS_SUCCESS,
            'type' => Transactions::TYPE_AD,
            'hash' => -$product->author->click_cost
        ]);

        Click::create([
            'uuid' => $visitor->uuid,
            'user_id' => $product->author->id,
            'product_id' => $product->id,
            'transaction_id' => $transaction->id,
            'amount' => $product->author->click_cost
        ]);

        $product->link_clicked += 1;
        $product->save();
        return redirect((strrpos($link, "http")===false ? "http://" : "").$link.(strrpos($link, "?")===false ? "?" : "&")."utm_source=softradar");
    }

    public function compare_item(Products $product, Request $request)
    {
        if(!session('compare_left')){
            session(['compare_left' => $product]);
            admin_toastr('Product "'.$product->title.'" added! Select the next product!');
            return back();
        }

        $left = (object)session('compare_left');
        $cat = array_first(array_diff($left->categories, array_diff($left->categories, $product->categories)));
        if(!$cat){
            session(['compare_left' => $product]);
            admin_toastr('Product "'.$product->title.'" added! Select the next product!');
            return back();
        }
        if($left->id == $product->id){
            admin_toastr('You must choose a different product!', 'error');
            return back();
        }
        $test = Compares::where('product_left_id', $left->id)->where('product_right_id', $product->id)->first();
        if(!$test){
            $test = Compares::create([
                'user_id' => \Auth::guest() ? 0 : \Auth::user()->id,
                'slug' => $slug = str_slug($left->id.'-'.$left->title.'-'.$product->id.'-'.$product->title),
                'category_id' => $cat,
                'product_left_id' => $left->id,
                'product_right_id' => $product->id
            ]);
        }
        session(['compare_left' => null]);
        return redirect()->route('compare', ['compare' => $test->slug ? $test->slug : $slug]);
    }

    public function reviews_like(Reviews $review, Request $request)
    {
        $method = $request->get('method');
        if($method=='up') $review->like += 1;
        else $review->dislike += 1;
        $review->save();
        return 'ok';
    }

    public function reviews_post_edit(Reviews $review, Request $request)
    {
        $request->session()->flash('edit', $review);
        return redirect()->route('product.review', ['product' => $review->product->slug, 'review' => $review->id]);
    }

}
