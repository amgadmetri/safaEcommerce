<?php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class OrdersRepository implements OrderRepositoryInterface
{
    use ApiResponseTrait;

    protected $orders;

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }
    public function getAllOrders()
    {
        return $this->orders->orderBy('id', 'DESC')->get();
    }
    public function getOrder($id)
    {
        return $this->orders->find($id);
    }
    public function createOrder(Request $request)
    {
        return $this->orders->create($request->all());
    }
    public function updateOrder(Request $request)
    {
        $input = $request->all();
        $order = $this->getOrder($input['id']);
        return $order->update($request->all());
    }

    public function orderPostValidation(Request $request)
    {
        return $this->apiValidation($request, [
            'customer_id' => 'required',
            'total'       => 'required|numeric',
            'address'     => 'required',
            'telephone'   => 'required|numeric'
        ]);
    }

    public function orderUpdateValidation(Request $request)
    {
        return $this->apiValidation($request, [
            'customer_id' => 'required',
            'total'       => 'required|numeric',
            'address'     => 'required',
            'telephone'   => 'required|numeric'
        ]);
    }

    public function createCheckoutOrder($customer_id, $total, $address, $telephone)
    {
        $data['customer_id'] = $customer_id;
        $data['total']       = $total;
        $data['address']     = $address;
        $data['telephone']   = $telephone;
        return $this->orders->create($data);
    }
}
