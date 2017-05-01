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
            ['name' => 'Placed', 'classes' => '<i class="glyphicon glyphicon-folder-close col-md-12"></i>'],
            ['name' => 'Processed', 'classes' => '<i class="glyphicon glyphicon-folder-close col-md-12"></i>'],
            ['name' => 'Delivered', 'classes' => '<i class="glyphicon glyphicon-folder-close col-md-12"></i>'],
            ['name' => 'Completed', 'classes' => '<i class="glyphicon glyphicon-folder-close col-md-12"></i>']
        ];

        foreach ($stages as $key => $stage) {
            $newStage = new \App\Stage();
            $newStage->name = $stage['name'];
            $newStage->classes = $stage['classes'];
            $newStage->save();
        }
    }
}
