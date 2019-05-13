<?php

namespace App;

use App\Models\Products;
use App\Models\Reviews;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Transactions;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'position', 'moderator_id', 'click_cost'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'balance'
    ];

    public function getIsAdminAttribute()
    {
        return true;
    }

    public function getClickCostAttribute($value)
    {
        if($value=='0.00') return config('default.cost.click');
        else return $value;
    }

    public function scopeFindByUsernameOrCreate($query, $userData)
    {
        if($find = $query->where('email', $userData['email'])->first())
            return $find;
        else
            return $query->firstOrCreate([
                'name' => $userData['name'],
                'email' => $userData['email'],
            ]);
    }

    public function uses()
    {
        return $this->hasMany(\App\Models\Uses::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'author_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function getBalanceAttribute()
    {
        return number_format($this->transactions()->where('status', Transactions::STATUS_SUCCESS)->sum('amount'), 2, ',', ' ');
    }

}
