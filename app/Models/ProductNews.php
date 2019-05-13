<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNews extends Model
{
    protected $table = 'product_news';

    protected $fillable = ['product_id', 'title', 'text', 'active'];

    public function product()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_id');
    }
}
