<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $guarded=[];

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Belongs to ONE product
    }

    public function order()
    {
        return $this->belongsTo(Checkout::class);
        
    }
}
