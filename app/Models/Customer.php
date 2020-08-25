<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customers';
    protected $fillable = ['email', 'first_name', 'last_name', 'store_credit'];


    public function orders(){
        return $this->hasMany('App\Models\Order','customer_id', 'id');
    }

    public function carts(){
        return $this->hasMany('App\Models\Cart','customer_id');
    }

}
