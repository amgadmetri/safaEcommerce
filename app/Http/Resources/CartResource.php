<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            //can show relationship
            'id'       => $this->id,
            'item'     => new ItemResource($this->item),
            'quantity' => $this->quantity
        ];
    }
}
