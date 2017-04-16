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

            $addresses = \App\Address::where('customer_id', $customerId)->get();
            $address = $addresses->random();

            $order = [
                'customer_id' => $customerId,
                'address_id' => $address->id,
                'status_id' => rand(1, 4)
            ];

            $orderModel = new \App\Order();
            $orderModel->fill($order);
            $orderModel->save();

            for ($productsToAdd = 1; $productsToAdd < rand(1, 10); $productsToAdd++) {
                $orderModel->products()->attach(rand(1, 50));
            }

        }
    }
}
