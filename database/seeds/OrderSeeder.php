<?php

use Illuminate\Database\Seeder;

/**
 * Class OrderSeeder
 */
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {

            $customerId = rand(1, 10);


            $products = [];
            for ($productsToAdd = 1; $productsToAdd < rand(1, 10); $productsToAdd++) {
                $products[] = \App\Product::findOrFail(rand(1, 50));
            }
            $products = collect($products);

            $addresses = \App\Address::where('customer_id', $customerId)->get();
            $address = $addresses->random();

            $stage = rand(1, 4);

            $order = [
                'customer_id' => $customerId,
                'address_id' => $address->id,
                'total' => number_format($products->sum('price'), 2)
            ];

            $orderModel = new \App\Order();
            $orderModel->fill($order);
            $orderModel->save();

            for($stageToAdd = 1; $stageToAdd <= $stage; $stageToAdd++) {
                $orderModel->stages()->attach($stageToAdd);
            }


            $productIds = [];
            foreach ($products as $product) {
                $productIds[] = $product->id;
            }

            $orderModel->products()->attach($productIds);

        }
    }
}
