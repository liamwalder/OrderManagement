<?php

use Illuminate\Database\Seeder;

/**
 * Class OrderStageSeeder
 */
class OrderStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = [
            ['name' => 'Placed'],
            ['name' => 'Processed'],
            ['name' => 'Delivered'],
            ['name' => 'Completed']
        ];

        foreach ($stages as $stage) {
            $newStage = new \App\OrderStage();
            $newStage->name = $stage['name'];
            $newStage->save();
        }
    }
}
