<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CartRepositoryInterface {
    public function getCart($id);
    public function createCart(Request $request);
    public function updateCart(Request $request);

}