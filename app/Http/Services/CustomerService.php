<?php

namespace App\Http\Services;

use App\Customer;
use App\Http\Repositories\CustomerRepository;
use App\Http\Transformers\CustomerTransformer;
use Illuminate\Events\Dispatcher;

/**
 * Class CustomerService
 * @package App\Http\Services
 */
class CustomerService extends Service
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var CustomerTransformer
     */
    private $customerTransformer;

    /**
     * @var AddressService
     */
    private $addressService;

    /**
     * CustomerService constructor.
     * @param Dispatcher $dispatcher
     * @param CustomerRepository $customerRepository
     * @param CustomerTransformer $customerTransformer
     */
    public function __construct(
        Dispatcher $dispatcher,
        CustomerRepository $customerRepository,
        CustomerTransformer $customerTransformer,
        AddressService $addressService
    ) {
        $this->dispatcher = $dispatcher;
        $this->customerRepository = $customerRepository;
        $this->customerTransformer = $customerTransformer;
        $this->addressService = $addressService;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $customer = $this->customerRepository->findOne($id);
        $customer = $this->customerTransformer->transformItem($customer);
        return $customer;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $customers = $this->customerRepository->findAll();
        $customers = $this->customerTransformer->transformCollection($customers);

        $pagination = $this->pagination(Customer::class);

        return ['items' => $customers, 'pagination' => $pagination];
    }



    /**
     * @param array $data
     * @return \App\Customer
     * @throws \Exception
     */
    public function create(array $data)
    {
//        $account = $this->auth->getCurrentCustomer();

        // Check if the customer has permission to create other customers.
        // Will throw an exception if not.
//        $account->checkPermission('customers.create');

        // Use our validation helper to check if the given email
        // is unique within the account.

        // Set the account ID on the customer and create the record in the database

        $customer = $this->customerRepository->create($data);

        $addresses = $data['addresses'];
        foreach ($addresses as $address) {
            $this->addressService->update($address['id'], ['customer_id' => $customer->id]);
        }

        $customer = $this->customerTransformer->transformItem($customer);

        // Fire an event so that listeners can react
//        $this->dispatcher->fire(new CustomerWasCreated($customer));

        return $customer;
    }


    /**
     * @param $id
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $customer = $this->customerRepository->update($id, $data);
        $customer = $this->customerTransformer->transformItem($customer);
        return $customer;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->customerRepository->delete($id);
    }


}