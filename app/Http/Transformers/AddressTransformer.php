<?php
namespace App\Http\Transformers;
use App\Address;
use App\Order;

/**
 * Class AddressTransformer
 * @package App\Http\Transformers
 *
 */
class AddressTransformer
{

    /**
     * @param Address $address
     * @return array
     */
    public function transformItem(Address $address)
    {
        return [
            'id' => $address->id,
            'address_1' => $address->address_1,
            'address_2' => $address->address_2,
            'town' => $address->town,
            'county' => $address->county,
            'postcode' => $address->postcode,
            'customer_id' => $address->customer_id
        ];
    }

    /**
     * @param $orders
     * @return array
     */
    public function transformCollection($orders)
    {
        $collection = [];
        foreach ($orders as $order) {
            $collection[] = $this->transformItem($order);
        }
        return $collection;
    }

}
