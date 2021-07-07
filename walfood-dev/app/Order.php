<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_surname',
        'customer_email',
        'phone_number',
        'address',
        'total_price',
        'restaurant_id',
    ];
    public function dishes()
    {
        return $this->belongsToMany('App\Dish')->withPivot(['quantity']);
    }
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
