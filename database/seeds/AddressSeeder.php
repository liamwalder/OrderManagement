<?php

use Illuminate\Database\Seeder;

/**
 * Class AddressSeeder
 */
class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('en_GB');
        for ($i = 0; $i < 13; $i++) {

            $customerId = ($i + 1);
            if ($customerId > 10) {
                $customerId = rand(1, 10);
            }

            $address = [
                'customer_id' => $customerId,
                'address_1' => $faker->streetAddress,
                'town' => $faker->city,
                'county' => $faker->country,
                'postcode' => $faker->postcode
            ];

            $addressModel = new \App\Address();
            $addressModel->fill($address);
            $addressModel->save();
        }
    }
}
