<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{

    //for security and manipulate with data
    public function toArray($request)
    {
        return [
            //can show relationship
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price
        ];
    }
}
