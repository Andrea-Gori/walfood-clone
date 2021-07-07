<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $fillable = [
        'business_name',
        'vat',
        'img',
        'address',
        'user_id',
        'slug'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function dishes()
    {
        return $this->hasMany('App\Dish');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
