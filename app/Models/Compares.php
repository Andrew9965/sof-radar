<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compares extends Model
{
    protected $fillable = ['user_id','category_id','product_left_id','product_right_id','meta_title','meta_keywords','meta_description','meta_auto','slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->hasOne(\App\Models\Categories::class, 'id', 'category_id');
    }

    public function left()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_left_id');
    }

    public function right()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_right_id');
    }
}
