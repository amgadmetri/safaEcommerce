<?php

namespace App\Http\Controllers;

use App\Repositories\OrdersRepository;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    private $orderRepository;

    public function __construct(OrdersRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function creatOrder(Request $request)
    {
        $validation = $this->orderRepository->orderPostValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        $order = $this->orderRepository->createOrder($request);

        if ($order) {
            return $this->apiResponse(['order' => $order], null, 201);
        }

        return $this->unKnowError('error while create the order');
    }


    public function getAllOrders(Request $request)
    {
        $orders = $this->orderRepository->getAllOrders($request);
        if ($orders) {
            return $this->apiResponse(OrderResource::collection($orders));
        } else {
            return $this->notFoundResponse("There is no orders");
        }
    }

    public function getOrder($id)
    {
        $order = $this->orderRepository->getOrder($id);
        if ($order) {
            return $this->apiResponse(new OrderResource($order));
        } else {
            return $this->notFoundResponse("There is no order matching this id");
        }
    }

    public function updateOrder(Request $request)
    {
        $validation = $this->orderRepository->orderUpdateValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        $order = $this->orderRepository->updateOrder($request);

        if ($order) {
            return $this->apiResponse("successfully updated");
        }

        return $this->unKnowError('error while update the order');
    }

}
