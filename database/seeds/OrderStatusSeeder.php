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
        $statuses = ['Placed', 'Delivered', 'Processed', 'Completed'];

        foreach ($statuses as $status) {
            $newStatus = new \App\OrderStatus();
            $newStatus->name = $status;
            $newStatus->save();
        }
    }
}
