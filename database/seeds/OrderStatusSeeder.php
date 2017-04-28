<?php

use Illuminate\Database\Seeder;

/**
 * Class OrderSeeder
 */
class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Placed'],
            ['name' => 'Processed'],
            ['name' => 'Delivered'],
            ['name' => 'Completed']
        ];

        foreach ($statuses as $status) {
            $newStatus = new \App\OrderStatus();
            $newStatus->name = $status['name'];
            $newStatus->save();
        }
    }
}
