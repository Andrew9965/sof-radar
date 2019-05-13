<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesAddAttr extends Model
{
    protected $table = 'pages_additional_attributes';

    protected $fillable = ['page_id', 'property', 'content'];
}
