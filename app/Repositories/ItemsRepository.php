<?php

namespace App\Repositories;

use App\Models\Item;
use App\Interfaces\ItemRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class ItemsRepository implements ItemRepositoryInterface
{
    use ApiResponseTrait;

    protected $items;

    public function __construct(Item $items)
    {
        $this->items = $items;
    }
    public function getAllItems()
    {
        return $this->items->orderBy('id', 'DESC')->get();
    }
    public function getItem($id)
    {
        return $this->items->find($id);
    }
    public function createItem(Request $request)
    {
        return $this->items->create($request->all());
    }
    public function updateItem(Request $request)
    {
        $input = $request->all();
        $item = $this->getItem($input['id']);
        return $item->update($request->all());
    }

    public function itemPostValidation(Request $request)
    {
        return $this->apiValidation($request, [
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required|numeric'
        ]);
    }
}
