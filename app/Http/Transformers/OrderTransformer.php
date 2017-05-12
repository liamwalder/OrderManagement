<?php
namespace App\Http\Transformers;
use App\Address;
use App\Order;
use App\Stage;

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
            'stage' => $order->stages->last()->name,
            'stage_id' => $order->stages->last()->id,
            'stages' => $this->populateOrderStages($order),
            'value' => number_format($order->products->sum('price'), 2),
            'created_at' => $order->created_at->format('d/m/Y H:i:s'),
            'customer' => $this->customerTransformer->transformItem($order->customer),
            'address' => $this->addressTransformer->transformItem($order->address),
            'products' => $this->groupProducts($this->productTransformer->transformCollection($order->products))
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

    /**
     * @param $products
     * @return array
     */
    protected function groupProducts($products)
    {
        $sortedProducts = [];
        foreach($products as $key => $item) {
            $sortedProducts[$item['id']][$key] = $item;
        }
        ksort($sortedProducts, SORT_NUMERIC);

        $products = [];
        foreach ($sortedProducts as $sorted) {
            $product = end($sorted);
            $quantity = count($sorted);
            $product['quantity'] = $quantity;
            $product['originalPrice'] = number_format($product['price'], 2, '.', '');
            $product['price'] = number_format(($product['originalPrice'] * $quantity), 2, '.', '');
            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param $order
     * @return array
     */
    protected function populateOrderStages($order)
    {
        $stages = [];

        foreach (Stage::all() as $orderStage) {

            $singleStage = $order->stages->filter(function($value, $key) use ($orderStage) {
                return $value->id == $orderStage->id;
            });

            $stages[] = [
                'id' => $orderStage->id,
                'name' => $orderStage->name,
                'classes' => $orderStage->classes,
                'created' => $singleStage->isEmpty() ? null : $singleStage->first()->pivot->created_at->format('d/m/Y H:i:s')
            ];
        }
        return $stages;
    }

}
