<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesFF extends Model
{
    protected $table = 'categories_functional_features';

    protected $fillable = ['title'];

    public function category()
    {
        return $this->belongsTo(\App\Models\Categories::class, 'category_id');
    }
}
