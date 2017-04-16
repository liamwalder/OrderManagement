<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AddressRepository;
use App\Http\Requests\AddressRequest;
use App\Http\Services\AddressService;
use Illuminate\Http\Request;

/**
 * Class AddressController
 * @package App\Http\Controllers
 */
class AddressController extends Controller
{

    /**
     * @var AddressService
     */
    public $addressService;

    /**
     * @var AddressRepository
     */
    public $addressRepository;

    /**
     * AddressController constructor.
     * @param AddressService $addressService
     */
    public function __construct(
        AddressService $addressService,
        AddressRepository $addressRepository
    )
    {
        $this->addressService = $addressService;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $addresss = $this->addressService->findAll();
        return response()->json(['addresses' => $addresss]);
    }

    /**
     * @param AddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(AddressRequest $request)
    {
        $address = $this->addressService->create($request->get('address'));
        return response()->json($address, 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $address = $this->addressService->findOne($id);
        return response()->json($address);
    }

    /**
     * @param AddressRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AddressRequest $request, $id)
    {
        $address = $this->addressService->update($id, $request->get('address'));
        return response()->json($address);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $address = $this->addressRepository->findOne($id);

        // If we are deleting an address from an already registered
        $customer = $address->customer;
        if ($customer) {
            // Cannot delete the last remaining address for a user
            if ($customer->addresses()->count() == 1) {
                return response()->json(['error' => 'You can not delete the only address for this user.'], 422);
            }

        }


        $this->addressService->delete($id, $customer);
        return response()->json([]);
    }
}
