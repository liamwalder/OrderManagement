<?php

use Illuminate\Database\Seeder;

/**
 * Class CustomerSeeder
 */
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('en_GB');
        for ($i = 0; $i < 10; $i++) {
            $customer = [
                'firstname' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => bcrypt($faker->password)
            ];

            $customerModel = new \App\Customer();
            $customerModel->fill($customer);
            $customerModel->save();
        }
    }
}
