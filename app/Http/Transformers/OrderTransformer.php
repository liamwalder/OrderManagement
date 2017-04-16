<?php
namespace App\Http\Transformers;
use App\Address;
use App\Order;

/**
 * Class OrderTransformer
 * @package App\Http\Transformers
 */
class OrderTransformer
{

    /**
     * @var ProductTransformer
     */
    protected $productTransformer;

    /**
     * @var CustomerTransformer
     */
    protected $customerTransformer;

    /**
     * @var AddressTransformer
     */
    protected $addressTransformer;

    /**
     * OrderTransformer constructor.
     * @param ProductTransformer $productTransformer
     * @param CustomerTransformer $customerTransformer
     * @param AddressTransformer $addressTransformer
     */
    public function __construct(
        ProductTransformer $productTransformer,
        CustomerTransformer $customerTransformer,
        AddressTransformer $addressTransformer
    ) {
        $this->productTransformer = $productTransformer;
        $this->customerTransformer = $customerTransformer;
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * @param Order $order
     * @return array
     */
    public function transformItem(Order $order)
    {
        return [
            'id' => (int) $order->id,
            'status' => $order->status->name,
            'created_at' => $order->created_at->format('d/m/Y H:i:s'),
            'customer' => $this->customerTransformer->transformItem($order->customer),
            'address' => $this->addressTransformer->transformItem($order->address),
            'products' => $this->productTransformer->transformCollection($order->products)
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
