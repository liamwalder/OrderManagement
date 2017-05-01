<?php

use Illuminate\Database\Seeder;

/**
 * Class StageSeeder
 */
class StageSeeder extends Seeder
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

        foreach ($stages as $key => $stage) {
            $newStage = new \App\Stage();
            $newStage->name = $stage['name'];
            $newStage->save();
        }
    }
}
