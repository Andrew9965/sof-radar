<?php

namespace App\Http\Controllers\Api;

use App\Click;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Reviews;
use App\Transactions;
use Carbon\Carbon;
use Help\ArrayClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use Illuminate\Support\Facades\DB;
use Lia\Facades\Admin;

class ProfileController extends Controller
{

    public function get_date_statistic(Request $request)
    {
        if(!$request->between) return response(['status' => 'error', 'message' => 'no date selected']);

        $between = \GuzzleHttp\json_decode(request()->between);
        $start = $start_between = Carbon::parse($between->start)->startOfDay();
        $end = $end_between = Carbon::parse($between->end)->endOfDay();

        if($request->user_id && isset(Admin::user()->id)) $u_id = $request->user_id;
        else $u_id = \Auth::user()->id;

        $product_ids = Click::where('user_id', $u_id)->whereBetween('created_at', [$start, $end])->get()->groupBy('product_id')->keys();

        return new ProductsResource(Products::with(['clicks' => function ($query) use ($start, $end) {
            //$query->whereBetween('created_at', [$start, $end]);
        }])->whereIn('id', $product_ids)->get(['id', 'title', 'slug']));
    }

    public function get_new_statistic(Request $request)
    {
        $clicks = Click::chart()->set(['title' => '', 'autoswitch_headers' => false])->group()->convert();
        return response($clicks);
    }

    public function file_uploader(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);

        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $all_ext = implode(',', ['jpg', 'jpeg', 'png', 'gif']);

        $this->validate($request, [
            $request->name ? $request->name : 'file' => 'required|file|mimes:' . $all_ext . '|max:' . $max_size
        ]);

        $logo = request()->file($request->name ? $request->name : 'file');
        $path = '/storage/'.$logo->store('uploads', 'public');
        return $path;
    }

    public function save_profile(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        if(\Auth::user()->update($request->all())) return response(['status' => 'success', 'message' => 'Your profile has been successfully updated!'], 200);
        else return response(['status' => 'error', 'message' => 'Something went wrong!'], 400);
    }

    public function get_reviews(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        $reviews = Reviews::with(['user', 'product'])->whereHas('product')->where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->paginate(6);
        return response()->json($reviews);
    }

    public function save_review(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        $review = Reviews::find($request->id);
        if(!$review) return response(['status' => 'error', 'message' => 'not found!'], 400);
        if($review->update($request->all())) return response(['status' => 'success', 'message' => 'saved!'], 200);
        else return response(['status' => 'error', 'message' => 'error'], 400);
    }

    public function get_products(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        $products = Products::with(['category_1', 'category_2', 'category_3', 'reviews'])->where('author_id', \Auth::user()->id)->paginate(6);
        return response()->json($products);
    }

    public function get_categories(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        $q = $request->term ? $request->term : '';
        $page = $request->page ? $request->page : 1;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $categories = Categories::where("title", "like", "%{$q}%");

        $count = $categories->get()->count();

        $categories = $categories->where('active', 1)->orderBy('title')->skip($offset)->take($resultCount)
            ->get(['id', DB::raw('title as text'), 'img']);

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        return response()->json([
            "results" => [['id' => 0, 'text' => 'None']]+$categories->toArray(),
            "all" => ArrayClass::convert(Categories::with('categories_ff')->where('active', 1)->get()),
            "pagination" => [
                "more" => $morePages
            ]
        ]);
    }

    public function get_product(Request $request)
    {
        if($request->user_id && isset(Admin::user()->id)) $u_id = $request->user_id;
        else $u_id = \Auth::user()->id;

        if(!$u_id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        $model = Products::with('clicks')->where('slug', $request->slug)->where('author_id', $u_id)->first();
        if(!$model) return response(['status' => 'error', 'message' => 'Product not found!'], 400);
        return !$request->resource ? response($model, 200) : new ProductResource($model);
    }

    public function save_product(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        if(!\Auth::user()->moderator_id) return response(['status' => 'error', 'message' => 'You need a moderator!'], 400);
        $r = $request->all();
        $r['active'] = 0;
        $r['author_id'] = \Auth::user()->id;
        $r['categories'] = [];
        if($r['category_1']!='0') $r['categories'][1] = $r['category_1'];
        if($r['category_2']!='0') $r['categories'][2] = $r['category_2'];
        if($r['category_3']!='0') $r['categories'][3] = $r['category_3'];
        $r['deployment'] = $r['details']['deployment'];
        $r['desc_client'] = $r['details']['desc_client'];
        $r['business_size'] = $r['details']['business_size'];
        $r['mobile_version'] = $r['details']['mobile_version'];

        $r['pricing_starting_price'] = $r['pricing']['starting_price']['price'];
        $r['pricing_starting_price_onsubmit'] = $r['pricing']['starting_price']['onsubmit'];
        $r['pricing_starting_price_link'] = $r['pricing']['starting_price']['link'];
        $r['pricing_pricing_model'] = $r['pricing']['pricing_model'];
        $r['pricing_training'] = $r['pricing']['training'];
        $r['pricing_license_price'] = $r['pricing']['license_price']['price'];
        $r['pricing_license_price_onsubmit'] = $r['pricing']['license_price']['onsubmit'];
        $r['pricing_license_price_link'] = $r['pricing']['license_price']['link'];
        $r['pricing_free_trial_active'] = $r['pricing']['free_trial']['active'];
        $r['pricing_free_trial_link'] = $r['pricing']['free_trial']['link'];

        if($request->_id){
            $model = Products::where('id', $request->_id)->where('author_id', \Auth::user()->id)->first();
            if(!$model) return response(['status' => 'error', 'message' => 'Product not found!'], 400);
            if($model->update($r)) return response(['status' => 'success', 'message' => 'Your product has been edited and is awaiting moderation!'], 200);
        }else{
            $r['user_id'] = \Auth::user()->moderator_id;
            $r['slug'] = str_slug($r['title']);
            $model = new Products();
            if($model->create($r)) return response(['status' => 'success', 'message' => 'Your product is created and is waiting for moderation!'], 200);
        }
    }

    public function get_transaction($id, Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        if(!\Auth::user()->moderator_id) return response(['status' => 'error', 'message' => 'You need a moderator!'], 400);
        $tr = Transactions::where('id', $id)->where('user_id', \Auth::user()->id)->first();
        if(!$tr) return response(['status' => 'error', 'message' => 'Transaction not found!'], 400);
        return response($tr->toArray(), 200);
    }

    public function get_transactions(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error', 'message' => 'You no auth!'], 400);
        if(!\Auth::user()->moderator_id) return response(['status' => 'error', 'message' => 'You need a moderator!'], 400);
        $tr = Transactions::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->paginate(12);
        return response()->json($tr);
    }

}
