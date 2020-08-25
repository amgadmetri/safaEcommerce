<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'cart';
    protected $fillable = ['customer_id', 'item_id', 'quantity'];

    
    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
    
    public function item(){
        return $this->belongsTo('App\Models\Item','item_id');
    }
}
