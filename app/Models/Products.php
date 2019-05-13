<?php

namespace App\Models;

use App\Click;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Lia\Auth\Database\Administrator;
use Lia\Media\Database\LiaMedia;

class Products extends Model
{

    protected $fillable = [
        'slug',
        'user_id',
        'author_id',
        'company',
        'top',
        'title',
        'logo',
        'short_description',
        'fool_description',
        'categories',
        'category_1',
        'category_2',
        'category_3',
        'features',
        'details',
        'pricing',
        'pricing_starting_price',
        'pricing_starting_price_onsubmit',
        'pricing_starting_price_link',
        'pricing_pricing_model',
        'pricing_training',
        'pricing_license_price',
        'pricing_license_price_onsubmit',
        'pricing_license_price_link',
        'pricing_free_trial_active',
        'pricing_free_trial_link',
        'pricing_desc',
        'web_site',
        'integrations_programs',
        'business_size',
        'deployment',
        'desc_client',
        'mobile_version',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_auto',
        'easy_of_use',
        'functionality',
        'product_quality',
        'customer_support',
        'value_for_money',
        'review_count',
        'review_rait_total',
        'active'
    ];

    protected $casts = [
        'categories' => 'array',
        'features' => 'array',
        'details' => 'array',
        'pricing' => 'array',
        'integrations_programs' => 'array',
        'business_size' => 'array',
        'deployment' => 'array',
        'desc_client' => 'array',
        'mobile_version' => 'array',
        'pricing_pricing_model' => 'array',
        'pricing_training' => 'array',
    ];

    public function clicks()
    {
        return $this->hasMany(Click::class, 'product_id', 'id');
    }

    public function getPricingLicensePriceAttribute($data)
    {
        return is_null($data) ? 0 : $data;
    }

    public function getPricingStartingPriceAttribute($data)
    {
        return is_null($data) ? 0 : $data;
    }

    public function getIsClickAttribute()
    {
        if (is_null($this->web_site) || empty($this->web_site)) return false;
        else return $this->is_web_click;
    }

    public function getIsWebClickAttribute()
    {
        if (!$this->author) return false;
        else if (((float)$this->author->balance - (float)$this->author->click_cost) <= 0) return false;
        else return true;
    }

    public function getStartingPriceLinkAttribute()
    {
        if(!empty($this->pricing['starting_price']['link']) && !is_null($this->pricing['starting_price']['link']))
            return route('product.link', ['product' => $this->slug, 'source' => 'starting_price']);

        if(!is_null($this->web_site) && !empty($this->web_site))
            return route('product.link', ['product' => $this->slug]);

        return false;
    }

    public function getLicensePriceLinkAttribute()
    {
        if(!empty($this->pricing['license_price']['link']) && !is_null($this->pricing['license_price']['link']))
            return route('product.link', ['product' => $this->slug, 'source' => 'license_price']);

        if(!is_null($this->web_site) && !empty($this->web_site))
            return route('product.link', ['product' => $this->slug]);

        return false;
    }

    public function getFreeTrialLinkAttribute()
    {
        if(!empty($this->pricing['free_trial']['link']) && !is_null($this->pricing['free_trial']['link']))
            return route('product.link', ['product' => $this->slug, 'source' => 'free_trial']);

        if(!is_null($this->web_site) && !empty($this->web_site))
            return route('product.link', ['product' => $this->slug]);

        return false;
    }

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function user()
    {
        return $this->hasOne(Administrator::class, 'id', 'user_id');
    }

    public function category1()
    {
        return $this->hasOne(\App\Models\Categories::class, 'id', 'category_1');
    }

    public function category2()
    {
        return $this->hasOne(\App\Models\Categories::class, 'id', 'category_2');
    }

    public function category3()
    {
        return $this->hasOne(\App\Models\Categories::class, 'id', 'category_3');
    }

    public function category_1()
    {
        return $this->category1();
    }

    public function category_2()
    {
        return $this->category2();
    }

    public function category_3()
    {
        return $this->category3();
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Reviews::class, 'product_id', 'id')->where('status', 1);
    }

    /*public function media()
    {
        return $this->hasMany(\App\Models\ProductMedia::class, 'product_id', 'id');
    }*/

    public function media()
    {
        return $this->hasMany(LiaMedia::class, 'relate_id', 'id')->where('active', 1);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\ProductMedia::class, 'product_id', 'id')->where('type', 'feature');
    }

    public function news()
    {
        return $this->hasMany(\App\Models\ProductNews::class, 'product_id', 'id')->where('active', 1);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getColorAttribute()
    {
        $rate = $this->review_rait_total;
        if($rate>=0 && $rate<=1.9) return 'red';
        if($rate>=2 && $rate<=3.5) return 'orange';
        if($rate>=3.6 && $rate<=4) return 'pale_green';
        if($rate>=4.1 && $rate<=4.5) return 'green';
        if($rate>=4.6 && $rate<=5) return 'dark_green';
        return $rate;
    }

    public function getColorHexAttribute()
    {
        $rate = $this->review_rait_total;
        if($rate>=0 && $rate<=1.9) return '#ed3b59';
        if($rate>=2 && $rate<=3.5) return '#ffae00';
        if($rate>=3.6 && $rate<=4) return '#13bb76';
        if($rate>=4.1 && $rate<=4.5) return '#018002';
        if($rate>=4.6 && $rate<=5) return '#1e4820';
        return $rate;
    }

    public function alternatives()
    {
        if(request()->product && isset(request()->product->id)){
            $product = request()->product;
            return $this->where('id', '!=', $product->id)->where(function($query) use ($product){
                $query->orWhere('category_1', $product->categories[1]);
                $query->orWhere('category_2', $product->categories[1]);
                $query->orWhere('category_3', $product->categories[1]);
            })->count();
        }else return false;
    }

    public function compression()
    {
        if(request()->product && isset(request()->product->id)){
            $product = request()->product;

            $compare = Compares::where(function($query) use ( $product ){
                $query->orWhere('product_left_id', $product->id);
                $query->orWhere('product_right_id', $product->id);
            })->get();

            $ids = $compare->where('product_left_id', '!=', $product->id)->pluck('product_left_id', 'product_left_id')->toArray()+
                $compare->where('product_right_id', '!=', $product->id)->pluck('product_right_id', 'product_right_id')->toArray();
            //dd($ids);
            return Products::whereIn('id', $ids)->count();
        }else return false;
    }
}
