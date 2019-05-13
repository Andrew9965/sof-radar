<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedLinksProducts extends Model
{
    protected $table = 'related_links_products';

    protected $fillable = ["rl_id", "p_id", "active"];
}