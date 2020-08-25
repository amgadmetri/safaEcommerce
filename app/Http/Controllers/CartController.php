<?php

namespace App\Http\Controllers;

use App\Repositories\CartsRepository;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;

class CartController extends Controller
{


    private $cartRepository;

    public function __construct(CartsRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    // this function add to cart and increase the quantity if already in the cart before
    public function addToCart(Request $request)
    {
        $validation = $this->cartRepository->cartPostValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }
        $isItemExist = $this->cartRepository->checkIfItemExist($request->customer_id, $request->item_id);
        if ($isItemExist) {
            $cart = $this->cartRepository->changeItemQuantity($request);
            return $this->apiResponse("Your cart quantity changed to be ".$request->quantity);
        } else {
            $cart = $this->cartRepository->createCart($request);
            return $this->apiResponse($cart, null, 201);
        }

        return $this->unKnowError('error while adding to the cart');
    }

    // this function return all a customer cart items
    public function getAllCartItems($customer_id)
    {
        $items = $this->cartRepository->allCustomerCartItems($customer_id);
        if ($items) {
            return $this->apiResponse(CartResource::collection($items));
        } else {
            return $this->notFoundResponse("There is no items");
        }
    }

    // this function remove an item from the cart
    public function removeFromCart(Request $request)
    {
        $isItemExist = $this->cartRepository->checkIfItemExist($request->customer_id, $request->item_id);
        if ($isItemExist) {
            $cart = $this->cartRepository->removeFromCart($isItemExist->id);
            return $this->apiResponse('Item removed Successfully');
        } else {
            return $this->notFoundResponse("That item not found in your cart");
        }
    }
}
