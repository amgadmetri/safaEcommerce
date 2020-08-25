<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Interfaces\CartRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class CartsRepository implements CartRepositoryInterface
{
    use ApiResponseTrait;

    protected $carts;

    public function __construct(Cart $carts)
    {
        $this->carts = $carts;
    }
    public function getCart($id)
    {
        return $this->carts->find($id);
    }
    public function createCart(Request $request)
    {
        return $this->carts->create($request->all());
    }
    public function updateCart(Request $request)
    {
        $input = $request->all();
        $cart = $this->getCart($input['id']);
        return $cart->update($request->all());
    }

    public function cartPostValidation(Request $request)
    {
        return $this->apiValidation($request, [
            'customer_id' => 'required|numeric',
            'item_id'     => 'required|numeric',
            'quantity'    => 'required|numeric|gt:0'
        ]);
    }

    public function checkIfItemExist($customer_id, $item_id)
    {
        return $this->carts->where('customer_id', $customer_id)->where('item_id', $item_id)->first();
    }

    public function changeItemQuantity(Request $request)
    {
        $cartItem = $this->carts->where('customer_id', $request->customer_id)->where('item_id', $request->item_id)->first();
        $data['quantity'] = $request->quantity;
        return $cartItem->update(array_merge($request->toArray(),$data));
    }
    
    public function removeFromCart($id)
    {
        $cart = $this->getCart($id);
        return $cart->delete();
    }
    
    public function allCustomerCartItems($customer_id)
    {
        return $this->carts->where('customer_id', $customer_id)->get();
    }

}
