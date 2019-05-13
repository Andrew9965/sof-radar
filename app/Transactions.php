<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id', 'amount', 'status', 'type', 'hash', 'response'
    ];

    protected $casts = [
        'response' => 'array'
    ];

    const
        STATUS_PENDING = 0,
        STATUS_SUCCESS = 1,
        STATUS_FAILED = 2,
        STATUS_ERROR = 3;

    const
        TYPE_REFILL = 1,
        TYPE_PAYOUT = 2,
        TYPE_AD = 3,
        TYPE_REFUND = 4;


    public function getRouteKeyName()
    {
        return 'hash';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setHashAttribute($hash)
    {
        $this->attributes['hash'] = md5(str_random(floor($hash)) . (isset(\Auth::user()->id) ? \Auth::user()->id : time()));
    }
}
