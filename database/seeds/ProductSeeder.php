<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {

            $product = [
                'name' => $faker->word,
                'price' => $faker->randomFloat(2, 0, 99),
                'description' => $faker->paragraph(8)
            ];

            $productModel = new \App\Product();
            $productModel->fill($product);
            $productModel->save();
        }
    }
}
