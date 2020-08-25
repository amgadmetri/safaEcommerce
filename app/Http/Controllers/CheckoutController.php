<?php

namespace App\Http\Controllers;

use App\Repositories\CartsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\CustomersRepository;
use App\Repositories\ItemsRepository;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{


    private $cartRepository;
    private $orderRepository;
    private $customerRepository;
    private $itemRepository;

    public function __construct(CartsRepository $cartRepository, OrdersRepository $orderRepository, CustomersRepository $customerRepository, ItemsRepository $itemRepository)
    {
        $this->cartRepository     = $cartRepository;
        $this->orderRepository    = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->itemRepository     = $itemRepository;
    }

    public function checkout(Request $request)
    {
        $existCustomer = $this->customerRepository->getCustomer($request->customer_id);
        $orderTotal = 0;
        if ($existCustomer) {
            for ($i = 0; $i < count($existCustomer->carts); $i++) {
                $item_price =  $this->itemRepository->getItem($existCustomer->carts[$i]->item_id)->price;
                $total_item_price = $existCustomer->carts[$i]->quantity * $item_price;
                $orderTotal += $total_item_price;
            }
            if ($existCustomer->store_credit >= $orderTotal) {
                $this->customerRepository->updateCustomerStoreCredit($existCustomer->id, $orderTotal);
                $this->orderRepository->createCheckoutOrder($request->customer_id, $orderTotal, $request->address, $request->telephone);
            } else {
                return $this->unauthorizedResponse('You do not have enough credit to make this checkout');
            }

            return $this->apiResponse("Your payment transaction is successful and your order is placed");
        } else {
            return $this->notFoundResponse('There is no customer matches this customer id');
        }
    }


    public function getAllCartItems($customer_id)
    {
        $items = $this->cartRepository->allCustomerCartItems($customer_id);
        if ($items) {
            return $this->apiResponse(CartResource::collection($items));
        } else {
            return $this->notFoundResponse("There is no items");
        }
    }
}
