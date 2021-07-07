<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    public $fillable = [
        'name',
        'img',
        'description',
        'price',
        'slug',
        'visibility',
        'restaurant_id',
    ];

    public function orders()
    {
        return $this->belongsToMany('App\Order')->withPivot(['quantity']);
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
