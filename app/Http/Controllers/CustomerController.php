<?php

namespace App\Http\Controllers;

use App\Repositories\CustomersRepository;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{


    private $customerRepository;

    public function __construct(CustomersRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function creatCustomer(Request $request)
    {
        $validation = $this->customerRepository->customerPostValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        $customer = $this->customerRepository->createCustomer($request);

        if ($customer) {
            return $this->apiResponse(['customer' => $customer], null, 201);
        }

        return $this->unKnowError('error while create the customer');
    }


    public function getAllCustomers(Request $request)
    {
        $customers = $this->customerRepository->getAllCustomers($request);
        if ($customers) {
            return $this->apiResponse(CustomerResource::collection($customers));
        } else {
            return $this->notFoundResponse("There is no customers");
        }
    }

    public function getCustomer($id)
    {
        $customer = $this->customerRepository->getCustomer($id);
        if ($customer) {
            return $this->apiResponse(new CustomerResource($customer));
        } else {
            return $this->notFoundResponse("There is no customer matching this id");
        }
    }

    public function updateCustomer(Request $request)
    {
        $validation = $this->customerRepository->customerUpdateValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        $customer = $this->customerRepository->updateCustomer($request);

        if ($customer) {
            return $this->apiResponse("successfully updated");
        }

        return $this->unKnowError('error while update the customer');
    }

}
