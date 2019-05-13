<?php

namespace App;

use App\Models\Products;
use Illuminate\Support\Collection;
use App\Models\Traits\ChartSorterTrait;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Tracker\Vendor\Laravel\Models\Session;
use Lia\Facades\Admin;

class Click extends Model
{
    use ChartSorterTrait;

    protected $table = 'clicks';

    protected $fillable = ['uuid', 'user_id', 'product_id', 'transaction_id'];

    protected $casts = [
        'uuid' => 'string',
        'user_id' => 'integer',
        'product_id' => 'integer',
        'transaction_id' => 'integer',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function session()
    {
        $this->hasMany(Session::class, 'uuid', 'uuid');
    }

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id', 'transaction_id');
    }

    public function chartFilter($query)
    {
        if(!\Auth::user() && isset(Admin::user()->id)) return $query;
        if(request()->user_id && isset(Admin::user()->id)) $u_id = request()->user_id;
        else $u_id = \Auth::user()->id;

        return $query->where('user_id', $u_id);
    }

    public function formatResponseValue($value)
    {
        return $value->count();
    }
}
