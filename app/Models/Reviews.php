<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'headline',
        'used',
        'easy_of_use',
        'functionality',
        'product_quality',
        'customer_support',
        'value_for_money',
        'like_best',
        'like_least',
        'comment',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_auto',
        'status'
    ];

    protected $appends = ['color'];

    public function product()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_id');
    }

    public function user()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function setUserIdAttribute($value)
    {
        if(is_null($value)) $this->attributes['user_id'] = isset(\Auth::user()->id) ? \Auth::user()->id : 0;
        else $this->attributes['user_id'] = $value;
    }

    public function getColorAttribute()
    {
        $rate = ($this->easy_of_use+$this->functionality+$this->product_quality+$this->customer_support+$this->value_for_money)/5;
        if($rate>=0 && $rate<=1.9) return 'red '.$rate;
        if($rate>=2 && $rate<=3.5) return 'orange '.$rate;
        if($rate>=3.6 && $rate<=4) return 'pale_green '.$rate;
        if($rate>=4.1 && $rate<=4.5) return 'green '.$rate;
        if($rate>=4.6 && $rate<=5) return 'dark_green '.$rate;
        return $rate;
    }
}
