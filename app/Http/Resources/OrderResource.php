<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{


    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            //can show relationship
            'id'          => $this->id,
            'total'       => $this->total,
            'address'     => $this->address,
            'telephone'   => $this->telephone,
            'customer_id' => $this->customer_id
        ];
    }
}
