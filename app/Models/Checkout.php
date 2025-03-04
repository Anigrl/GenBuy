<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    //

    protected $guarded = [];

    protected $table = 'checkout'; 

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
       return $this->hasMany(OrderItem::class);
    }
}
