<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedLinks extends Model
{
    protected $table = 'related_links';

    protected $fillable = ['title','category_id','slug','meta_title','meta_keywords','meta_description', 'meta_auto', 'active','filter','header_description','seo_header_description','filter_auto','filter_cfg'];

    protected $casts = [
        'filter' => 'array',
        'filter_cfg' => 'array'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(RelatedLinksProducts::class, 'rl_id');
    }

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }
}
