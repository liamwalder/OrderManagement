<?php
namespace App\Http\Transformers;
use App\Customer;

/**
 * Class CustomerTransformer
 * @package App\Http\Transformers
 */
class CustomerTransformer
{

    /**
     * @var AddressTransformer
     */
    public $addressTransformer;

    /**
     * UserTransformer constructor.
     * @param AddressTransformer $addressTransformer
     */
    public function __construct(AddressTransformer $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * @param Customer $customer
     * @return array
     */
    public function transformItem(Customer $customer)
    {
        return [
            'id' => (int) $customer->id,
            'firstname' => $customer->firstname,
            'surname' => $customer->surname,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'addresses' => $this->addressTransformer->transformCollection($customer->addresses)
        ];
    }

    /**
     * @param $products
     * @return array
     */
    public function transformCollection($customers)
    {
        $collection = [];
        foreach ($customers as $customer) {
            $collection[] = $this->transformItem($customer);
        }
        return $collection;
    }

}
