<?php

namespace App\Http\Resources;

use App\Click;
use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;
use PragmaRX\Tracker\Tracker;
use PragmaRX\Tracker\Vendor\Laravel\Models\Session;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $result = [];

        $obj = $this->resource;
        $result = $this->resource->toArray();
        $result['total_clicks'] = [];
        $clicks = $obj->clicks->groupBy(function($data) {
            return Carbon::parse($data->created_at)->format('d.m.Y');
        })->map(function($item) {
            return $item->count();
        });

        $result['total_clicks'] = ['labels' => $clicks->keys()->toArray(), 'datasets' => [['label' => $obj->title, 'type' => 'line', 'borderColor' => $obj->color_hex, 'backgroundColor' => $obj->color_hex, 'data' => $clicks->values()->toArray(), 'fill' => false]]];
        $result['info'] = [];
        $result['info'][] = ['mode' => 'span', 'label' => 'Daily statistics', 'html' => false, 'children' => []];
        foreach (['today', 'yesterday', 'selected_period'] as $mode)
            $result['info'][0]['children'][] = $this->call($mode, $obj);

        $result['info'][] = ['mode' => 'span', 'label' => 'Statistics by country', 'html' => false, 'children' => []];
        foreach ($this->call('country', $obj) as $c_name => $c_num)
            $result['info'][1]['children'][] = $this->convertor($c_name, $c_num);

        $result['info'][] = ['mode' => 'span', 'label' => 'Statistics by devices', 'html' => false, 'children' => []];
        foreach ($this->call('devices', $obj) as $d_name => $d_num)
            $result['info'][2]['children'][] = $this->convertor($d_name, $d_num);


        $result['info'][] = ['mode' => 'span', 'label' => 'Statistics by agents', 'html' => false, 'children' => []];
        foreach ($this->call('agents', $obj) as $a_name => $a_num)
            $result['info'][3]['children'][] = $this->convertor($a_name, $a_num);


        /*foreach (['country'] as $mode)
            $result['info'][1]['children'][] = $this->call($mode, $obj);*/


        $this->resource = collect($result);

        //dd($this->resource);

        return parent::toArray($request);
    }

    public function callAgents($obj)
    {
        $result_agent = [];

        foreach ($obj->clicks as $click){
            $uuid = $click->uuid;
            if(!isset($this->sessions[$uuid]['agent'])) continue;
            $agent = $this->sessions[$uuid]['agent'];
            if(isset($result_agent[$agent->browser])) $result_agent[$agent->browser]++; else $result_agent[$agent->browser] = 1;
        }

        return $result_agent;

        /*dd($this->sessions);
        return [];*/
    }

    public function callDevices($obj)
    {
        $result_devices = [];

        foreach ($obj->clicks as $click){
            $uuid = $click->uuid;
            if(!isset($this->sessions[$uuid]['device'])) continue;
            $device = $this->sessions[$uuid]['device'];
            if(isset($result_devices[$device->platform])) $result_devices[$device->platform]++; else $result_devices[$device->platform] = 1;
        }

        return $result_devices;
    }

    public function callCountry($obj)
    {
        $result = $obj->clicks->map(function ($item) { return $item->id; })->unique()->toArray();
        $clicks = Click::whereIn('id', $result)->get()->map(function ($item) { return $item->uuid; })->unique()->toArray();
        $this->sessions = Session::with(['geoIp', 'log', 'device', 'agent'])->whereIn('uuid', $clicks)->get()->map(function ($item) {
            return [$item->uuid => ['geo' => $item->geoIp, 'log' => $item->log, 'device' => $item->device, 'agent' => $item->agent]];
        })->values()->toArray();

        foreach ($this->sessions as $key => $value){
            foreach ($value as $k => $v) $this->sessions[$k] = $v;
            unset($this->sessions[$key]);
        }

        $result_county = [];

        foreach ($obj->clicks as $click){
            $uuid = $click->uuid;
            if(!isset($this->sessions[$uuid]['geo'])) continue;
            $geo = $this->sessions[$uuid]['geo'];
            if(isset($result_county[$geo->country_name])) $result_county[$geo->country_name]++; else $result_county[$geo->country_name] = 1;
        }

        return $result_county;
    }

    public function callSelectedPeriod($obj)
    {
        $clicks = $obj->clicks->count();

        return $this->convertor('Clicks for select period', $clicks);
    }

    public function call30days($obj)
    {
        $day30 = now()->subDays(30)->startOfDay();
        $now = now()->endOfDay();

        $clicks = $obj->clicks->where('created_at', '>', $day30)->where('created_at', '<', $now)->count();

        return $this->convertor('Clicks in the last 30 days', $clicks);
    }

    public function callYesterday($obj)
    {
        $clicks = $obj->clicks->groupBy(function($data) {
            return Carbon::parse($data->created_at)->format('d.m.Y');
        })->map(function($item) {
            return $item->count();
        });
        $yesterday = now()->subDay()->format('d.m.Y');
        return $this->convertor('Clicks for yesterday', isset($clicks[$yesterday]) ? $clicks[$yesterday] : 0);
    }

    public function callToday($obj)
    {
        $clicks = $obj->clicks->groupBy(function($data) {
            return Carbon::parse($data->created_at)->format('d.m.Y');
        })->map(function($item) {
            return $item->count();
        });
        $today = date('d.m.Y');
        return $this->convertor('Clicks for today', isset($clicks[$today]) ? $clicks[$today] : 0);
    }

    public function convertor($name = '', $value = '')
    {
        return ['name' => $name, 'value' => $value];
    }

    /**
     * Caller for inner functions
     *
     * @param $method
     * @param $parameters
     * @param bool $throw
     * @return mixed
     * @throws \Exception
     */
    public function call($method, $parameters, $throw=true)
    {
        $method = camel_case("call_{$method}");

        if (method_exists($this, $method)) {
            return call_user_func([$this, $method], $parameters);
        }

        if($throw) throw new \Exception("Method [$method] does not exist.");
        else return $parameters;
    }
}
