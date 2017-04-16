<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Transformers\AddressTransformer;
use Illuminate\Events\Dispatcher;

/**
 * Class AddressService
 * @package App\Http\Services
 */
class AddressService
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * @var AddressTransformer
     */
    private $addressTransformer;

    /**
     * AddressService constructor.
     * @param Dispatcher $dispatcher
     * @param AddressRepository $addressRepository
     * @param AddressTransformer $addressTransformer
     */
    public function __construct(
        Dispatcher $dispatcher,
        AddressRepository $addressRepository,
        AddressTransformer $addressTransformer
    ) {
        $this->dispatcher = $dispatcher;
        $this->addressRepository = $addressRepository;
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $address = $this->addressRepository->findOne($id);
        $address = $this->addressTransformer->transformItem($address);
        return $address;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $addresss = $this->addressRepository->findAll();
        $addresss = $this->addressTransformer->transformCollection($addresss);
        return $addresss;
    }

    /**
     * @param array $data
     * @return \App\Address
     * @throws \Exception
     */
    public function create(array $data)
    {
        $address = $this->addressRepository->create($data);
        $address = $this->addressTransformer->transformItem($address);
        return $address;
    }


    /**
     * @param $id
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $address = $this->addressRepository->update($id, $data);
        $address = $this->addressTransformer->transformItem($address);
        return $address;
    }

    /**
     * @param $id
     * @param $customer
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->addressRepository->delete($id);
    }


}