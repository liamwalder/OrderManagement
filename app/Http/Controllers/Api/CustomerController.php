<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Services\CustomerService;
use Illuminate\Http\Request;

/**
 * Class CustomerController
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{

    /**
     * @var CustomerService
     */
    public $customerService;

    /**
     * CustomerController constructor.
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $customers = $this->customerService->findAll();
        return response()->json(['entities' => $customers]);
    }

    /**
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CustomerRequest $request)
    {
        $customer = $this->customerService->create($request->get('customer'));
        return response()->json($customer, 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $customer = $this->customerService->findOne($id);
        return response()->json($customer);
    }

    /**
     * @param CustomerRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = $this->customerService->update($id, $request->get('customer'));
        return response()->json($customer);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->customerService->delete($id);
        return response()->json([]);
    }
}
