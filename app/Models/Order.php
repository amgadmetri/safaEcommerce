<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    protected $fillable = ['customer_id', 'total', 'address', 'telephone'];


    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

}
