<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{


    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            //can show relationship
            'id'           => $this->id,
            'email'        => $this->email,
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'store_credit' => $this->store_credit,
            'orders'       => OrderResource::collection($this->orders),
            'carts'        => CartResource::collection($this->carts)
        ];
    }

}