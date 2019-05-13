<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uses extends Model
{
    protected $table = 'products_uses';

    protected $fillable = ['user_id', 'product_id'];

    public $timestamps = false;
}
