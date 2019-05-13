<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class ProductsResource extends ResourceCollection
{
    public $with = ['status' => 'success'];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //if(!request()->selected || count(explode('.', request()->selected)) != 3) return response(['status' => 'error', 'message' => 'no data selected']);

        $between = \GuzzleHttp\json_decode(request()->between);
        $start = $start_between = Carbon::parse($between->start)->startOfDay();
        $end = $end_between = Carbon::parse($between->end)->endOfDay();

        //$start = Carbon::parse(request()->selected)->startOfDay();
        //$end = Carbon::parse(request()->selected)->endOfDay();

        $result = [];
        foreach ($this->collection as $key => $data){
            $obj = $this->collection[$key];
            $result[$key] = $this->collection[$key]->toArray();
            $result[$key]['hours_clicks'] = [];

            $clicks = $obj->clicks->where('created_at', '>=', $start)->where('created_at', '<=', $end)->groupBy(function($data) {
                return Carbon::parse($data->created_at)->format('H');
            })->map(function($item) {
                return $item->count();
            })->toArray();

            for ($h=1; $h <= 24; $h++){
                $original_h = $h;
                $h = $h <= 9 ? "0{$h}" : $h;
                $result[$key]['hours_clicks'][$original_h] = isset($clicks[$h]) ? $clicks[$h] : 0;
            }
            $result[$key]['hours_clicks'] = array_values($result[$key]['hours_clicks']);
            $result[$key]['total'] = $obj->clicks->count();
            $result[$key]['total_sum'] = number_format($obj->clicks->sum('amount'), 2, ',', ' ');

            $result[$key]['select_period'] = $obj->clicks->where('created_at', '>=', $start_between)->where('created_at', '<=', $end_between)->count();
            $result[$key]['select_period_sum'] = number_format($obj->clicks->where('created_at', '>=', $start_between)->where('created_at', '<=', $end_between)->sum('amount'), 2, ',', ' ');
            $this->collection[$key] = collect($result[$key]);
            //dd($result);
        }
        //dd($this->collection, $between);
        //$this->collection = $result;

        return parent::toArray($result);
    }
}