<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['title','type','slug','img','meta_title','meta_keywords','meta_description', 'meta_auto', 'active', 'home','count','header_description','seo_header_description','filter','filter_auto','filter_cfg'];

    protected $casts = [
        'filter' => 'array',
        'filter_cfg' => 'array'
    ];

//    protected $appends = ['categories_ff'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories_ff()
    {
        return $this->hasMany(\App\Models\CategoriesFF::class, 'category_id');
    }

    public function getImgAttribute($img)
    {
        if (!$img)
            return admin_asset('/images/categories/img_04.jpg');
        else
            return asset('uploads/'.$img);
    }

    public function scopeGetCount($query)
    {
        return $query->where('active', 1)->count();
    }

    public function related_links(){
        return $this->hasMany(RelatedLinks::class, 'category_id', 'id');
    }

    public function similar()
    {
        return $this->hasMany(CategoriesSimilar::class, 'parent_id');
    }

    public function iParents()
    {
        return $this->hasMany(CategoriesSimilar::class, 'category_id');
    }

    public function prods_1()
    {
        return $this->hasMany(Products::class, 'category_1')->where('active', 1);
    }

    public function prods_2()
    {
        return $this->hasMany(Products::class, 'category_2')->where('active', 1);
    }

    public function prods_3()
    {
        return $this->hasMany(Products::class, 'category_3')->where('active', 1);
    }
}
