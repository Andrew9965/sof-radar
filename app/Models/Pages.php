<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable = [
        'name', 'rout-name', 'uri', 'meta_title', 'meta_keywords', 'meta_description', 'additional_attributes'
    ];

    protected $casts = [
        'additional_attributes' => 'array'
    ];

    public function scopeThisPage($query){
        $rout = \Route::currentRouteName();
        $result = $query->where('rout_name', $rout)->first();
        if(!$result && request()->page && isset(request()->page->id)) $result = request()->page;
        if(!$result) $result = new emptyMeta();
        return $result;
    }

    public function additional_attributes()
    {
        return $this->hasMany('App\Models\PagesAddAttr', 'page_id');
    }

    public function getRouteKeyName()
    {
        return 'uri';
    }

    //App\Models\PagesAddAttr
}

class emptyMeta {
    public $meta_title = null;
    public $meta_keywords = null;
    public $meta_description = null;
}