<?php

namespace App\Console\Commands;

use App\Models\Categories;
use App\Models\Products;
use App\Models\RelatedLinks;
use Illuminate\Console\Command;

class FilterFind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:find {group?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Автоматическая подборка фильтров для категорий';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        if($this->argument('group')) $this->info('Group: '.$this->argument('group'));

        if(!$this->argument('group') || $this->argument('group')=='Categories') {
            $this->info('Starting categories..');
            $categories = Categories::where('active', 1)->where('filter_auto', 1)->get();
            foreach ($categories as $cat) {
                if(is_null($cat->filter)) $cat->filter = ["user_review"=>0, "business_size"=>0, "features"=>0, "deployment"=>0, "desktop_client"=>0, "mobile_version"=>0, "price"=>0];
                foreach ($cat->filter as $filter => $status) {
                    if (method_exists(__CLASS__, $filter)) {

                        $products = \Help\ArrayClass::convert(array_collapse(collect()
                            ->push(\Help\ArrayClass::convert($cat->prods_1)->toArray())
                            ->push(\Help\ArrayClass::convert($cat->prods_2)->toArray())
                            ->push(\Help\ArrayClass::convert($cat->prods_3)->toArray())));

                        $result = $this->{$filter}($cat, $products);
                        if ($status != $result || $cat->filter_cfg != $result['cfg']) {
                            $f = $cat->filter;
                            $f[$filter] = $result['status'];
                            $cfg = $cat->filter_cfg ? $cat->filter_cfg : [];
                            $cfg[$filter] = $result['cfg'];
                            $cat->filter = $f;
                            $cat->filter_cfg = $cfg;
                            $cat->save();
                        }
                    }
                }
                $this->info('Save: ' . $cat->id);
            }
        }

        if(!$this->argument('group') || $this->argument('group')=='Links') {
            $this->info('Starting links..');
            $categories = RelatedLinks::where('active', 1)->where('filter_auto', 1)->get();
            foreach ($categories as $cat) {
                foreach ($cat->filter as $filter => $status) {
                    if (method_exists(__CLASS__, $filter)) {
                        $products = \Help\ArrayClass::convert(Products::whereIn('id', $cat->products->pluck('p_id', 'p_id')->toArray())->get());
                        $result = $this->{$filter}($cat, $products);
                        if ($status != $result || $cat->filter_cfg != $result['cfg']) {
                            $f = $cat->filter;
                            $f[$filter] = $result['status'];
                            $cfg = $cat->filter_cfg ? $cat->filter_cfg : [];
                            $cfg[$filter] = $result['cfg'];
                            $cat->filter = $f;
                            $cat->filter_cfg = $cfg;
                            $cat->save();
                        }
                    }
                }
                $this->info('Save: ' . $cat->id);
            }
        }
    }

    public function user_review($cat, $products){

        $products = $products
            ->sortByDesc('review_rait_total')
            ->pluck('review_rait_total', 'review_rait_total')
            ->toArray();

        $max = (int)floor(array_first($products));
        $min = (int)floor(array_last($products));

        return ['status' => $min+$max ? 1 : 0, 'cfg' => ['min' => $min, 'max' => $max]];
    }

    public function business_size($cat, $products){

        $products = $products
            ->pluck('business_size')
            ->toArray();

        $objs = [];
        foreach ($products as $ps)
            foreach ($ps as $p)
                $objs[$p] = $p;

        foreach ($objs as $obj) {
            unset($objs[$obj]);
            $objs[] = $obj;
        }

        return ['status' => (count($objs) ? 1 : 0), 'cfg' => $objs];
    }

    public function features($cat, $products)
    {
        $features = [];

        foreach($products as $prod){
            $f_arr = [];
            if($prod['category_1']==$cat->id) $f_arr = $prod['features'][1];
            if($prod['category_2']==$cat->id) $f_arr = $prod['features'][2];
            if($prod['category_3']==$cat->id) $f_arr = $prod['features'][3];
            if(count($f_arr))
                foreach ($f_arr as $arr)
                    $features[$arr] = $arr;

        }

        foreach ($features as $obj) {
            unset($features[$obj]);
            $features[] = $obj;
        }

        return ['status' => (count($features) ? 1 : 0), 'cfg' => $features];
    }

    public function deployment($cat, $products)
    {
        $products = $products
            ->pluck('deployment')
            ->toArray();

        $objs = [];
        foreach ($products as $ps)
            foreach ($ps as $p)
                $objs[$p] = $p;

        foreach ($objs as $obj) {
            unset($objs[$obj]);
            $objs[] = $obj;
        }

        return ['status' => (count($objs) ? 1 : 0), 'cfg' => $objs];
    }

    public function desktop_client($cat, $products)
    {
        $products = $products
            ->pluck('desc_client')
            ->toArray();

        $objs = [];
        foreach ($products as $ps)
            foreach ($ps as $p)
                $objs[$p] = $p;

        foreach ($objs as $obj) {
            unset($objs[$obj]);
            $objs[] = $obj;
        }

        return ['status' => (count($objs) ? 1 : 0), 'cfg' => $objs];
    }

    public function mobile_version($cat, $products)
    {
        $products = $products
            ->pluck('mobile_version')
            ->toArray();

        $objs = [];
        foreach ($products as $ps) {
            if($ps) foreach ($ps as $p) {
                $objs[$p] = $p;
            }
        }

        foreach ($objs as $obj) {
            unset($objs[$obj]);
            $objs[] = $obj;
        }

        return ['status' => (count($objs) ? 1 : 0), 'cfg' => $objs];
    }

    public function price($cat, $products)
    {
        $products = $products
            ->pluck('pricing')
            ->toArray();

        $objs = [];

        foreach($products as $prod){
            //if(isset($prod['starting_price']) && isset($prod['starting_price']['onsubmit']) && $prod['starting_price']['onsubmit'] == 'on') $objs['starting_price'] = true;
            //if(isset($prod['license_price']) && isset($prod['license_price']['onsubmit']) && $prod['license_price']['onsubmit'] == 'on') $objs['license_price'] = true;
            if(isset($prod['free_trial']) && isset($prod['free_trial']['active']) && $prod['free_trial']['active'] == 'on') $objs['free_trial'] = true;
            foreach($prod['pricing_model'] as $pm)
                $objs['pricing_model'][$pm] = $pm;
            /*foreach($prod['training'] as $pm)
                $objs['training'][$pm] = $pm;*/
        }

        return ['status' => (count($objs) ? 1 : 0), 'cfg' => $objs];
    }
}
