<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderRepositoryInterface {
    public function getAllOrders();
    public function getOrder($id);
    public function createOrder(Request $request);
    public function updateOrder(Request $request);
    public function orderPostValidation(Request $request);

}