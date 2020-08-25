<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CustomerRepositoryInterface {
    public function getAllCustomers();
    public function getCustomer($id);
    public function createCustomer(Request $request);
    public function updateCustomer(Request $request);
    public function customerPostValidation(Request $request);
    public function customerUpdateValidation(Request $request);

}