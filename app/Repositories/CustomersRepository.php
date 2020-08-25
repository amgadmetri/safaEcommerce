<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class CustomersRepository implements CustomerRepositoryInterface
{
    use ApiResponseTrait;

    protected $customers;

    public function __construct(Customer $customers)
    {
        $this->customers = $customers;
    }
    public function getAllCustomers()
    {
        return $this->customers->orderBy('id', 'DESC')->get();
    }
    public function getCustomer($id)
    {
        return $this->customers->find($id);
    }
    public function createCustomer(Request $request)
    {
        return $this->customers->create($request->all());
    }
    public function updateCustomer(Request $request)
    {
        $input = $request->all();
        $customer = $this->getCustomer($input['id']);
        return $customer->update($request->all());
    }

    public function customerPostValidation(Request $request)
    {
        return $this->apiValidation($request, [
            'email'        => 'required|email|unique:customers,email',
            'first_name'   => 'required',
            'last_name'    => 'required',
            'store_credit' => 'required|numeric'
        ]);
    }

    public function customerUpdateValidation(Request $request)
    {
        $id = $request->get('id');
        return $this->apiValidation($request, [
            'email'        => 'required|email|unique:customers,email,' . $id,
            'first_name'   => 'required',
            'last_name'    => 'required',
            'store_credit' => 'required|numeric'
        ]);
    }

    public function updateCustomerStoreCredit($customer_id, $deduct_amount)
    {
        $customer = $this->getCustomer($customer_id);
        $data['store_credit'] = $customer->store_credit-$deduct_amount;
        return $customer->update($data);
    }

}
