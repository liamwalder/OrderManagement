<?php
namespace App\Http\Transformers;
use App\Product;

/**
 * Class ProductTransformer
 * @package App\Http\Transformers
 */
class ProductTransformer
{

    /**
     * @param Product $product
     * @return array
     */
    public function transformItem(Product $product)
    {
//        $lastOrdered = 'N/A';
//        if (!$product->orders->isEmpty()) {
//            $lastOrderedOrder = $product->orders()->orderBy('created_at', 'DESC')->first();
//            $lastOrdered = $lastOrderedOrder->created_at->format('d/m/Y');
//        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'description' =>  $product->description,
//            'units_sold' => $product->orders->count(),
//            'last_ordered' =>  $lastOrdered
        ];
    }


    /**
     * @param $products
     * @return array
     */
    public function transformCollection($products)
    {
        $collection = [];
        foreach ($products as $product) {
            $collection[] = $this->transformItem($product);
        }
        return $collection;
    }

}
