<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesSimilar extends Model
{
    protected $table = 'categories_similar';

    protected $fillable = [
        'parent_id', 'category_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id', 'id');
    }

    public function cat()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}
