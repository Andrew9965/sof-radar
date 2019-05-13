<?php

namespace App\Admin\Controllers;

use App\Http\Resources\ProductResource;
use App\Click;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lia\Controllers\ModelForm;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use Lia\Layout\Column;
use Lia\Layout\Row;
use Lia\Widgets\Box;
use App\Http\Resources\ProductsResource;
use Carbon\Carbon;
use App\Models\Products;

class DashBoardController extends Controller
{
    use ModelForm;

    public function index(Request $request)
    {
        Admin::script(['vue' => ['admin_dashboard']]);
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row($this->day_graphs());
            $content->row($this->table());
        });
    }

    public function get_product(Request $request)
    {
        if(!$request->date) return response(['status' => 'error', 'message' => 'no date selected']);

        $between = \GuzzleHttp\json_decode(request()->date);
        $start = $start_between = Carbon::parse($between->start)->startOfDay();
        $end = $end_between = Carbon::parse($between->end)->endOfDay();

        $model = Products::with(['clicks' => function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }])->where('slug', $request->slug)->first();
        if(!$model) return response(['status' => 'error', 'message' => 'Product not found!'], 400);
        return !$request->resource ? response($model, 200) : new ProductResource($model);
    }

    public function get_new_statistic(Request $request)
    {
        $clicks = Click::chart()->set(['title' => '', 'model_filter' => false, 'autoswitch_headers' => false])->group()->convert();
        return response($clicks);
    }

    public function get_date_statistic(Request $request)
    {
        if(!$request->between) return response(['status' => 'error', 'message' => 'no date selected']);

        $between = \GuzzleHttp\json_decode(request()->between);
        $start = $start_between = Carbon::parse($between->start)->startOfDay();
        $end = $end_between = Carbon::parse($between->end)->endOfDay();

        $product_ids = Click::whereBetween('created_at', [$start, $end])->get()->groupBy('product_id')->keys();

        return new ProductsResource(Products::with(['clicks' => function ($query) use ($start, $end) {
            //$query->whereBetween('created_at', [$start, $end]);
        }])->whereIn('id', $product_ids)->get(['id', 'title', 'slug']));
    }

    private function table() {
        $box = new Box(vue('day-table-title', ['ref' => 'table_title'], "Statistics on products"), vue('day-table', ['ref' => 'table']));
        $box->style('primary');
        return $box;
    }

    private function day_graphs()
    {
        $start = now()->format('d.m.Y');
        $end = now()->subDays(30)->format('d.m.Y');
        $box = new Box("Statistics by date", vue('day-graphs', ['ref' => 'graph']));
        $box->style('info');
        $box->addTool(vue('range-calendar', ['ref' => 'range_calendar'], '<a class="btn btn-sm btn-success"><i class="fa fa-calendar"></i> From '.$start.' through '.$end.'</a>'));
        return $box;
    }
}
